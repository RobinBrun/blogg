<?php

/*
     Denna php kod checkar om formuläret med submit knapp har blivit submitad
     och som den har blivit submitat så retrievar den username och lösenord
     fälten genom att använda POST method. 
*/


if ( isset($_POST["submit"])){
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    //Referat
    require_once 'dbh-include.php';
    require_once 'functions-include.php';
                      //username
    if(emptyInputLogin($username, $pwd) !== false){
        //error=emptyinput för att jag ska kunna se om error =emptyinput för att då visa för användaren med
        //tillexempel if(error=emptyinput){echo "error";} att det är fel
        header("location: ../blogg_login.php?error=emptyinput");
        //Stannar scriptet 
        exit();
    }

    loginUser($conn, $username, $pwd);
}
else{
    header("location: ../blogg_index.php");
    //Stannar scriptet 
    exit();
}