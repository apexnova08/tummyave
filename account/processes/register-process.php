<?php

session_start();
$name = $_SESSION["name"];
$email = $_SESSION["email"];
$contact = $_SESSION["contact"];
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$passwordhash = password_hash($password, PASSWORD_DEFAULT);
session_destroy();

$mysqli = require __DIR__ . "/../../database.php";

$sql = "INSERT INTO users (name, email, username, password, type, disabled, contact) VALUES (?, ?, ?, ?, 4, 0, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $username, $passwordhash, $contact);
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