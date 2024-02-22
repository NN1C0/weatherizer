<?php

include_once "src/user.controller.php";

if (isset($_POST['currentPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmNewPassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if (changePassword($currentPassword, $newPassword, $confirmNewPassword)) {
        header("Location: settings.php?message=Password changed successfully");
    } else {
        header("Location: settings.php?message=Password change failed");
    }
}
?>
