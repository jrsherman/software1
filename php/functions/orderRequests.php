<?php
if ( isset($response['results'][0])&&isset($response2['results'][0])){ //if responses both have return values 
            $tripCreated= true;
            $pickuplocationKeyValueObject = $response['results'][0]['geometry']['location'];
            $destinationLocationKeyValueObject = $response2['results'][0]['geometry']['location'];
            
            $pickUpLocationLat = $pickuplocationKeyValueObject['lat'];
            $pickUpLocationLong =$pickuplocationKeyValueObject['lng'];
            $destinationLat = $destinationLocationKeyValueObject['lat'];
            $destinationLong =$destinationLocationKeyValueObject['lng'];

            $indexOfCarSent = 0;
            $distanceBetweenPickUpPositionAndVehicle = 10000000000000;
            
            for($i=0;$i<$totalCarsInService;$i++){

                $urlDistanceBetweenCurrentAVehicle = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$pickUpLocationLat.",".$pickUpLocationLong."&destinations=".$listOfListsContainingSupplyVehicleLatLong[$i][0].",".$listOfListsContainingSupplyVehicleLatLong[$i][1]."&mode=driving&sensor=false";
                $distanceResponse = json_decode(file_get_contents($urlDistanceBetweenCurrentAVehicle),1);
                
                
                if (empty($distanceResponse)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
                    echo "Could not reach vehicle supply server check back in a few mintues...\n";
                    throw new Exception("$distanceResponse came back empty");
                    }
                $driveDistance = $distanceResponse['rows'][0]['elements'][0]['distance']['text'];
                if (empty($driveDistance)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
                    error_log('Cant calculate distance between pickup location and vehicle'.$i);
                    $driveDistance=1000000000;
                    }
                $driveDistance = str_replace(' ', '', $driveDistance);
                $driveDistance = str_replace('km', '', $driveDistance);
                if($driveDistance<$distanceBetweenPickUpPositionAndVehicle){
                    $distanceBetweenPickUpPositionAndVehicle =$driveDistance;
                    $indexOfCarSent = $i;
                }
            }
            //FIRST PATH IS FOR DRAW ROUTE BLUE LINE PATH
            
            $urlPathMaker = "https://maps.googleapis.com/maps/api/directions/json?origin=".$listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][0].",".$listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][1]."&destination=$destinationLat,$destinationLong&waypoints=$pickUpLocationLat,$pickUpLocationLong&sensor=false";
            $response3 = json_decode(file_get_contents($urlPathMaker), 1);
            if (empty($response3)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
            echo "Could not reach pathMaker server check back in a few mintues...\n";
            throw new Exception("$response3 came back empty");
            }
             else if ($response3[status]== 'ZERO_RESULTS') {//checking to see if a response came back from the supply server if it didn't the variable will be empty
                echo '<script>alert("No Results Found for pathmaker ")</script>';
            }
            $encodedPolyline = $response3['routes'][0]['overview_polyline']['points'];//add waypoint here
            
            //FIRST LEG IS FOR THE POLYLINE PATH FROM THE VEHICLE TO THE PICKUP POINT
            //first leg
            $urlOfFirstLeg = "https://maps.googleapis.com/maps/api/directions/json?origin=".$listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][0].",".$listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][1]."&destination=$pickUpLocationLat,$pickUpLocationLong&sensor=false";
            $responseFirstLeg = json_decode(file_get_contents($urlOfFirstLeg), 1);
            
            if (empty($responseFirstLeg)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
            echo "Could not reach pathMaker server check back in a few mintues...\n";
            throw new Exception("$responseFirstLeg came back empty");
            }
             else if ($responseFirstLeg[status]== 'ZERO_RESULTS') {//checking to see if a response came back from the supply server if it didn't the variable will be empty
                echo '<script>alert("No Results Found for $responseFirstLeg ")</script>';
            }
               else if($responseFirstLeg['routes'][0]['overview_polyline']['points']==null){
                echo "Could not encode first leg of path api response error: refresh page to continue order\n";
                throw new Exception("$responseFirstLeg path came back empty api response error: refresh page to continue order");
                
            }
            
            
            $encodedPolylineFirstLeg = $responseFirstLeg['routes'][0]['overview_polyline']['points'];//add waypoint here
            //second leg
            
            //SECOND LEG IS FOR THE POLYLINE PATH FROM THE PICKUP POINT TO THE DESTINATION
            $urlOfSecondLeg = "https://maps.googleapis.com/maps/api/directions/json?origin=$pickUpLocationLat,$pickUpLocationLong&destination=$destinationLat,$destinationLong&sensor=false";
            $responseSecondLeg = json_decode(file_get_contents($urlOfSecondLeg), 1);
            if (empty($responseSecondLeg)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
            echo "Could not reach pathMaker server check back in a few mintues...\n";
            throw new Exception("$responseSecondLeg came back empty");
            }
             else if ($responseSecondLeg[status]== 'ZERO_RESULTS') {//checking to see if a response came back from the supply server if it didn't the variable will be empty
                echo '<script>alert("No Results Found for $responseSecondLeg ")</script>';
            }
            else if($responseSecondLeg['routes'][0]['overview_polyline']['points']==null){
                echo "Could not encode second leg of path api response error: refresh page to continue order\n";
                throw new Exception("$responseSecondLeg path came back empty api response error: refresh page to continue order");
                
            }
            $encodedPolylineSecondLeg = $responseSecondLeg['routes'][0]['overview_polyline']['points'];//add waypoint here
            $locationSet = true;
            
             //get driving distance and durration
        $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$pickUpLocationLat.",".$pickUpLocationLong."&destinations=".$destinationLat.",".$destinationLong."&mode=driving&sensor=false";
        $json = file_get_contents($details);
        $details = json_decode($json, TRUE);
        $driveTime = $details['rows'][0]['elements'][0]['duration']['text'];
        $driveDistance = $details['rows'][0]['elements'][0]['distance']['text'];
        $newOrder = new Order(-1,$pickUpLocationLong,$pickUpLocationLat,$destinationLong,$destinationLat,$listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][1],$listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][0],$driveTime,$_SESSION['CustomerId']);
        OrderRepository::insertOrder($newOrder);
        $currentLocation = $_POST["currentLocation"];
        $desiredDestination = $_POST["desiredDestination"];
        }//end order request
        
        ?>