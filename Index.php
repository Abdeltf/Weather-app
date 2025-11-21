<html>
<head>

<script src="https://cdn.jsdelivr.net/npm/vue@3.4.15/dist/vue.global.prod.js"></script>
  <style>
    body {
      font-family: sans-serif;
      background-color: #f0f4f8;
      text-align: center;
    }
    select, button {
      margin-top: 1rem;
      padding: 0.6rem 1.2rem;
      font-size: 16px;
    }
    h1 {
      color: #2c3e50;
      margin-top: 2rem;
    }

    p{
       font-size: 20px;

    }

    
  </style>
</head>

<body>
 <h1> 🌦️ Das Wetter in Deutshland 🇩🇪</h1>
 <form action="index.php" method="POST">

<select name= 'city' id= 'city'>
 <option value="" disabled selected>Wählen Sie eine Stadt</option>   
 <option value="Berlin"> Berlin </option>   
 <option value="frankfurt"> Frankfurt </option>   
 <option value="München"> München </option>   
 <option value="Hamburg"> Hamburg </option>   
 <option value="Köln"> Köln </option>   
</select>

<button type="Submit" name="done">Anzeigen</button> 


<div>

<?php
if (isset($_POST['done'])){
  $apikey= "063151ffb010a937307b7e15875dfe9b";
  $city= $_POST ['city'] ?? '';
  $link= "https://api.openweathermap.org/data/2.5/weather?q=$city,DE&units=metric&appid=$apikey";
  
  if (!$city) {
    echo "<p style='color:red;'> <b> Bitte wählen Sie eine Stadt aus, bevor Sie fortfahren. </b></p>";
    return;
  }


 $anfrage= curl_init();

 curl_setopt($anfrage, CURLOPT_URL, $link);
 curl_setopt($anfrage, CURLOPT_RETURNTRANSFER, true);
 $response = curl_exec($anfrage); 
 curl_close($anfrage);

// Get data from the json
 if ($response) {
 
$data = json_decode($response, false);
 $temperature = $data->main->temp;
 $description = $data->weather[0]->main;

}
 
echo "<p> Die Temperature in <b>$city</b> ist <b>$temperature</b> und der Himmel ist $description </p>";

}

?>
</div>


</body>


</html>
