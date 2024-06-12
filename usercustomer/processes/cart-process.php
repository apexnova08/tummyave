<?php
include 'process-redirect.php';

$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$cartid = $_POST["id"];

$sql = "DELETE FROM carts WHERE id = ?";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "s", $cartid);
if ($stmt->execute())
{
    header("location: ../../food.php#cart");
}
else die ("Error.");
?>