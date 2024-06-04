<?php
session_start();
if (isset($_SESSION["user_id"]))
{
    $mysqli = require __DIR__ . "/../../database.php";
    $result = $mysqli->query("SELECT * FROM users WHERE id = {$_SESSION["user_id"]} AND NOT `disabled`");
    $user = $result->fetch_assoc();
    
    if (!$user || $user["password"] != $_SESSION["password"])
    {
        header("Location: logout.php");
        exit;
    }
}
else
{
    header("Location: login.php");
    exit;
}
session_abort();
?>