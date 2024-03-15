<?php

$name = $_POST["name"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

$host = "localhost";
$dbname = "tummy_test_db";
$dbuser = "root";
$dbpass = "";

$conn = mysqli_connect(
    hostname: $host,
    username: $dbuser,
    password: $dbpass, 
    database: $dbname,
    port: 3307);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

echo "sakses";

$sql = "INSERT INTO users (name, email, username, password, type) VALUES (?, ?, ?, ?, 1)";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql))
{
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "ssss",
                       $name,
                       $email,
                       $username,
                       $password);

mysqli_stmt_execute($stmt);

echo "Record saved.";