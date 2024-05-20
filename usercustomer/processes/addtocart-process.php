<?php
include 'process-redirect.php';

$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

$sql = "INSERT INTO carts (user_id, food_id, amount) VALUES (?, ?, ?)";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "sss", $userid, $_POST["foodId"], $_POST["amount"]);
if ($stmt->execute())
{
    header("location: ../../food.php");
}
else die ("Error.");

?>