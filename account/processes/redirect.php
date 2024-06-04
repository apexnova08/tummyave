<?php
session_start();
if (isset($_SESSION["user_id"]))
{
    $mysqli = require __DIR__ . "/../../database.php";
    $result = $mysqli->query("SELECT * FROM users WHERE id = {$_SESSION["user_id"]}");
    $user = $result->fetch_assoc();
    
    if ($user["type"] === "0") { header("Location: ../user0/"); }
    elseif ($user["type"] === "1") { header("Location: ../userowner/"); }
    elseif ($user["type"] === "2") { header("Location: ../useradmin/"); }
    elseif ($user["type"] === "3") { header("Location: ../usercashier/"); }
    elseif ($user["type"] === "4") { header("Location: ../"); }
    exit;
}
session_abort();
?>