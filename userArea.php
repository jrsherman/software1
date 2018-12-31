<?php

    require_once __DIR__ .'/php/functions/functions.php';
    forceHTTPS();//use function to force https
    require_once __DIR__ .'/php/models/Order.php';
    require_once __DIR__ .'/php/repository/OrderRepository.php';
    session_start();
    
    //ONLY ALLOWING END USERS TO THIS PAGE IF THEY ARE LOGGED IN
    if (!isset($_SESSION['loggedIn'])||$_SESSION['loggedIn'] == false){
        echo "<script> window.location.assign('http://jsherma1.create.stedwards.edu/WeGo/')</script>"; //reroutes the end user to log in page
    }
    //CONTACT SUPPLY API TO ACCESS ROBOTAXI DATA
    $urlAllCarsInService = 'https://ishakar.create.stedwards.edu/robotaxi/PHP/api/supplyApi.php?'; //url for supply api
    $responseToAllCarsInService = json_decode(file_get_contents($urlAllCarsInService), 1); //client sends url to supply api and response is saved to variable $responseToAllCarsInService
    if (empty($responseToAllCarsInService)) {//checking to see if a response came back from the supply server if it didn't the variable will be empty
       echo "Could not reach supplier server check back in a few mintues...\n";
       throw new Exception("$responseToAllCarsInService came back empty");
    }
    $totalCarsInService = sizeof($responseToAllCarsInService['data']); //accesses the data from the json object saved to $responseToAllCarsInService and records how many cars are in use
    $vehiclesAreAvailableForUse = true;
    $listOfListsContainingSupplyVehicleLatLong= array();//SETTING GLOBAL ARRAY VARBIABLE WITH SUPPLY VEHICLE LAT LONGS
    if($totalCarsInService==0){//if there are no cars in service 
        $vehiclesAreAvailableForUse = false; 
    }else{
        for($i=0;$i<$totalCarsInService;$i++){//push all cars in service to $listOfListsContainingSupplyVehicleLatLong
            $singleVehicle=array($responseToAllCarsInService['data'][$i]['vehicleLatitude'],$responseToAllCarsInService['data'][$i]['vehicleLongitude']);
            array_push($listOfListsContainingSupplyVehicleLatLong,$singleVehicle); //adding the lat and long data from each of the vehicles in the json data array recieved
        }
    }
    //SETTING USEFULL GLOBAL VARIABLES FOR USE IN mapExecute in FUNCTIONS DIRECTORY
    $timeToTravel =0;
    $pickUpLocationLat =30.2672;
    $pickUpLocationLong = -97.7431;
    $destinationLat = -97.7431;
    $destinationFound = false;
    $driveTime = 0;
    $driveDistance = 0;
    $locationSet = false;
    $encodedPolyline = 0;
    
    
    $tripCreated = false;
    $pickuplocationKeyValueObject = null;
    $destinationLocationKeyValueObject = null;
    ?>
    <!--Input Street Address Verification-->
    <?php require_once __DIR__ .'/php/functions/addressVerification.php'; ?>
    <!--Handles Order Requests and Encoding Paths -->
    <?php require_once __DIR__ .'/php/functions/orderRequests.php';?>
    <!--Inserting Head and Opening Body Tag-->
    <?php require_once __DIR__ .'/php/view/header.php';?>
    <!-- AUDIO INCLUDES-->
		<?php if( $_SESSION['loggingIn']==true){ ?><!--checking to see if the user has already logged in and is not just refreshing the page-->
        <audio controls autoplay style="display:none">
            <source src="audio/welcomeAudio.mp3" type="audio/mpeg">
            <source src="audio/welcomeAudio.ogg" type="audio/ogg">
        </audio>
           <audio controls autoplay style="display:none">
            <source src="audio/chimeAudio.mp3" type="audio/mpeg">
            <source src="audio/chimeAudio.ogg" type="audio/ogg">
        </audio>
        <?php  $_SESSION['loggingIn']=false; }?>
        <audio id='vehicleArrived' controls style="display:none">
            <source src="audio/vehicleArrivedAudio.mp3" type="audio/mpeg">
            <source src="audio/vehicleArrivedAudio.ogg" type="audio/ogg">
        </audio>
        <audio id='vehicleArrivedVoice' controls style="display:none">
            <source src="audio/vehicleArrivedVoiceAudio.mp3" type="audio/mpeg">
            <source src="audio/vehicleArrivedVoiceAudio.ogg" type="audio/ogg">
        </audio>
        <audio id='arrivedAtDestination' controls style="display:none">
            <source src="audio/arrivedAtDestinationAudio.mp3" type="audio/mpeg">
            <source src="audio/arrivedAtDestinationAudio.ogg" type="audio/ogg">
        </audio>
        <audio id='vehicleComing' controls style="display:none">
            <source src="audio/vehicleComingAudio.mp3" type="audio/mpeg">
            <source src="audio/vehicleComingAudio.ogg" type="audio/ogg">
        </audio>
		<!-- END AUDIO INCLUDES -->	
		<div id="transpoWrapper"><!--begin address input wrapper (this is fixed position in css  can go anywhere)-->
            <div id="invisBox">
            Size of Fleet:
              <?php  echo $totalCarsInService; ?> vehicles
              <br />
            Drive Distance: 
            <?php echo $driveDistance; ?><!--output data of DRIVE DISTANCE-->
            <br />
            Drive Time: 
            <?php echo $driveTime; ?><!--output data of DRIVE TIME-->
            <br />
            <?php if($tripCreated){echo "trip created";}?><!--output data of DRIVE TIME-->
        </div>
        <div id="transportationTab"><!--TransportationTab (user inputs pickup address,user inputs destination address )-->
            <form action="https://jsherma1.create.stedwards.edu/WeGo/userArea.php" method="post">
                Pickup Location: <div id="locationField">
                <input id="autocomplete" autocomplete="off" placeholder="Enter your address" type="text" name="currentLocation" required></div>
                Desired destination : 
                <input id="autocomplete2" autocomplete="off" placeholder="Destination address" type="text" name="desiredDestination" required><br>
                <input type="submit" value="Order Ride"><br />
                Passenger Capacity:
                <select name="passengerCapacity">
                    <option value="1">1 passenger</option>
                    <option value="2">2 passengers</option>
                    <option value="3">3 passengers</option>
                    <option value="4">4 passengers</option>
                </select>
            </form>
            <a href="./php/functions/logout.php">Logout</a>
            
        </div><!--end transportstion tab-->
    </div><!--end transpo wrapper-->
    <div class='contentArea'><!--begin content area-->
        <h2>Welcome back, <?php echo $_SESSION['CustomerFirstName']." ".$_SESSION['CustomerLastName'];?></h2>
    <div id="map"><!--map area begins-->
        <?php require_once __DIR__ .'/php/functions/mapExecution.php';?>
</div><!--map area ends-->
</div>
    <!--autocomplete form scripts -->   
    <script>
      var input = document.getElementById('autocomplete');
      var autocomplete = new google.maps.places.Autocomplete(input);
      var input2 = document.getElementById('autocomplete2');
      var autocomplete2 = new google.maps.places.Autocomplete(input2);
    </script>
    <!--end autocomplete form scripts --> 
<!--Begin Blue Strip Style Bar-->
    	<div class='container-fluid bg-2 text-center' id='contentArea1'>
		</div><!--End Blue Strip Style Bar-->
		
		
<?php require_once __DIR__ .'/php/view/footer.php';?>
