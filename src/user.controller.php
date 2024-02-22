<?php

include_once "databaseFunctions.php";

function isUserLoggedIn()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true);
}

function LogoutUser()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    session_reset();
    session_destroy();
    return true;
}

function LoginUser($data)
{
    $email = $data['email'];
    $password = $data['password'];

    if ($id = checkLoginDetails($email, $password)) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["loggedIn"] = true;
        $_SESSION['userId'] = $id;
        $_SESSION['name'] = getUserName();

        return "Successfully logged in";
    } else {
        return "Wrong username/password combination";
    }
}

function checkLoginDetails($email, $password)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email";
    }
    $password;
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("SELECT id, password FROM user WHERE email = :email");
        $query->bindParam(":email", $email);
        $query->execute();
        if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $id = $result['id'];
            $fetched_password = $result['password'];

            if (password_verify($password, $fetched_password)) {
                return $id;
            }
        }
        $db_connection = null;
        return false;
    } catch (PDOException $e) {
        echo $e;
    }
}

function signUpUser($data)
{
    $name = stripcslashes($data['name']);
    $email = stripcslashes($data['email']);
    $password = htmlspecialchars($data['password']);

    if (!checkIfEmailExist($email)) {
        $db_connection = createDatabaseConnection();
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        try {
            $query = $db_connection->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
            $query->bindParam(":name", $name);
            $query->bindParam(":email", $email);
            $query->bindParam(":password", $password_hashed);
            $query->execute();
        } catch (PDOException $e) {
            echo $e;
        }

        $db_connection = null;
        return "Successfully signed up!";
    }

    return "Account with this email already exists.";
}

function checkIfEmailExist($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $db_connection = createDatabaseConnection();
            $query = $db_connection->prepare("SELECT * FROM user WHERE email = :email");
            $query->bindParam(":email", $email);
            $query->execute();
            $result = $query->fetch();

            if (empty($result)) {
                return false;
            }
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    } else {
        return false;
    }
}

function getUserId()
{
    if (!isset($_SESSION)) {
        session_start();
    }
    return $_SESSION['userId'];
}

function getUserName()
{
    $id = $_SESSION['userId'];
    if (empty($_SESSION['name'])) {
        try {
            $db_connection = createDatabaseConnection();
            $query = $db_connection->prepare("SELECT name FROM user WHERE id = :id");
            $query->bindParam(":id", $id);
            $query->execute();
            if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
                $name = $result['name'];
                return $name;
            }
            $db_connection = null;
            return false;
        } catch (PDOException $e) {
            echo $e;
        }
    } else {
        return $_SESSION['name'];
    }

    return false;
}

function getUserFavourites($userId)
{
    $favourites = [];
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("SELECT id, lat, lon, location FROM favourites WHERE userId = :userId");
        $query->bindParam(":userId", $userId);
        $query->execute();
        while ($results = $query->fetch(PDO::FETCH_ASSOC)) {
            $favourites[] = $results;
        }

        return $favourites;
    } catch (PDOException $e) {
        echo $e;
    }

    return false;
}

function removeUserFavourite($favouriteId, $userId)
{
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("DELETE FROM favourites WHERE id = :id AND userId = :userId");
        $query->bindParam(":id", $favouriteId);
        $query->bindParam(":userId", $userId);
        $query->execute();
        return true;
    } catch (PDOException $e) {
        echo $e;
    }

    return false;
}

function checkIfFavouriteExists($userId, $lat, $lon)
{
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("SELECT * FROM favourites WHERE userId = :userId AND lat = :lat AND lon = :lon");
        $query->bindParam(":userId", $userId);
        $query->bindParam(":lat", $lat);
        $query->bindParam(":lon", $lon);
        $query->execute();
        $result = $query->fetch();

        if (empty($result)) {
            return false;
        }
        return true;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function addUserFavourite($userId, $lat, $lon, $location,)
{
    if (checkIfFavouriteExists($userId, $lat, $lon)) {
        return false;
    }
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("INSERT INTO favourites (lat, lon, location, userId) VALUES (:lat, :lon, :location, :userId)");
        $query->bindParam(":lat", $lat);
        $query->bindParam(":lon", $lon);
        $query->bindParam(":location", $location);
        $query->bindParam(":userId", $userId);
        $query->execute();
        return true;
    } catch (PDOException $e) {
        echo $e;
    }

    return false;
}

function generateAddToFavouritesButton($lat, $lon, $location)
{
    $requestData = [
        "action" => "addFavourite",
        "lat" => $lat,
        "lon" => $lon,
        "location" => $location
    ];

    return "<a class=\"btn-sm add-fav-button\" data-mdb-popover-init data-mdb-trigger=\"hover\" data-mdb-content=\"Add to favourites\" href=favourites.php?" . http_build_query($requestData)  . " role=\"button\">
                <i class=\"fas fa-star\"></i>
            </a>";
}

function generateRemoveFromFavouritesButton($id)
{
    $requestData = [
        "action" => "removeFavourite",
        "id" => $id
    ];

    return "<a class=\"btn-sm remove-fav-button\" data-mdb-popover-init data-mdb-trigger=\"hover\" data-mdb-content=\"Remove from favourites\" href=favourites.php?" . http_build_query($requestData)  . " role=\"button\">
                <i class=\"fas fa-trash\"></i>
            </a>";
}

function changePassword($currentPassword, $newPassword, $confirmNewPassword)
{
    $userId = getUserId();
    if ($newPassword != $confirmNewPassword) {
        return false;
    }
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("SELECT password FROM user WHERE id = :id");
        $query->bindParam(":id", $userId);
        $query->execute();
        if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $fetched_password = $result['password'];
            if (password_verify($currentPassword, $fetched_password)) {
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $query = $db_connection->prepare("UPDATE user SET password = :password WHERE id = :id");
                $query->bindParam(":password", $newPassword);
                $query->bindParam(":id", $userId);
                $query->execute();
                return true;
            }
        }
        $db_connection = null;
        return false;
    } catch (PDOException $e) {
        echo $e;
    }
}

function changeTemperatureUnit($unit)
{
    $userId = getUserId();
    if ($unit != "metric" && $unit != "imperial") {
        return false;
    }
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("UPDATE user SET temperature_unit = :temperature_unit WHERE id = :id");
        $query->bindParam(":temperature_unit", $unit);
        $query->bindParam(":id", $userId);
        $query->execute();
        return true;
    } catch (PDOException $e) {
        echo $e;
    }

    return false;
}

function getTemperatureUnit()
{
    $userId = getUserId();
    try {
        $db_connection = createDatabaseConnection();
        $query = $db_connection->prepare("SELECT temperature_unit FROM user WHERE id = :id");
        $query->bindParam(":id", $userId);
        $query->execute();
        if ($result = $query->fetch(PDO::FETCH_ASSOC)) {
            $unit = $result['temperature_unit'];
            return $unit;
        }
        $db_connection = null;
        return false;
    } catch (PDOException $e) {
        echo $e;
    }
}
