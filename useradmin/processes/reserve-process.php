<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

// INIT
$id = $_POST["id"];

if (isset($_POST["accept"]))
{
    $rsv = $mysqli->query("SELECT * FROM reservations WHERE id = '$id'")->fetch_assoc();
    $rsvdate = $rsv["rsv_date"];
    $cdate = getCurrentDateTime();

    // RESERVE
    if (!$mysqli->query("UPDATE reservations SET status = 'Reserved', process_date = '$cdate' WHERE id = '$id'"))
    {
        die ("error");
    }

    // DECLINE OTHER REQUESTS ON SAME DATE
    if ($mysqli->query("UPDATE reservations SET status = 'Denied', process_date = '$cdate' WHERE rsv_date = '$rsvdate' AND NOT id = '$id'"))
    {
        header("location: ../reservations.php");
    }
    else die ("error");
}
else if (isset($_POST["reject"]))
{
    $cdate = getCurrentDateTime();
    if ($mysqli->query("UPDATE reservations SET status = 'Denied', process_date = '$cdate' WHERE id = '$id'"))
    {
        header("location: ../reservations.php");
    }
    else die ("error");
}
else if (isset($_POST["close"]))
{
    $cdate = getCurrentDateTime();
    if ($mysqli->query("UPDATE reservations SET status = 'Cancelled', process_date = '$cdate' WHERE id = '$id'"))
    {
        header("location: ../reservations.php");
    }
    else die ("error");
}

?>