<?php
include 'process-redirect.php';

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

// GET USER ID
session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

// INIT
$datetime = getCurrentDateTime();
$totalcost = 0;
$totalitems = 0;

// GET FOODS
$foodarray = array();
$foodresult = $mysqli->query("SELECT * FROM foods");
while ($foodrow = $foodresult->fetch_assoc())
{
    $foodarray[$foodrow["id"]] = $foodrow;
}

// CREATE ORDER RECORD
$sql = "INSERT INTO orders (date, user_id, is_paid, remarks, status, is_closed) VALUES (?, ?, '0', '', 'Waiting for payment', '0')";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "ss", $datetime, $userid);
if (!$stmt->execute())
{
    die ("Error.");
}

// GET ORDER ID
$orderid = mysqli_fetch_assoc($mysqli->query("SELECT id FROM orders ORDER BY id DESC LIMIT 1"))['id'];

// INSERT CART ITEMS
$cartresult = $mysqli->query("SELECT * FROM carts WHERE user_id = '$userid'");
while ($cartrow = $cartresult->fetch_assoc())
{
    $sql = "INSERT INTO order_items (order_id, food_id, food_cost, amount, subtotal) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }

    $subtotal = $foodarray[$cartrow["food_id"]]["cost"] * $cartrow["amount"];
    mysqli_stmt_bind_param($stmt, "sssss", $orderid, $cartrow["food_id"], $foodarray[$cartrow["food_id"]]["cost"], $cartrow["amount"], $subtotal);
    if (!$stmt->execute())
    {
        die ("Error.");
    }

    $totalitems = $totalitems + $cartrow["amount"];
    $totalcost = $totalcost + $subtotal;
}

// UPDATE ORDER RECORD
$sql = "UPDATE orders SET total_items = ?, total_cost = ?, to_pay = ? WHERE id = '$orderid'";
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "sss", $totalitems, $totalcost, $totalcost);
if (!$stmt->execute()) die ("Error.");

// REMOVE ITEMS FROM CART
$sql = "DELETE FROM carts WHERE user_id = '$userid'";

if ($mysqli->query($sql)) {
    header("location: ../orders.php");
} else die ("Error.");

?>