<?php
    include_once 'src/user.controller.php';
    LogoutUser();
    header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'templates/head.php'; ?>
</head>

<body>
    <?php include 'templates/header.php'; ?>

    <div class="container-fluid d-flex align-items-center justify-content-center">
        <i class="fas fa-hand-peace"></i>
    </div>

    <?php include 'templates/script.php'; ?>
</body>

</html>
