<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '\..\\');
$dotenv->load();

function createDatabaseConnection()
{
    $db_host = $_ENV["DB_HOST"];
    $db_database = $_ENV["DB_DATABASE"];
    $db_username = $_ENV["DB_USERNAME"];
    $db_password = $_ENV["DB_PASSWORD"];
    try {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_database", $db_username, $db_password);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    return false;
}
