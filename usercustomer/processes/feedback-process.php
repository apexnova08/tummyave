<?php
include 'process-redirect.php';

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

$feedback = $_POST["feedback"];
$rating = $_POST["rating"];
$date = getCurrentDate();

$sql = "INSERT INTO feedbacks (feedback, user_id, date, rating) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "ssss", $feedback, $userid, $date, $rating);
if ($stmt->execute()) header("location: ../orders.php"); 
else die ("Error.");
?>