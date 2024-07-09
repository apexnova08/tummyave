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

$food = $_POST["foodId"];

$cartitemraw = $mysqli->query("SELECT * FROM carts WHERE user_id = $userid AND food_id = $food");
$cartitem = $cartitemraw->fetch_assoc();
if (!$cartitem)
{
    $sql = "INSERT INTO carts (user_id, food_id, amount) VALUES (?, ?, ?)";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "sss", $userid, $food, $_POST["amount"]);
    if ($stmt->execute())
    {
        header("location: ../../food.php#food");
    }
    else die ("Error.");
}
else
{
    $cartid = $cartitem["id"];
    $newamount = strval((int)$_POST["amount"] + (int)$cartitem["amount"]);
    
    $sql = "UPDATE carts SET amount = '$newamount' WHERE id = '$cartid'";
    if ($mysqli->query($sql)) header("location: ../../food.php#food");
    else die ("Error.");
}
?>