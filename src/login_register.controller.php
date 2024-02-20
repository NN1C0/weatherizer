<?php

include_once "user.controller.php";

if (isset($_POST)) {
    if (isset($_POST['button_signup'])) {
        if ($_POST['password'] != $_POST['repeatPassword']) {
            $message = htmlspecialchars("Passwords don't match");
            header("Location: ../login_register.php?message=$message");
        }
        $result = signUpUser($_POST);
        header("Location: ../login_register.php?message=$result");
    } elseif (isset($_POST['button_login'])) {
        $result = LoginUser($_POST);
        header("Location: ../login_register.php?message=$result");
    }
}
?>
