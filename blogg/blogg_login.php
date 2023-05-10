<?php
session_start();
?>
<!--
    Denna sida som har php och html kod är till för login page. 
    Koden startar med en session. Sedan med HTML formulär
    med alla uppgifter som krävs för att kunna logga in. 
    som använder php för att submita datan. PHP koden 
    innehåller error handling för om användaren inte fyller i 
    alla fält eller om login informationen är inkorrekt
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogg</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="signup-box">

<section class="signup-form">
<h1>Login</h1>
<div class="signup-form-form">
<!-- blogg_signup-include.php är en php fil som körs-->
<form  action="includes/blogg_login-include.php" method="post">
  <input type="text" name="uid" placeholder="Username/Email...">
  <input type="password" name="pdw" placeholder="Password...">
  <button type="submit" name="submit">Login</button>
  <h2>Do not own an account?</h2>
</form>
<a href="blogg_signup.php"><button>Signup</button></a>
<!-- samma error handling nonsens som i signup.php -->
<?php

if(isset($_GET["error"])){
  if($_GET["error"] == "emptyinput") {
    echo "<p>Fill in all fields!</p>";
  }
  else if ($_GET["error"] == "wrongLogin"){
    echo "<p>Incorrect Login Information!</p>";
  }
}
 ?>

 <?php
 /*
if(isset($_GET["error"])){
  if($_GET["error"] == "emptyinput") {
    echo "<p>Fill in all fields!</p>";
  }
  else if ($_GET["error"] == "wrongLogin"){
    echo "<p>Incorrect Login Information!</p>";
  }
}
*/
 ?>


</div>
</section>






</body>
</html> 