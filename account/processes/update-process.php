<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

session_start();
$userid = $_SESSION["user_id"];
session_abort();

$user = $mysqli->query("SELECT * FROM users WHERE id = '$userid'")->fetch_assoc();
if (!$user) die ("Error: user not found");

$val = "empty string";
$sql = "";
if (isset($_POST["name"]))
{
    $val = $_POST["name"];
    $sql = "UPDATE users SET name = ? WHERE id = '$userid'";
}
elseif (isset($_POST["username"]))
{
    $val = $_POST["username"];
    $sql = "UPDATE users SET username = ? WHERE id = '$userid'";

    $duperaw = $mysqli->query("SELECT COUNT(*) AS total FROM users WHERE (username = '$val')");
    $dupes = $duperaw->fetch_assoc();
    if ($dupes['total'] != "0") exit("Username already taken");
}
elseif (isset($_POST["email"]))
{
    $val = $_POST["email"];
    $sql = "UPDATE users SET email = ? WHERE id = '$userid'";
}
elseif (isset($_POST["contact"]))
{
    $val = $_POST["contact"];
    $sql = "UPDATE users SET contact = ? WHERE id = '$userid'";
}
elseif (isset($_POST["password"]))
{
    if (password_verify($_POST["cpassword"], $user["password"]))
    {
        $val = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = '$userid'";
    }
    else exit("Incorrect password");
}

// UPDATE
$stmt = $mysqli->stmt_init();
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->errno);
}
mysqli_stmt_bind_param($stmt, "s", $val);
if ($stmt->execute())
{
    echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
}
else die ("Error");
?>