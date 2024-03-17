<?php

$name = $_POST["name"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

$mysqli = require __DIR__ . "database.php";

$sql = "INSERT INTO users (name, email, username, password, type) VALUES (?, ?, ?, ?, 1)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}

mysqli_stmt_bind_param($stmt, "ssss",
                       $name,
                       $email,
                       $username,
                       $password);

if ($stmt->execute())
{
    header("location: processes/signup-success.html");
}
else
{
    echo "sex";
    die ("sex");
}