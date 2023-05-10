<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogg</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/slide.css">
    <link rel="stylesheet" href="css/väder.css">
</head>
<body>
<div class="Bar">
<header> 

<div class="Temp">
<div id="temperature">Laddar Celcius...</div>
<script>
//Sparar API nyckeln i en const
const API_KEY = "dc80e0c7ddf147a89f1e520ae4fb5aea";

//Checkar om användarens browser supportar geolocation 
if (navigator.geolocation) {
  //Om geolocation är supportad, ta geolocation av device
  navigator.geolocation.getCurrentPosition(position => {
    //Extrahera latitud och longitud från position
    const lat = position.coords.latitude;
    const lon = position.coords.longitude;

    //Skapar en URL för openweathermap API request från latitud och longtud samt API nyckeln
    const url = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=${API_KEY}&units=metric`;

    // Send a request to the OpenWeatherMap API using the constructed URL
    //Skickar en request till OpenWeatherMap API med URLen som skapades över
    fetch(url)
      .then(response => response.json()) // Parse JSON svaret från API
      .then(data => {
        //Tar temperaturen från svaret
        const temperature = data.main.temp;

        //Updaterar element med ID "temperature" med de hämtade temperatur values
        document.getElementById("temperature").innerHTML = `<h5>${temperature}°C</h5>`;
      })
  });
}

</script> 



</div>



  <!-- links-->
  <nav>
    <div class="wrapper">
    <!-- Unordered List -->
    <ul class="nav__links">
      <div class="link-container">
      <!-- List Element -->
      <li><a href="blogg_index.php">UPDATE TEMPERETURE</li>
      <li><a href="blogg_login.php">LOGIN</li>
      <li><a href="blogg_signup.php">SIGNUP</li>
      </div>
    </ul>
    </div>
  </nav>
  <!-- link tag -->
  <a clas="cta" href="blogg_login.php"><button>Log In</button></a>
</header>
</div>

<div class="Titel"> 
<h1>Min blogg som är rated 10 / 10 slides</h1>
</div>

<div class="Samman">
  <h2>En blogg som handlar om fina slides</h2>
</div>


<!-- Bild Div-->
<div class="slider">
  <img id="img-1" src="images/Slide.png">
  <img id="img-2" src="images/Slide2.png">
  <img id="img-3" src="images/Slide3.png">
</div>
<!-- Knapp Div -->
<div class="Rund-button">
  <!-- onClick, -->
  <span class="prick active" onclick="changeBild(0)"></span>
  <span class="prick" onclick="changeBild(1)"></span>
  <span class="prick" onclick="changeBild(2)"></span>
</div>

<script>
/*
       Denna javascript kod är en slideshow med automatisk bild transitions.
       Den settar current image index till 0 och time interval mellan image
       byten till 2000 millisekunder. changeBild() funktionen blir callad 
       flera gånger från setInterval() funktione. Vilket updaterar den 
       nuvarande bild index och ändrar alphan och "active state" av bilderna
       samt knapparna ändras passande. 
       Koden gör så att endast 1 av bilderna och 1 av control buttons är 
       aktiva åt gången. 
       */

  // För att selecta alla bilder 
var bilder = document.querySelectorAll('.slider img');
  // För att selecta alla control buttons (Pricks är prick i plural*)                                                kanske inte.. 
var pricks = document.querySelectorAll('.prick');
  //Index på den första bilden 
var nuvarande = 0;
  //Intervalet på tiden mellan "bild byten
const tid = 2000;

  //                n
function changeBild() {
  // Resetar
  for (var i = 0; i < bilder.length; i++) { 
  // .style.opacity = 0 gör så att bilden med indexet "i" kommer att bli OSYNLIG pga opacity 0 (0%)
    bilder[i].style.opacity = 0;
  // Jag använder propertyn "className" istället för class för att det ej fungerande med class då det conflictar med Document Object Model (DOM)
    pricks[i].className = pricks[i].className.replace(' active', '');
  }
  // Kort sammanfattat updaterar detta indexet på imgs
  nuvarande = (nuvarande + 1) % bilder.length;

  // .style.opacity = 1 gör så att bilden med indexet "i" kommer att bli SYNLIG pga opacity 1 (100%)
  bilder[nuvarande].style.opacity = 1;
  // += ' active'; för att byta bilden med index "nuvarande" till active
  pricks[nuvarande].className += ' active';
}

  // setInterval är en method som kan jämnföras med sleep.thread(ms) i C#
var timer = setInterval(changeBild, tid);
</script>

<div class="Rubrik">
  <h1>Min Tid Som Slide Montör</h1>
</div>

<div class="Datum">
  <h4 id="current-date"></h4>

<script>

  
//Definerar en function som updaterar ett element med nuvarande datum
function updateDate() {
  //Hämtar nuvarande datum och tid genom date
  var currentDate = new Date();

  //Extraherar år, månad och dag från Date method
  var year = currentDate.getFullYear();
  var month = currentDate.getMonth() + 1; //Månad startar vid 0 så +1 pga januari är månad 1 och inte månad 0
  var day = currentDate.getDate();

  //Hämtar referens till ett element med id "current-date"
  var dateElement = document.getElementById("current-date");

  //updaterar inehållet av elementet med nuvarande datumet i formatet yyy mm dd
  dateElement.innerHTML = year + " - " + month + " - " + day;
}

//callar en gång när sidan laddar, därav så är min date loader knapp på sidan bara en refreash på sidan
updateDate();
</script>


</div>

<div class="Brödtext">
  <h3>Lorem ipsum dolor sit amet consectetur
     adipisicing elit. Suscipit tempore fugit voluptatibus
      quibusdam impedit qui repellendus, aliquid ex ullam quasi
       doloremque aut quia nobis deserunt autem. Repellat aut deleniti
        dolores?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quos harum nostrum ut, 
        modi illo quis aut nobis nemo assumenda fugit delectus recusandae laborum eveniet minima, aliquam, 
        nesciunt eligendi quibusdam!
        adipisicing elit. Suscipit tempore fugit voluptatibus
      quibusdam impedit qui repellendus, aliquid ex ullam quasi
       doloremque aut quia nobis deserunt autem. Repellat aut deleniti
        dolores?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quos harum nostrum ut, 
        modi illo quis aut nobis nemo assumenda fugit delectus recusandae laborum eveniet minima, aliquam, 
        nesciunt eligendi quibusdam!
  </h3>
</div>

<div class="BottomBar">
<header> 
<img class="logo" src="images/BLOG.png" alt="logo">

  <!-- links-->
  <ul class="nav__links">
      <div class="link-container">
      <!-- List Element -->
      <li><a href="blogg_index.php">HOME</li>
      <li><a href="blogg_login.php">LOGIN</li>
      <li><a href="blogg_signup.php">SIGNUP</li>
      </div>
    </ul>
  <!-- link tag -->
  <a clas="cta" href="#"><button>Contact</button></a>
</header>
</div>


</body>
</html>