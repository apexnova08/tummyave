<?php
require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

// GET USER ID
session_start();
$userid = "empty";
$usertype = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
if (isset($_SESSION["user_type"])) $usertype = $_SESSION["user_type"];
session_abort();

if ($usertype == "4")
{
    $result = $mysqli->query("SELECT * FROM notifications WHERE user_id = '$userid' LIMIT 1");
    $notif = $result->fetch_assoc();
    if ($notif)
    {
        echo $notif["notification"];

        $notifid = $notif["id"];
        if (!$mysqli->query("DELETE FROM notifications WHERE id = '$notifid'")) die ("Notification error");
    }
}
elseif ($usertype != "empty")
{
    $result = $mysqli->query("SELECT * FROM notifications WHERE user_id = '0' LIMIT 1");
    $notif = $result->fetch_assoc();
    if ($notif)
    {
        echo $notif["notification"];

        $notifid = $notif["id"];
        if (!$mysqli->query("DELETE FROM notifications WHERE id = '$notifid'")) die ("Notification error");
    }
}
?>