<?php 
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

session_start();
$userid = $_SESSION["user_id"];
session_abort();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

// GET ORDER
$id = $_POST["id"];
$result = $mysqli->query("SELECT * FROM orders WHERE id = '$id'");
$order = $result->fetch_assoc();

// GET CUSTOMER
$customerid = $order["user_id"];
$sql = "SELECT * FROM users WHERE id = '$customerid'";
$result = $mysqli->query($sql);
$customer = $result->fetch_assoc();

// UPDATE
if (isset($_POST["update"]))
{
    $sql = "";
    if ($order["is_paid"] === '0')
    {
        $sql = "UPDATE orders SET is_paid = '1', status = 'Preparing', employee_id = '$userid' WHERE id = '$id'";
    }
    elseif ($order["status"] === "Preparing")
    {
        NotifyOrderReady($customer["email"], $customer["name"], $order["id"], $order["total_items"]);
        $sql = "UPDATE orders SET status = 'Ready for pickup' WHERE id = '$id'";
        if (!$mysqli->query("INSERT INTO notifications (user_id, notification) VALUES ('$customerid', 'Your order is ready to pickup!')")) die ("Notification error");
    }
    elseif ($order["status"] === "Ready for pickup")
    {
        $sql = "UPDATE orders SET status = 'Picked up', is_closed = true WHERE id = '$id'";
    }

    if ($mysqli->query($sql))
    {
        header("location: ../../usercashier/");
    }
    else die ("Error updating order.");
}
elseif (isset($_POST["close"]))
{
    $id = $_POST["id"];
    $reason = $_POST["reason"];

    $sql = "UPDATE orders SET status = 'Closed', is_closed = true, close_reason = ? WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "s", $reason);
    if ($stmt->execute())
    {
        header("location: ../../usercashier/");
    }
    else die ("error");
}
?>