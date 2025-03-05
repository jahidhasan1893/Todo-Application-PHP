<?php

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$hostname = $_ENV['DB_HOST'];
$username = $_ENV['DB_USER']; 
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_NAME'];

$dbConnect = new mysqli($hostname, $username, $password, $database);

if ($dbConnect->connect_error) {
    die("Connection failed: " . $dbConnect->connect_error);
}

return $dbConnect;
