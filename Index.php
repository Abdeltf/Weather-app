<?php ?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8" />
  <title>Wetter in Deutschland</title>

  <script src="https://cdn.jsdelivr.net/npm/vue@3.4.15/dist/vue.global.prod.js"></script>

  <style>
    body {
      font-family: "Segoe UI", Arial, sans-serif;
      background: linear-gradient(135deg, #e8f0fe, #f7f9fc);
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      width: 450px;
      background: #ffffff;
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 26px;
      margin-bottom: 20px;
      color: #1a2b4c;
    }

    select {
      width: 100%;
      padding: 14px;
      border-radius: 12px;
      border: 2px solid #d0d7e2;
      margin-bottom: 20px;
      font-size: 16px;
      transition: 0.2s;
    }

    select:focus {
      border-color: #4b89ff;
      outline: none;
    }

    button {
      width: 100%;
      padding: 14px;
      background: #4b89ff;
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 18px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.2s;
    }

    button:hover {
      background: #3a6fe3;
    }

    .result-box {
      margin-top: 25px;
      background: #f0f4ff;
      padding: 20px;
      border-radius: 15px;
      font-size: 18px;
      color: #2c3e70;
      font-weight: 500;
    }

    .error {
      color: #ff3b3b;
      font-size: 18px;
      font-weight: bold;
      margin-top: 20px;
    }

    .emoji {
      font-size: 45px;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>🌦️ Wetter in Deutschland 🇩🇪</h1>

    <form action="index.php" method="POST">
      <select name="city" id="city">
        <option value="" disabled selected>Stadt auswählen</option>
        <option value="Berlin">Berlin</option>
        <option value="Frankfurt">Frankfurt</option>
        <option value="München">München</option>
        <option value="Hamburg">Hamburg</option>
        <option value="Köln">Köln</option>
      </select>

      <button type="submit" name="done">Wetter anzeigen</button>
    </form>

    <div>
      <?php
      if (isset($_POST['done'])) {
        $apikey = "063151ffb010a937307b7e15875dfe9b";
        $city = $_POST['city'] ?? '';
        $link = "https://api.openweathermap.org/data/2.5/weather?q=$city,DE&units=metric&appid=$apikey";

        if (!$city) {
          echo "<p class='error'>Bitte wählen Sie eine Stadt aus.</p>";
          return;
        }

        $anfrage = curl_init();
        curl_setopt($anfrage, CURLOPT_URL, $link);
        curl_setopt($anfrage, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($anfrage);
        curl_close($anfrage);

        if ($response) {
          $data = json_decode($response, false);
          $temperature = $data->main->temp;
          $description = $data->weather[0]->main;

          // Pick icon based on description
          $icons = [
            "Clear" => "☀️",
            "Rain" => "🌧️",
            "Clouds" => "☁️",
            "Snow" => "❄️",
            "Thunderstorm" => "⛈️",
            "Mist" => "🌫️"
          ];

          $icon = $icons[$description] ?? "🌦️";

          echo "
          <div class='result-box'>
            <div class='emoji'>$icon</div>
            Die Temperatur in <b>$city</b> beträgt <b>$temperature</b>.<br>
            Wetter: <b>$description</b>
          </div>";
        }
      }
      ?>
    </div>
  </div>
</body>

</html>
