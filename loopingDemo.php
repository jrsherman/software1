    <!--Inserting Head and Opening Body Tag-->
    <?php require_once __DIR__ .'/php/view/header.php';?>
    <!--Content Begins-->
    <div id='contentWrapper'>
        <div class='logInForm' style="height:500px;width:600px;">
            <h2 style="margin-bottom:-40px;">Demo Video</h2>
               <video controls loop  width="620" height="440" id="sampleMovie"  src="https://jsherma1.create.stedwards.edu/WeGo/video/loopingDemo.mov" controls></video>
        </div><!--End log In Form-->
    </div><!--Content Ends-->
    <!--Begin Blue Strip Style Bar-->
    	<div class='container-fluid bg-2 text-center' id='contentArea1'>
		</div><!--End Blue Strip Style Bar-->
    <?php require_once __DIR__ .'/php/view/footer.php';//inserts bottom section of the html ?>
