<?php
/*
  Denna php kod connectar till en mysql databse using mysqli som är bättre än
  mySQL.

  första koden skapar 4 variablar information som är necessary för att kunna
  connecta överhuvud taget till databasen. server name, database username,
  database password,   and the name of the database.

  Nästa kod använder mysqli_connect() funktionen för att connecta till databasen.
  Denna funktion tar server namn, datatbase username, database password
  och database namn som argument och returnerar en connection object om 
  connectionen är successful. 

 Om connectionen failar så använder koden die() funktionen för att stanna scriptet
*/
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "blogg";
//Använder mySQLi eftersom att den tydlige när up to date oc här mycket säkrare än mySQL
$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

//Om connectionen failar 
if(!$conn){
  die("Connection Failed: " . mysqli_connect_error());
}