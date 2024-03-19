<?php

$name = $_POST["name"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];
$passwordhash = password_hash($password, PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/../../database.php";

#check for dupe username
$duperaw = $mysqli->query("SELECT COUNT(*) AS total FROM users WHERE (username = '$username')");
$dupes = $duperaw->fetch_assoc();
if ($dupes['total'] != "0")
{
    echo "lol";
}
exit;

#insert to db
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