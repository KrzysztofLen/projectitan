<?php

session_start();

  if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {


    header('Location: indexlog.php');
    exit();

  }


?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Application in PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	
	<link rel="shortcut icon" href="img/favicon.ico" />

    <!-- Bootstrap core CSS -->
    <link href="style/bootstrap.min.css" rel="stylesheet">

    <!-- Font awesome -->
    <link rel="stylesheet" href="ico/css/font-awesome.min.css">

    <!-- jQuery -->
    <script src="js/jquery-2.2.3.min.js"></script>

    <!-- Style LESS  -->
    <link rel="stylesheet" href="style/main.less" type="text/less">

    <!-- JS LESS -->
    <script src="js/less.min.js"></script>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">


  </head>
  <body id="index">
<div id="top-image"></div>


   <div class="container">
     <div class="box_log">
       <form action="zaloguj.php" method="post" id="login_form">

         <div class="login-heading">
           <!-- <i class="fa fa-lock" aria-hidden="true"></i> -->
           <h1>Login:</h1>
         </div>
         <div class="login-heading-social">
           <p>
             Log with <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a> or <a href=""><i class="fa fa-google-plus" aria-hidden="true"></i></a>
           </p>
         </div>


         <div class="form-group">
             <label class="login_data" for="login">Username:</label>
             <input class="form-control" type="text" name="login"  id="login-input" placeholder="Login" required>
           </div>
           <div class="form-group">
             <label class="login_data" for="password">Password:</label>
             <input class="form-control" type="password" name="password" id="password-input" placeholder="Password" required>
           </div>

           <input type="submit"  id="login-button-index" value="Log in">


           <!-- footer -->
             <div class="modal-footer">
                 <div class="options">
                   <p>Forgot <a href="remind.php">Password?</a></p>
                   <p>Not a member? <a href="#">Sign Up</a></p>
				   <p>Login: admin</p>
				   <p>Password: admin</p>
                 </div>
             </div>

           </form>
     </div>


      </div>





<?php

      if (isset($_SESSION['blad']))
      {
        echo($_SESSION['blad']);

      }
?>

<script src="js/custom.js" charset="utf-8"></script>
  </body>
</html>
<?php

if(!$_SESSION['zalogowany'])
{
  $_SESSION = array();
  session_destroy();
}
 ?>
