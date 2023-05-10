<?php
session_start();
?>


<!--
    PHP och tml fil som innehåller ett formulär för signup
    med alla input fält som krävs för att kunna signa upp.
    Denna innehåller error handling för att checka om någon
    input är tom eller username / email is invalid. Den 
    checkar också password matchar och om användarnamnet 
    redan är taget. 
    Om allt är successful eller fel så kommer det dycka
    upp på skrämen för användaren att läsa som tillexempel
    "Signup successful" eller "Password did not match"

 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogg</title>
   <!-- <link rel="stylesheet" href="css/styles.css"> -->
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
<div class="Bar">
<header> 
  <!-- links-->
  <nav>
    <div class="wrapper">
    <!-- Unordered List -->
    <ul class="nav__links">
      <!-- List Element -->
    </ul>
    </div>
  </nav>
  <!-- link tag -->
</header>
</div>



<div class="signup-box">

<section class="signup-form">
<h1>Sign Up</h1>
<div class="signup-form-form">
<!-- blogg_signup-include.php är en php fil som körs-->
<form action="includes/blogg_signup-include.php" method="post">
  <input type="text" name="name" placeholder="Full Name...">
  <input type="text" name="email" placeholder="Email...">
  <input type="text" name="uid" placeholder="Username...">
  <input type="password" name="pwd" placeholder="Password...">
  <input type="password" name="pwdrepeat" placeholder="Repeat Password...">
  <button type="submit" name="submit">Sign Up</button>
</form>
<h2>Already own an account?</h2>
  <a href="blogg_login.php"><button>Log In</button></a>
<?php
if(isset($_GET["error"])){
  if($_GET["error"] == "emptyinput") {
    echo "<p>Fill in all fields!</p>";
  }
  else if ($_GET["error"] == "invaliduid"){
    echo "<p>Pick a proper username!</p>";
  }
  else if ($_GET["error"] == "invalidemail"){
    echo "<p>Pick a proper email!</p>";
  }
  else if ($_GET["error"] == "passwordsdontmatch"){
    echo "<p>Passwords do NOT match!</p>";
  }
  else if ($_GET["error"] == "stmtfailed"){
    echo "<p>Something went wrong, try again!</p>";
  }
  else if ($_GET["error"] == "usernametaken"){
    echo "<p>Username taken!</p>";
  }
  else if ($_GET["error"] == "none"){
    echo "<h3>Successfully signes up!</h3>";
  }
}
 ?>
</div>

</div>
</section>

</body>
</html> 