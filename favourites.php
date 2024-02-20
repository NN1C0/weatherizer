<?php
    include_once "src/user.controller.php";
    include_once "src/weather.controller.php";
    include_once "src/openweathermap.controller.php";

if (isset($_GET['action']) && $_GET['action'] == 'addFavourite') {
    if (isset($_GET['lat']) && isset($_GET['lon']) && isset($_GET['location'])) {
        $lat = $_GET['lat'];
        $lon = $_GET['lon'];
        $location = $_GET['location'];

        addUserFavourite(getUserId(), $lat, $lon, $location);
        header("Location: favourites.php");
    }
}

if (isset($_GET['action']) && $_GET['action'] == 'removeFavourite') {
    if (isset($_GET['id'])) {
        $favouriteId = $_GET['id'];
        removeUserFavourite($favouriteId, getUserId());
        header("Location: favourites.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'templates/head.php'; ?>
</head>

<body>
    <?php include 'templates/header.php'; ?>

    <div class="container">
        <h1 class="pt-5 pb-0">Hey <?php echo getUserName(); ?>, jouw favoriten</h1>
        <div class="row">
            <?php
            $favourites = getUserFavourites(getUserId());
            if ($favourites) {
                foreach ($favourites as $favourite) {
                    $weatherData = getWeatherData($favourite['lat'], $favourite['lon']);
                    echo "<div class=\"col-12 col-md-6 col-lg-4 mb-3\">";
                    echo generateFavouriteCard($weatherData, $favourite['location'], $favourite['id']);
                    echo "</div>";
                }
            } else {
                echo "<div class=\"col-12\">";
                echo "<p>Je hebt nog geen favorieten toegevoegd.</p>";
                echo "</div>";
            }
            ?>
    </div>

    <?php include 'templates/script.php'; ?>
</body>
</html>
