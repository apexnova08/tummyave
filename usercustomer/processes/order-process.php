<?php

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$name = $_POST["name"];
$image = uploadImage(generateID(getCurrentDateTime()));
$cost = $_POST["cost"];
$desc = $_POST["desc"];

$sql = "INSERT INTO foods (name, cost, image, description, category, archived) VALUES (?, ?, ?, ?, 'N/A', 0)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "ssss", $name, $cost, $image, $desc);
if ($stmt->execute())
{
    header("location: ../foodslist.php");
}
else
{
    echo "sex";
    die ("sex");
}

?>