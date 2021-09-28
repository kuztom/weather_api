<?php

require_once 'vendor/autoload.php';

use App\WeatherData;
use App\Validation;

$url = "http://api.weatherapi.com/v1/forecast.json?key=72b37543b4fa4445a7f80612212809&q=Riga&days=3&aqi=no&alerts=no";

if (isset($_POST['search'])) {
    if ($_POST['city'] === "") {
        $response = new Validation();
        echo "<br><p style='text-align: center; color:red; font-size:18px'><b>{$response->error()}</b></p>";
    } else {
        $url = preg_replace("#Riga#", $_POST['city'], $url);
    }
}

$json = file_get_contents($url);
$data = json_decode($json, true);

$celsius = "\u{2103}"; //temperature symbol
$wind = "\u{1F4A8}";   //wind symbol

$days = [];

for ($i = 0; $i <= 2; $i++) {
    $days[] = new WeatherData(
        $data['location']['name'],
        $data['forecast']['forecastday'][$i]['date'],
        $data['forecast']['forecastday'][$i]['day']['condition']['icon'],
        $data['forecast']['forecastday'][$i]['day']['avgtemp_c'],
        $data['forecast']['forecastday'][$i]['day']['mintemp_c'],
        $data['forecast']['forecastday'][$i]['day']['maxtemp_c'],
        $data['forecast']['forecastday'][$i]['day']['maxwind_kph']
    );
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU"
          crossorigin="anonymous">
    <title>Weather Forecast</title>
</head>
<body>
<br>
<h1 style="text-align: center;color:steelblue;font-size:40px;">Weather Forecast</h1>
<h1 style="text-align: center;color:steelblue;font-size:40px;">3 day's in <?php echo $days[0]->getCity() ?></h1>

<div class="container-sm">
    <div style="text-align: center">
        <form method="post">
            <label for="city">Search by City name: </label>
            <input type="text" id="city" name="city"><br><br>
            <input type="submit" name="search" value="Search"><br><br>
        </form>
    </div>
    <br>
    <div class="container-sm" style="display: flex; justify-content: center">
        <table class="table table-sm table-bordered table-hover"
               style="width: 600px; text-align: center; align-self: center">
            <tbody>
            <tr style="font-size: 20px">
                <td><img src="<?php echo $days[0]->getIcon() ?>"><br><?php echo $days[0]->getDate() ?></td>
                <td><img src="<?php echo $days[1]->getIcon() ?>"><br><?php echo $days[1]->getDate() ?></td>
                <td><img src="<?php echo $days[2]->getIcon() ?>"><br><?php echo $days[2]->getDate() ?></td>
            </tr>
            <tr style="font-size: 20px">
                <td><?php echo "Average: " . $days[0]->getAvgTempC() . $celsius ?></td>
                <td><?php echo "Average: " . $days[1]->getAvgTempC() . $celsius ?></td>
                <td><?php echo "Average: " . $days[2]->getAvgTempC() . $celsius ?></td>
            </tr>
            <tr style="color:blue">
                <td ><?php echo "Min: " . $days[0]->getMinTempC() . $celsius ?></td>
                <td><?php echo "Min: " . $days[1]->getMinTempC() . $celsius ?></td>
                <td><?php echo "Min: " . $days[2]->getMinTempC() . $celsius ?></td>
            </tr>
            <tr style="color:red">
                <td><?php echo "Max: " . $days[0]->getMaxTempC() . $celsius ?></td>
                <td><?php echo "Max: " . $days[1]->getMaxTempC() . $celsius ?></td>
                <td><?php echo "Max: " . $days[2]->getMaxTempC() . $celsius ?></td>
            </tr>
            <tr>
                <td><?php echo "Wind: " . $days[0]->getWindKph() . $wind ?></td>
                <td><?php echo "Wind: " . $days[1]->getWindKph() . $wind ?></td>
                <td><?php echo "Wind: " . $days[2]->getWindKph() . $wind ?></td>
            </tr>
            <tr>


            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
