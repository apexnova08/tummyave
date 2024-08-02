<?php

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$name = $_POST["name"];
$image = uploadImage(generateID(getCurrentDateTime()));
$ctg = $_POST["ctg"];
$cost = $_POST["cost"];
$desc = $_POST["desc"];

$sql = "INSERT INTO foods (name, cost, image, description, category, archived) VALUES (?, ?, ?, ?, ?, true)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "sssss", $name, $cost, $image, $desc, $ctg);
if ($stmt->execute())
{
    header("location: ../../useradmin/");
}
else die("error");

?>