<?php

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$name = $_POST["name"];

$sql = "INSERT INTO categories (name) VALUES (?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "s", $name);
if ($stmt->execute())
{
    header("location: ../categories.php");
}
else die("error");

?>