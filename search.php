<?php
include_once 'src/openweathermap.controller.php';
include_once 'src/weather.controller.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    $responseCities = searchForCities($searchTerm);
    if (count($responseCities) == 1) {
        header("Location: index.php?lat=" . $responseCities[0]["lat"] . "&lon=" . $responseCities[0]["lon"] . "&city=" . urlencode($responseCities[0]["city"] . ", " . $responseCities[0]["country"]));
        die();
    }
}
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once 'templates/head.php'; ?>
</head>
<body>
    <?php include_once 'templates/header.php'; ?>

    
    <div class="search - results container p - 2">
    <h4 class="pt-4">Search Results based on " <?php echo isset($searchTerm) ? $searchTerm : ""; ?>"</h4>
        <?php 
        if (isset($responseCities)) {
            echo generateListOfCities($responseCities);
        }
        ?>
    </div>

    <?php include_once 'templates/script.php'; ?>
</body>
</html>
