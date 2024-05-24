<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$title = $_POST["title"];
$content = $_POST["content"];
$image = uploadImage(generateID(getCurrentDateTime()));

$countraw = $mysqli->query("SELECT COUNT(*) AS total FROM about");
$count = (int)$countraw->fetch_assoc()["total"] + 1;

$sql = "INSERT INTO about (title, text, image, order_num) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "ssss", $title, $content, $image, $count);
if ($stmt->execute())
{
    header("location: ../about.php");
}
else die("error");

?>