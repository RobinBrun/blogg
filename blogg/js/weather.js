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
