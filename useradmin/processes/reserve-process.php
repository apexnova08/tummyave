<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

// INIT
$id = $_POST["id"];
$rsv = $mysqli->query("SELECT * FROM reservations WHERE id = '$id'")->fetch_assoc();
$rsvdate = $rsv["rsv_date"];
$cdate = getCurrentDateTime();

// RESERVE
if (!$mysqli->query("UPDATE reservations SET status = 'Reserved', process_date = '$cdate' WHERE id = '$id'"))
{
    die ("sex");
}

// DECLINE OTHER REQUESTS ON SAME DATE
if ($mysqli->query("UPDATE reservations SET status = 'Denied', process_date = '$cdate' WHERE rsv_date = '$rsvdate' AND NOT id = '$id'"))
{
    echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
}
else die ("sex");

?>