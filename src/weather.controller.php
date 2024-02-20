<?php

include_once 'constants.php';
include_once 'utils.php';
include_once 'user.controller.php';

/**
 * Generates a list of cities.
 *
 * @param array $cities The array of cities.
 * @return void
 */
function generateListOfCities($cities)
{
    $htmlOutput = '';

    $htmlOutput = '<div class="list-group">';
    foreach ($cities as $city_data) {
        $city = $city_data['city'];
        $country = $city_data['country'];
        $lat = $city_data['lat'];
        $lon = $city_data['lon'];
        $htmlOutput .= "<a class=\"list-group-item list-group-item-action\" href=index.php?lat=$lat&lon=$lon&city=" . urlencode($city . ", " . $country) . ">
                        $city, $country <i class=\"flag flag-" . strtolower($country) . "\"></i>
                        </a>";
    }
    $htmlOutput .= '</div>';

    return $htmlOutput;
}

function generateCurrentWeather($weatherData, $city)
{
    $favouritesButton = "";
    if (isUserLoggedIn()) {
        $lat = $weatherData->lat;
        $lon = $weatherData->lon;
        $location = $city;
        $favouritesButton = generateAddToFavouritesButton($lat, $lon, $location);
    }

    return "<p class=\"h3 mb-4\">$city $favouritesButton</p>
            <p class=\"h5 mb-4\">" . ucwords($weatherData->current->weather[0]->description) . "</p>
            <p class=\"display-2\"><strong>" . round($weatherData->current->temp) . " " . DEGREE_SIGN . "</strong> </p>";
}

function generateMinutelyRainForecast($weatherData)
{
    //TODO: Scale graph if values are small
    $htmlOutput = '<table class="charts-css hide-data area show-primary-axis">';

    for ($i = 0; $i < count($weatherData->minutely); $i++) {
        $forecastMinute = timestampToLocalTime($weatherData->minutely[$i]->dt);
        $previousPrecipitation = $i == 0 ? $weatherData->minutely[$i]->precipitation : $weatherData->minutely[$i - 1]->precipitation;
        $currentPrecipitation = $weatherData->minutely[$i]->precipitation;
        
        $htmlOutput .= '<tr>
                            <td style="--start: ' . ($previousPrecipitation / 10) . '; --end: ' . ($currentPrecipitation / 10 ) . ';" >
                                <span class="data">' . ($i % 5 == 0 ? $forecastMinute : "") . '</span>
                            </td>
                        </tr>';
    }

    $htmlOutput .= "</table>";
    return $htmlOutput;
}

function generateHourlyForecastList($weatherData)
{
    $htmlOutput = '<div class="d-flex justify-content-between align-items-center mx-3">';
    foreach ($weatherData->hourly as $key => $hour) {
        $forecastHour = $key == 0 ? "Nu" : timestampToLocalHour($hour->dt);
        $icon = $hour->weather[0]->icon;
        $temperatur = round($hour->temp);
        $htmlOutput .= '
                            <div class="d-flex flex-column h5 fw-normal py-3">' . $forecastHour . '
                                <img src="https://openweathermap.org/img/wn/' . $icon . '.png">
                                <span class="temperature">' . $temperatur . DEGREE_SIGN . '</span>
                            </div>';
    
        if ($key == 5) {
            break;
        }
    }
    $htmlOutput .= "</div>";
    return $htmlOutput;
}

/**
 * Generates a daily forecast list based on the provided weather data.
 *
 * @param JSONobject $weatherData The weather data used to generate the forecast list.
 * @return string The generated daily forecast list.
 */
function generateDailyForecastList($weatherData)
{
    $htmlOutput = '<ul class="list-group list-group-light list-group-small">';
    foreach ($weatherData->daily as $key => $day) {
        $weekday = $key == 0 ? "Vandag" : timestampToLocalWeekday($day->dt);
        $icon = $day->weather[0]->icon;
        $temperatur = round($day->temp->day);
        $htmlOutput .= '<li class="list-group-item px-3">
                        <div class="d-flex justify-content-between align-items-center">
                        <p class="h5 fw-normal">' . $weekday . '</p>
                        <p class="h5 fw-normal"><img src="https://openweathermap.org/img/wn/' . $icon . '.png"><span class="temperature">' . $temperatur . DEGREE_SIGN . '</span></p>
                        </div>
                        </li>';
    }
    $htmlOutput .= '</ul>';
    return $htmlOutput;
}

function generateFavouriteCard($weatherData, $location, $favouriteId)
{
    $weatherDetailLink = "index.php?lat=" . $weatherData->lat . "&lon=" . $weatherData->lon . "&city=" . urlencode($location);

    $htmlOutput = '<div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="card px-0" style="border-radius: 10px;">
                            <div class="bg-image ripple" data-mdb-ripple-color="light"
                            style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                            <img src="assets/img/' . getWeatherType($weatherData) . '.gif" class="w-100" />
                            <div class="mask" style="background-color: rgba(0,0,0,.45)">
                                <div class="d-flex justify-content-end p-4">'
                                    . generateRemoveFromFavouritesButton($favouriteId) .
                                '</div>
                                <div class="text-center text-white">
                                <p class="h3 mb-4 white-link"><a href="' . $weatherDetailLink . '">' . $location . '</a></p>
                                <p class="h5 mb-4">' . ucwords($weatherData->current->weather[0]->description) . '</p>
                                <p class="display-2"><strong>' . round($weatherData->current->temp) . DEGREE_SIGN . '</strong> </p>
                                </div>
                            </div>
                            </div>
                            <div class="card-body p-4 text-center">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="h5 fw-normal">Morgen</p>
                                <p class="h5 fw-normal"><img src="https://openweathermap.org/img/wn/' . $weatherData->daily[0]->weather[0]->icon . '.png">' . round($weatherData->daily[0]->temp->day) . DEGREE_SIGN . '</p>
                            </div>
                            </div>
                        </div>
                    </div>
                    </div>';
    
    return $htmlOutput;
}
/**
 * Retrieves the weather background based on the provided weather data.
 *
 * @param JSONobject $weatherData The weather data used to determine the background.
 * @return string The URL of the weather background image.
 */
function getWeatherType($weatherData)
{
    $img = '';
    switch ($weatherData->current->weather[0]->main) {
        case 'Clouds':
            $img = 'clouds';
            break;
        case 'Rain':
            $img = 'rain';
            break;
        case 'Fog':
            $img = 'fog';
            break;
        case 'Snow':
            $img = 'snow';
            break;
        case 'Thunderstorm':
            $img = 'thunderstorm';
            break;        
        default:
            $img = 'clear';
            break;
    }

    return $img;
}

/**
 * Sets the location cookies with the provided latitude, longitude, and city.
 *
 * @param float $lat The latitude of the location.
 * @param float $lon The longitude of the location.
 * @param string $city The name of the city.
 * @return void
 */
function setLocationCookies($lat, $lon, $city)
{
    $expirationTime = time() + (86400 * 30);
    setcookie("lastLat", $lat, $expirationTime);
    setcookie("lastLon", $lon, $expirationTime);
    setcookie("lastCity", $city, $expirationTime);
}
