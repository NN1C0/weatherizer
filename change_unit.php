<?php

include_once "src/user.controller.php";

if (isset($_POST['temperatureUnit'])) {
    if ($_POST['temperatureUnit'] == "imperial") {
        $unitToggle = "imperial";
    } elseif ($_POST['temperatureUnit'] == "metric") {
        $unitToggle = "metric";
    }
    if (changeTemperatureUnit($unitToggle)) {
        header("Location: settings.php?message=Unit changed successfully");
    } else {
        header("Location: settings.php?message=Unit change failed");
    }
}
?>
