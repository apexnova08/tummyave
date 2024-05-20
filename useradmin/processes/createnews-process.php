<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$title = $_POST["title"];
$content = $_POST["content"];
$date = getCurrentDate();
$image = uploadImage(generateID(getCurrentDateTime()));

$sql = "INSERT INTO news (title, content, date, image) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "ssss", $title, $content, $date, $image);
if ($stmt->execute())
{
    header("location: ../news.php");
}
else die("error");

?>