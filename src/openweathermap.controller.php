<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '\..\\');
$dotenv->load();

function searchForCities($searchTerm)
{
    $API_KEY = $_ENV['OPENWEATHERMAP_API_KEY'];
    $cities = [];
    $searchTerm = urlencode($searchTerm);

    try {
        $apiUrl = "http://api.openweathermap.org/geo/1.0/direct?q=$searchTerm&limit=5&appid=$API_KEY";

        if ($response = @file_get_contents($apiUrl)) {
            $data = json_decode($response);

            foreach ($data as $city) {
                $cities[] = ['city' => $city->name, 'lat' => $city->lat, 'lon' =>  $city->lon, 'country' =>  $city->country];
            }
        }
    } catch (\Throwable $th) {
        error_log($th);
    }

    return $cities;
}


function getWeatherData($lat, $lon)
{
    $API_KEY = $_ENV['OPENWEATHERMAP_API_KEY'];

    $weatherResult = null;

    try {
        $apiUrl = "https://api.openweathermap.org/data/3.0/onecall?lat=$lat&lon=$lon&exclude=alerts&units=metric&appid=$API_KEY";

        $response = file_get_contents($apiUrl);
        $data = json_decode($response);

        $weatherResult = $data;
    } catch (\Throwable $th) {
        throw $th;
    }

    return $data;
}
?>
