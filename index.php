<?php
include_once 'src/openweathermap.controller.php';
include_once 'src/weather.controller.php';
include_once 'src/constants.php';

//Check if url contains location data, otherwise check cookie data, otherwise set Amsterdam
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['lat']) && isset($_GET['lon'])) {
    if (isset($_GET['city'])) {
        $city = urldecode($_GET['city']);
    }
    $lat = $_GET['lat'];
    $lon = $_GET['lon'];

    setLocationCookies($lat, $lon, $city);
} elseif (isset($_COOKIE['lastLat']) && isset($_COOKIE['lastLon']) && isset($_COOKIE['lastCity'])) {
    $city = $_COOKIE['lastCity'];
    $lat = $_COOKIE['lastLat'];
    $lon = $_COOKIE['lastLon'];
} else {
    $city = "Amsterdam, NL";
    $lat = "52.3727598";
    $lon = "4.8936041";
}

$weatherInfo = getWeatherData($lat, $lon);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'templates/head.php'; ?>
</head>

<body>
    <?php include 'templates/header.php'; ?>

    <?php if (isset($lat) && isset($lon)) { ?>
        <section class="container-fluid px-0 weather-section" style="background-color: #eee;">
            <div class="container-fluid weather-bg text-center weather-<?php echo getWeatherType($weatherInfo); ?>" data-mdb-ripple-color="light">
                <?php
                if (isset($_GET['message'])) {
                    $message = $_GET['message'];
                    echo "<span class=\"badge badge-success\">$message</span>";
                }
                ?>
                <!-- Current Weather -->
                <div class="container-fluid pt-5 text-center text-white">
                    <?php echo generateCurrentWeather($weatherInfo, $city); ?>
                </div>

                <!-- 1 hour rain forecast -->
                <div class="weather-card-container container-sm py-5">
                    <div class="card" style="border-radius: 10px;">
                        <small class="card-header text-muted">Kommende uur regen</small>
                        <div class="card-body py-0 px-2 text-center chart-body">
                            <?php echo generateMinutelyRainForecast($weatherInfo); ?>
                        </div>
                    </div>
                </div>

                <!-- 12 hour forecast -->
                <div class="weather-card-container container-sm py-5">
                    <div class="card" style="border-radius: 10px;">
                        <small class="card-header text-muted">Kommende 12 uur</small>
                        <div class="card-body py-0 px-2 text-center">
                            <?php echo generateHourlyForecastList($weatherInfo); ?>
                        </div>
                    </div>
                </div>

                <!-- 7 Day forecast -->
                <div class="weather-card-container container-sm py-5">
                    <div class="card" style="border-radius: 10px;">
                        <small class="card-header text-muted">Kommende 7 dagen</small>
                        <div class="card-body py-0 px-2 text-center">
                            <?php echo generateDailyForecastList($weatherInfo); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php } ?>
    <?php include 'templates/script.php'; ?>
</body>

</html>
