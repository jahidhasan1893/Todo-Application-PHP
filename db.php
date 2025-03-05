<?php

$username = "root";
$password = "password";
$hostname = "127.0.0.1";
$database = "todo";


$dbConnect = new mysqli($hostname, $username, $password, $database);

if ($dbConnect->connect_error) {
    die("Connection failed: " . $dbConnect->connect_error);
}

return $dbConnect;

