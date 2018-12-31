  <script>
          
          //PATH COORDINATE STRING FROM orderRequest.php TURNED JS READABLE
           var encodedPolylineFirstLeg = <?php echo json_encode($encodedPolylineFirstLeg); ?>; //
           var encodedPolylineSecondLeg = <?php echo json_encode($encodedPolylineSecondLeg); ?>; 
           var encodedPolylineFromPhp = <?php echo json_encode($encodedPolyline); ?>;
           var decodedPath;
           var decodedPathFirstLeg;
           var decodedPathSecondLeg;
           //END USER PICK UP LOCATION COORDINATES
           var pickUpLocationLongFromPhp=<?php echo json_encode($pickUpLocationLong); ?>;
           var pickUpLocationLatFromPhp=<?php echo json_encode($pickUpLocationLat); ?>;
           
            var indexOfPickPickupLocationInCarPath;
            //DECODE FIRST AND SECOND LEG OF TRIP INTO ARRAY OBJECTS
            if(encodedPolylineFromPhp!=0&&encodedPolylineSecondLeg!=0&&encodedPolylineFirstLeg!=0){
                decodedPathFirstLeg = google.maps.geometry.encoding.decodePath(encodedPolylineFirstLeg);
                decodedPathSecondLeg = google.maps.geometry.encoding.decodePath(encodedPolylineSecondLeg);
                decodedPath = google.maps.geometry.encoding.decodePath(encodedPolylineFromPhp);
                for(var i=0; i<decodedPath.length;i++){//this is trying to find waypoint we can delete
                    if(decodedPath[i].toString()=='(<?php echo json_encode($pickUpLocationLat);?>,<?php echo json_encode($pickUpLocationLong);?>'){
                    }
                }
            }
            //CREATE JS ARRAY FROM THE VEHICLES AVAILABE INFO FROM USERREA.PHP 
            <?php $js_array = json_encode($vehicleArray); echo "var javascript_array = ". $js_array . ";\n";?>
            //DESTINATION LAT AND LONG
            var destinationLatFromPhp=<?php echo json_encode($destinationLat); ?>;
            var destinationLongFromPhp=<?php echo json_encode($destinationLong); ?>;
            
            var orderCreated=<?php echo json_encode($locationSet); ?>;
            
            //MAP FUNCTIONALITY BEGINS HERE
            function initMap() {
                var selectedVehicleForPickupLat = <?php echo json_encode($listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][0]); ?>;
                var selectedVehicleForPickupLong = <?php echo json_encode($listOfListsContainingSupplyVehicleLatLong[$indexOfCarSent][1]); ?>;
                if((selectedVehicleForPickupLat==null)&&(selectedVehicleForPickupLong==null)){
                    //SETTING DEFAULT MAP COORDINATES
                    selectedVehicleForPickupLat =30.2672;
                    selectedVehicleForPickupLong = -97.7431;
                }
                var pickUpLocationLongFromPhp=<?php echo json_encode($pickUpLocationLong); ?>;//where user is currently at or where they want to be picked up from
                var pickUpLocationLatFromPhp=<?php echo json_encode($pickUpLocationLat); ?>;
                var destinationLatFromPhp=<?php echo json_encode($destinationLat); ?>;
                var destinationLongFromPhp=<?php echo json_encode($destinationLong); ?>;
                var orderCreated=<?php echo json_encode($locationSet); ?>;
                
                var pointA = new google.maps.LatLng(selectedVehicleForPickupLat, selectedVehicleForPickupLong),
                pointB = new google.maps.LatLng(destinationLatFromPhp, destinationLongFromPhp),
                 <?php for($i=0;$i<$totalCarsInService;$i++){echo 'point'.$i.' = new google.maps.LatLng('.$listOfListsContainingSupplyVehicleLatLong[$i][0].','.$listOfListsContainingSupplyVehicleLatLong[$i][1].'),';}?>//create latlngpointsfor cars
                myOptions = { 
                    mapTypeId: 'roadmap',//this is where you place alterations to map
                    styles:[<?php mapStyle(); ?>],
                zoom: 10,
                center: pointA
            },
            map = new google.maps.Map(document.getElementById('map'), myOptions),//map get map by id
            // Instantiate a directions service.
            directionsService = new google.maps.DirectionsService,
            directionsDisplay = new google.maps.DirectionsRenderer({
                map: map
            }),
            <?php createFleet($listOfListsContainingSupplyVehicleLatLong,$totalCarsInService); ?>
            ;
        
        
        //IF ODER IS MADE DISPLAY THE PROJECTED PATH
        if(orderCreated){
            calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);
             var lineSymbol = {
          path: <?php svgMap(); ?>,
          rotation: -90,
          scale: .075,
          anchor: new google.maps.Point(325,167),
          strokeWeight: 2,
          strokeColor: '#1AA8F4',
          fillColor: '#9932CC'
        };
       var point = decodedPathFirstLeg[0].toString();
       var coordinatesDecoded = point.split(",");
       var coordinatesReadyForInsert = coordinatesDecoded[0].replace(/[()":*?<>{}]/g, '');
        var drivePlanCoordinates = new Array();
        for(i=0;i<decodedPathFirstLeg.length;i++)//corrects the decoded path to correct format of lat and long
        {  
            var point = decodedPathFirstLeg[i].toString();
            var coordinatesDecoded = point.split(",");
            var lat = coordinatesDecoded[0].replace(/[()":*?<>{}]/g, '');
            var long = coordinatesDecoded[1].replace(/[()":*?<>{}]/g, '');
            var pointDecoded =new google.maps.LatLng(lat,long);//each element is a sub array and now we split them wiith commas
            drivePlanCoordinates.push(pointDecoded); 
        }
        var line = new google.maps.Polyline(//line is our polyline var
            {path:drivePlanCoordinates,//should  go from point a to point b
             strokeColor: "#A864C8",
            strokeOpacity: 1.0,
            strokeWeight: 3,
          icons: [{
            icon: lineSymbol,
            offset: '100%'
          }],
          map: map
        });
        //second leg
       var point = decodedPathSecondLeg[0].toString();
       var coordinatesDecoded2 = point.split(",");
       var coordinatesReadyForInsert2 = coordinatesDecoded2[0].replace(/[()":*?<>{}]/g, '');
        var drivePlanCoordinates2 = new Array();
        for(i=0;i<decodedPathSecondLeg.length;i++)
        {  
            var point = decodedPathSecondLeg[i].toString();
            var coordinatesDecoded2 = point.split(",");
            var lat2 = coordinatesDecoded2[0].replace(/[()":*?<>{}]/g, '');
            var long2 = coordinatesDecoded2[1].replace(/[()":*?<>{}]/g, '');
            var pointDecoded2 =new google.maps.LatLng(lat2,long2);//each element is a sub array and now we split them wiith commas
            drivePlanCoordinates2.push(pointDecoded2); 
        }
        var line2 = new google.maps.Polyline(//line is our polyline var
            {path:drivePlanCoordinates2,//should  go from point a to point b
             strokeColor: "#A864C8",
            strokeOpacity: 1.0,
            strokeWeight: 3,
          icons: [{
            icon: lineSymbol,
            offset: '100%'
          }],
          map: map
        });
        line.setMap(map);
        var vehicleInUse= autoVehicle<?php echo $indexOfCarSent ?>;
        
        
        animateVehicle(line,line2,drivePlanCoordinates2,vehicleInUse,directionsDisplay);//EXECUTE VEHICLE ANIMATION
        }
    }
    //END INIT MAP FUNCTION
    //ANIMATE CAR FIRST LEG OF TRIP F(n)
    function animateVehicle(line,line2,drivePlanCoordinates,vehicleInUse,directionsDisplay) {
        
     //var Longitude = //coordinates from server
     //var Latitude = //coordinates from server
    // var latlng = new google.maps.LatLng(Latitude,Longitude);
     //marker.setPosition(latlng);

     //map.setCenter(latlng); // center your map on the marker location
        
        window.scrollTo(0, 180);
          //progress bar animation
          function routeProgressAnimation() {
            var sinedValue = Math.round((Math.sin(i)*8)+20);
            document.getElementById("contentArea1").style.backgroundColor= "rgb(27,"+(sinedValue*7)+",242)";
            i+=.04;
          }
          var routeProgressAnimationPointer = setInterval(function(){routeProgressAnimation()}, 10);//animation execute
 
          line.setVisible(false);
          line2.setVisible(false);
          document.getElementById("vehicleComing").play();
          var count = 0;
          var myVar = setInterval(function(){ myTimer()
          }, 40);
            function myTimer() {
                count = (count + 1) % 200;
                var icons = line.get('icons');
                icons[0].offset = (count / 2) + '%';
                //goes through the percentage of the line so it would scale to two lines if put through it moves the arrow as a percentage of line complete
                line.set('icons', icons);
                if(count<2)
                    vehicleInUse.setVisible(false);
                    line.setVisible(true);
                if(count==185){
                    document.getElementById("vehicleArrived").play();
                    document.getElementById("vehicleArrivedVoice").play();
                }
                if(count==199){
                    myStopFunction();
                    alert("Vehicle Has Arrived! click 'Okay' to begin trip");
                     line.setVisible(false);
                    animateVehicle2(line2,directionsDisplay,routeProgressAnimationPointer);
                }
            }
            function myStopFunction() {
                clearInterval(myVar);
            }
    }
    //END ANIMATE FIRST LEG OF TRIP
    //ANIMATE CAR FOR SECOND LEG OF TRIP F(n)
    function animateVehicle2(line2,directionsDisplay,routeProgressAnimationPointer) {
          var count = 0;
          var myVar = setInterval(function(){ myTimer()
          }, 40);
            function myTimer() {
                count = (count + .5) % 200;
                var icons = line2.get('icons');
                icons[0].offset = (count / 2) + '%';
                line2.set('icons', icons);
                if(count<2){
                    line2.setVisible(true);
                }
                if(count==195){
                    document.getElementById("vehicleArrived").play();
                    document.getElementById("arrivedAtDestination").play();
                }
                if(count==199){
                    myStopFunction();
                    directionsDisplay.setMap(null);
                    alert("Arrived at Destination");
                    clearInterval(routeProgressAnimationPointer);
                    document.getElementById("contentArea1").style.backgroundColor= "rgb(26,167,243)";
                    line2.setVisible(false);
                }
            }
            function myStopFunction() {
                clearInterval(myVar);
            }
    }
    //END ANIMATE SECOND LEG OF TRIP
    //CALCULATES PATH BETWEEN CLOSEST VEHICLE SELECTED AND DESTINATION USER HAS SELECTED AND DISPLAYS IT F(n)
    function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
        var pickupLocation = new google.maps.LatLng(pickUpLocationLatFromPhp,pickUpLocationLongFromPhp); //pickupLocation
        var wypt = [];
        wypt.push({//FORCES PATH TO ROUTE THROUGH USER PICKUP LOCATION
            location: pickupLocation
        });
        directionsService.route({
            origin: pointA,
            destination: pointB,
            waypoints: wypt,
            travelMode: 'DRIVING'
        },  function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
               
            } else {
                window.alert('No Path Currently Available CALC DISPLAY');
            }
        });
    }
    //initMap();
    //END CALC PATH CLST VEHICLE SELECTED
    </script>
    <!--async defer async defer -->
     <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCQ3dKhp-rN9q1vgJ2gY0n_csNN6Iplys&libraries=places&language=en&callback=initMap"></script>