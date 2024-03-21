<?php

session_start();
$name = $_SESSION["name"];
$email = $_SESSION["email"];
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$passwordhash = password_hash($password, PASSWORD_DEFAULT);
session_destroy();

$mysqli = require __DIR__ . "/../../database.php";

$sql = "INSERT INTO users (name, email, username, password, type) VALUES (?, ?, ?, ?, 1)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $passwordhash);
if ($stmt->execute())
{
    header("location: register-success.html");
}
else
{
    echo "sex";
    die ("sex");
}
?>