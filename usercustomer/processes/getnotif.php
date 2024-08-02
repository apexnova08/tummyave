<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

// GET USER ID
session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

$result = $mysqli->query("SELECT * FROM notifications WHERE user_id = '$userid' LIMIT 1");
$notif = $result->fetch_assoc();
if ($notif)
{
    echo $notif["notification"];

    $notifid = $notif["id"];
    if (!$mysqli->query("DELETE FROM notifications WHERE id = '$notifid'")) die ("Notification error");
}
?>