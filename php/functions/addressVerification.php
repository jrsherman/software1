   <?php if(isset($_POST["passengerCapacity"])&&isset($_POST["currentLocation"])&&isset($_POST["desiredDestination"])){//if end user has sent a pickup point and destination to the server
        $urlPickupLocation = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST["currentLocation"]).'&sensor=false&key=AIzaSyDCQ3dKhp-rN9q1vgJ2gY0n_csNN6Iplys';//doesnt send the url till file get contents
        $response = json_decode(file_get_contents($urlPickupLocation), 1);
        if (empty($response)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
            echo "Could not reach destination server check back in a few mintues...\n";
            throw new Exception("$response came back empty");
            }
        else if ($response[status]== 'ZERO_RESULTS') {//checking to see if a response came back from the supply server if it didn't the variable will be empty
            echo '<script>alert("No Results Found For Pick Up Location")</script>';
        }
        $urlDesiredDestination = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($_POST["desiredDestination"]) .'&sensor=false&key=AIzaSyDCQ3dKhp-rN9q1vgJ2gY0n_csNN6Iplys';
        $response2 = json_decode(file_get_contents($urlDesiredDestination), 1);
         if (empty($response2)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
            echo "Could not reach destination server check back in a few mintues...\n";
            throw new Exception("$response2 came back empty");
            }
        else if ($response2[status]== 'ZERO_RESULTS') {//checking to see if a response came back from the supply server if it didn't the variable will be empty
            echo '<script>alert("No Results Found For destination location")</script>';
        }
    }?>