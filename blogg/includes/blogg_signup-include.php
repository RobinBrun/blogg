<?php

/*
    Denna kod checkar om submit button var tryckt i signup form. 
    denna kod fångar in user input och kallar flera
    funktioner för att validera data. Om någon input är toma 
    eller invalid då kommer koden rederecta användaren till en sida
    med error koden i urlen för att man ska se vad som har gått snett.
    Om userinput är valid då kallar koden funktioner som finns i 
    function-include.php för att redirecta användaren till en annan sida
    Koden innehåller även error handling för att preventa unauthorized 
    access till bloggen och för att preventa SQL injection attacker. 
*/

if (isset($_POST["submit"])){

$name = $_POST["name"];
$email = $_POST["email"];
$username = $_POST["uid"];
$pwd = $_POST["pwd"];
$pwdRepeat = $_POST["pwdrepeat"];
//Felhantering vid misinput vid signup

require_once 'dbh-include.php';
require_once 'functions-include.php';

//Om någon input är null
// !== gör så att om det blir NÅGOT annat än false så är det en error -
//istället för == true för då kan det hamna fler saker som då kommer anses som en icke error
//
if(emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat ) !== false){
    //error=emptyinput för att jag ska kunna se om error =emptyinput för att då visa för användaren med
    //tillexempel if(error=emptyinput){echo "error";} att det är fel
    header("location: ../blogg_signup.php?error=emptyinput");
    //Stannar scriptet 
    exit();
}

if(invalidUid($username) !== false){
    header("location: ../blogg_signup.php?error=invaliduid");
    exit();
}

if(invalidEmail($email) !== false){
    header("location: ../blogg_signup.php?error=invalidemail");
    exit();
}

if(pwdMatch($pwd, $pwdRepeat) !== false){
    header("location: ../blogg_signup.php?error=passwordsdontmatch");
    exit();
}
//Om user redan finns i basen
if(uidExists($conn, $username, $email) !== false){
    header("location: ../blogg_signup.php?error=usernametaken");
    exit();
}
//Exempel på en till error handler .. if password är större än 6 charcters *för att få mer säkert
//Om usern har kommit ända hit, då är det inga errors :)


createUser($conn, $name, $email, $username, $pwd);

}
else{
    header("location ../blogg_signup.php");
    exit();
}