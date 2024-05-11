<?php
session_start();
if (isset($_SESSION["user_id"]))
{
    $mysqli = require __DIR__ . "/../../database.php";
    $result = $mysqli->query("SELECT * FROM users WHERE id = {$_SESSION["user_id"]}");
    $user = $result->fetch_assoc();
    
    if ($user["type"] != "0" && $user["type"] != "4")
    {
        header("Location: ../../");
    }
}
else
{
    header("Location: ../../account/login.php");
}
session_abort();
?>