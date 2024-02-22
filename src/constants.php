<?php

// Define the temperature constants based on the user's settings.
include_once "user.controller.php";
if (isUserLoggedIn()) {
    if (getTemperatureUnit() == "imperial") {
        define("DEGREE_SIGN", "°F");
        define("TEMPERATURE_UNIT", "imperial");
    } else {
        define("DEGREE_SIGN", "°C");
        define("TEMPERATURE_UNIT", "metric");
    }
} else {
    define("DEGREE_SIGN", "°C");
    define("TEMPERATURE_UNIT", "metric");
}

?>
