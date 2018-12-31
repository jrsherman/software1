<?php
  class Foo {
    public $aMemberVar = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';
   
   
    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }
}

$foo = new Foo; 
            ?>
        
       <!DOCTYPE html><!--THE VIEW STARTS HERE -->
		<html lang='en'>
		  	<head>
			    <meta charset='utf-8'>
			    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
			    <meta name='description' content='We Go Map Service'>
			    <meta name='author' content='Team 21 Savage'>
			    <link rel='icon' href='images/favicon-32x32.png' type='image/x-icon'>
			    <!--  linked javascript libraries and apis here  -->
			    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'> </script>
			    
			     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
			    
			    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js' integrity='sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1' crossorigin='anonymous'></script>
			    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyDCQ3dKhp-rN9q1vgJ2gY0n_csNN6Iplys&libraries=geometry&amp"></script>
			    <script src="js/jquery.knob.min.js"></script>
			    <!--  style sheet linked in here  -->
			    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
			  	<link rel='stylesheet' type='text/css' href='./css/weGoStyles.css'>
			   	<title>We Go</title>
			</head>
			<!--  body of document starts here  -->
			<body>
			    <!--beginSite Wrapper-->
                <div id='siteWrapper'>
			    	<div class='jumbotron text-center'>

					<a href="http://jsherma1.create.stedwards.edu/WeGo/">
                        <img src="https://jsherma1.create.stedwards.edu/WeGo/images/wegoLogo.png" alt="Clickable image" style="width:291px;height:101px;">
                    </a>
					<p class='fadeInText1'style="margin-top:20px;">Transportation Services</p>
				</div>
			<?php 
			   $element = 'aMemberVar';
                //print $foo->$element;
			
			?>
				