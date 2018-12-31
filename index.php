<?php
    require_once __DIR__ .'/php/functions/functions.php';
    forceHTTPS();//force https
    require_once __DIR__ . "/php/repository/CustomerRepository.php";
    require_once __DIR__ . "/php/models/Customer.php";
    session_start();
    if(isset($_SESSION['loggedIn'])){//checks to see if user is already logged into a session
        if($_SESSION['loggedIn'] == true){//if already logged in 
        echo "<script> window.location.assign('https://jsherma1.create.stedwards.edu/WeGo/userArea.php')</script>";//redirect to user area
        }
    }
    //LOG IN CREDENTIALS VERIFICATION & USER DATA STORED TO SESSION
    if(isset($_POST['userName'])&&isset($_POST['userPassword'])){
        $userName = $_POST['userName'];//username
        $userPassword = $_POST['userPassword'];//password
        $customerModelExists = CustomerRepository::customerExistsByUsername($userName);//look for user name
        if($customerModelExists){//if username comes back, check password
            $customerModel = CustomerRepository::getCustomerByUsername($userName);//we just went and got the model from the database
            if (password_verify($userPassword, $customerModel->getPassword())) {//if password works go ahead and log in and gerav data
                $customerModel->password = '';
                $_SESSION['loggedInCustomer'] = serialize($customerModel);
                $_SESSION['loggedIn'] = 1;
                $_SESSION['loggingIn'] = true;
                $_SESSION['CustomerFirstName'] = $customerModel->getCustomerFirstName();
                $_SESSION['CustomerLastName'] = $customerModel->getCustomerLastName();
                $_SESSION['CustomerLongitude'] = $customerModel->getCustomerLongitude();
                $_SESSION['CustomerLatitude'] = $customerModel->getCustomerLatitude();
                $_SESSION['CustomerId'] = $customerModel->getCustomerId();
                $_SESSION['CustomerUserName'] = $customerModel->getUserName();
                echo "<script> window.location.assign('https://jsherma1.create.stedwards.edu/WeGo/userArea.php')</script>";
            }
            else{
                  echo '<script>alert("Incorrect Credentials")</script>';
            }
        }
        else{
                  echo '<script>alert("Incorrect Credentials")</script>';
            }
    }//END LOG IN VERIFY
  ?>
    <!--Inserting Head and Opening Body Tag-->
    <?php require_once __DIR__ .'/php/view/header.php';?>
    <!--Content Begins-->
    <div id='contentWrapper'>
        <div class='logInForm'>
        
            <h2>Sign In</h2>
    <?php
        if (isset($_SESSION['loggedIn'])&&!$_SESSION['loggedIn']) {
            $_SESSION['loggedIn'] = false;
            echo "Customer and Password Combination do not Exist";
            print "<p>Login failed.  Try user: 'HP' and password 'wand'</p> \n";
        }
    ?>
    <?php  require_once __DIR__ .'/php/userForms/logInForm.php';//Displays User Log In Form ?>
        </div><!--End log In Form-->
    </div><!--Content Ends-->
    <!--Begin Blue Strip Style Bar-->
    	<div class='container-fluid bg-2 text-center' id='contentArea1'>
		</div><!--End Blue Strip Style Bar-->
    <?php require_once __DIR__ .'/php/view/footer.php';//inserts bottom section of the html ?>
