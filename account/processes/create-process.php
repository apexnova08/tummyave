<?php
session_start();
$name = $_SESSION["name"];
$type = $_SESSION["type"];
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$passwordhash = password_hash($password, PASSWORD_DEFAULT);
session_abort();

$mysqli = require __DIR__ . "/../../database.php";

$sql = "INSERT INTO users (name, username, password, type) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $passwordhash, $type);
if ($stmt->execute())
{
    echo '<script type="text/javascript">', 'history.go(-2);', '</script>';
}
else die ("Error");
?>