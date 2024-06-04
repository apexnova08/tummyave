<?php
$config = parse_ini_file(__DIR__ . "/config.ini", true);

$mysqli = new mysqli(
    hostname: $config["database"]["host"],
    username: $config["database"]["user"],
    password: $config["database"]["pass"], 
    database: $config["database"]["name"],
    port: 3307);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;