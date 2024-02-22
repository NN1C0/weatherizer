<?php
include_once "src/user.controller.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'templates/head.php'; ?>
</head>

<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <div class="row">
            <h1 class="pb-4">Settings</h1>
            <?php if (isset($_GET['message'])) {
                $message = $_GET['message'];
                echo "<span class=\"badge badge-success\">$message</span>";
            } ?>
            <?php if (isUserLoggedIn()) { ?>
                <div class="col-12">
                    <h2 class="py-4">Change temperature unit</h2>
                    <form action="change_unit.php" method="post">
                        <div class="mb-3">
                            <div class="btn-group">
                                <input type="radio" class="btn-check" name="temperatureUnit" id="metric" value="metric" autocomplete="off" <?php echo (getTemperatureUnit() == 'metric' ? 'checked' : ''); ?> />
                                <label class="btn btn-secondary" for="metric" data-mdb-ripple-init>Celsius</label>

                                <input type="radio" class="btn-check" name="temperatureUnit" id="imperial" value="imperial" autocomplete="off" <?php echo (getTemperatureUnit() == 'imperial' ? 'checked' : ''); ?> />
                                <label class="btn btn-secondary" for="imperial" data-mdb-ripple-init>Fahrenheit</label>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
                <div class="col-12">
                    <h2 class="py-4">Change password</h2>
                    <form action="change_password.php" method="post">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Current password</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword">
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirm new password</label>
                            <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword">
                        </div>
                        <button type="submit" class="btn btn-primary">Change password</button>
                    </form>
                </div>
        </div>
            <?php } else { ?>
        <p>You need to be logged in to access this page.</p>
            <?php } ?>
    <?php include 'templates/script.php'; ?>
</body>

</html>
