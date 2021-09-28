<?php
date_default_timezone_set('Europe/Riga');

require_once 'vendor/autoload.php';

use App\WeatherData;
use App\WeatherToday;
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

$today = [];
$actualHour = intval(date('H'));
for ($i = $actualHour; $i <= $actualHour + 4; $i++) {
    $today[] = new WeatherToday(
        $data['forecast']['forecastday'][0]['hour'][$i]['time'],
        $data['forecast']['forecastday'][0]['hour'][$i]['condition']['icon'],
        $data['forecast']['forecastday'][0]['hour'][$i]['temp_c']
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
<h1 style="text-align: center;color:steelblue;font-size:40px;">3 days in <?php echo $days[0]->getCity() ?></h1>

<div class="container-sm">
    <div style="text-align: center">
        <form method="post">
            <label for="city">Search by City name: </label>
            <input type="text" id="city" name="city"><br><br>
            <input type="submit" name="search" value="Search"><br><br>
        </form>
    </div>
    <div class="container-sm" style="display: flex; justify-content: center">
        <table class="table table-sm table-bordered table-hover"
               style="width: 600px; text-align: center; align-self: center">
            <tbody>
            <tr style="font-size: 20px">
                <?php foreach ($days as $date): ?>
                    <td><img src="<?php echo $date->getIcon() ?>"><br><?php echo $date->getDate() ?></td>
                <?php endforeach; ?>
            </tr>
            <tr style="font-size: 20px">
                <?php foreach ($days as $avgTemp): ?>
                    <td><?php echo "Average: " . $avgTemp->getAvgTempC() . $celsius ?></td>
                <?php endforeach; ?>
            </tr>
            <tr style="color:blue">
                <?php foreach ($days as $minTemp): ?>
                    <td><?php echo "Min: " . $minTemp->getMinTempC() . $celsius ?></td>
                <?php endforeach; ?>
            </tr>
            <tr style="color:red">
                <?php foreach ($days as $maxTemp): ?>
                    <td><?php echo "Max: " . $days[0]->getMaxTempC() . $celsius ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($days as $windKph): ?>
                    <td><?php echo "Wind: " . $windKph->getWindKph() . "km/h" . $wind ?></td>
                <?php endforeach; ?>
            </tr>
            </tbody>
        </table>
        <br>
    </div>

    <h1 style="text-align: center;color:steelblue;font-size:40px;">Next 5 hours
        in <?php echo $days[0]->getCity() ?></h1>
    <div class="container-sm" style="display: flex; justify-content: center">
        <table class="table table-sm table-bordered table-hover"
               style="width: 600px; text-align: center; align-self: center">
            <tbody>
            <tr>
                <?php foreach ($today as $time): ?>
                    <td><?php echo substr($time->getHour(), 11) ?></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($today as $icon): ?>
                    <td><img src="<?php echo $icon->getIcon() ?>"></td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach ($today as $temp): ?>
                    <td><?php echo $temp->getTempC() . $celsius ?></td>
                <?php endforeach; ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
