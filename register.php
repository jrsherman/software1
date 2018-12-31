<?php
    require_once __DIR__ .'/php/functions/functions.php';
    forceHTTPS();//use function to force https
    require_once __DIR__ . "/php/repository/CustomerRepository.php";
    require_once __DIR__ . "/php/models/Customer.php";
    session_start();
    if(isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn'] == 1){
         echo "<script> window.location.assign('https://jsherma1.create.stedwards.edu/WeGo/userArea.php')</script>"; //if already logged in send user to user area
    }
    $customerExists = null;
    if(isset($_POST['firstName'])&&isset($_POST['lastName'])&&isset($_POST['userPassword'])&&isset($_POST['userName'])){
        $userName = $_POST['userName'];
        $customerExists = CustomerRepository::customerExistsByUsername($userName);
        //boolean false returns '' when converted to false from a string 
        if(!$customerExists){
            $password = password_hash($_POST['userPassword'], PASSWORD_DEFAULT);
            $newUser = new Customer(7,$_POST['firstName'],$_POST['lastName'],-1000,-1000,$_POST['userName'],$password);
            CustomerRepository::insertCustomer($newUser);
             $_SESSION['loggingIn'] = true;
            $customerModel = CustomerRepository::getCustomerByUsername($_POST['userName']);
            $_SESSION['loggedIn'] = 1;
            $_SESSION['CustomerFirstName'] = $customerModel->getCustomerFirstName();
            $_SESSION['CustomerLastName'] = $customerModel->getCustomerLastName();
            $_SESSION['CustomerLongitude'] = $customerModel->getCustomerLongitude();
            $_SESSION['CustomerLatitude'] = $customerModel->getCustomerLatitude();
            $_SESSION['CustomerId'] = $customerModel->getCustomerId();
            $_SESSION['CustomerUserName'] = $customerModel->getUserName();
            echo "<script> window.location.assign('https://jsherma1.create.stedwards.edu/WeGo/userArea.php')</script>";
        }
        else{
            
            echo '<script>alert("Username Taken: Try Another Username")</script>';
        }
    }
    ?>
    <!--Inserting Head and Opening Body Tag and related content-->
    <?php require_once __DIR__ .'/php/view/header.php';?>
<!--begin content-->
 <div id='contentWrapper'>
    <div class='logInForm'>
        <h2>Register</h2>
    <?php require_once __DIR__ .'/php/userForms/registerForm.php'; //inserts registration form?>
    </div><!--end content-->
 </div>
   <!--Begin Blue Strip Style Bar-->
    	<div class='container-fluid bg-2 text-center' id='contentArea1'>
		</div><!--End Blue Strip Style Bar-->
    <?php require_once __DIR__ .'/php/view/footer.php';//inserts footer section of html ?>
	    
