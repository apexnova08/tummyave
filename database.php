<?php

$host = "localhost";
$dbname = "tummy";
$dbuser = "root";
$dbpass = "";

$mysqli = new mysqli(
    hostname: $host,
    username: $dbuser,
    password: $dbpass, 
    database: $dbname,
    port: 3307);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;