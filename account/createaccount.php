<?php
session_start();
$userid = "id";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
else header("location: login.php");
$usertype = $_SESSION["user_type"];
session_abort();

$username_taken = false;

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $mysqli = require __DIR__ . "/../database.php";

    $username = $_POST["username"];
    $duperaw = $mysqli->query("SELECT COUNT(*) AS total FROM users WHERE (username = '$username')");
    $dupes = $duperaw->fetch_assoc();
    if ($dupes['total'] === "0")
    {
        session_start();
        session_regenerate_id();

        $_SESSION["name"] = $_POST["name"];
        $_SESSION["type"] = $_POST["type"];
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["password"] = $_POST["password"];

        header("Location: processes/create-process.php");
        exit;
    }
    $username_taken = true;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Register</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>


<!--#####-->
<button onclick="goBack()">Back</button>

<h1>Create Account</h1>
<form method="post">
    <div>
        <label for="type">Account type</label>
        <select name="type" required>
            <?php
            if ($usertype === "0") echo "<option value='1'>Owner</option>", "<option value='2'>Admin</option>";
            if ($usertype === "1") echo "<option value='2'>Admin</option>";
            ?>
            <option value="3">Cashier</option>
        </select>
    </div>
    <br/>

    <div>
        <label for="name">Name</label>
        <input type="text" name="name" required value="<?= htmlspecialchars($_POST["name"] ?? "") ?>">
    </div>
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" required value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
    </div>
    <?php if ($username_taken): ?>
        <em style="color: red;">Username already taken</em>
    <?php endif; ?>
    <br/>

    <div>
        <label for="password">Temporary Passsword</label>
        <input type="hidden" name="password" value="tummypass">
        <input value="tummypass" disabled>
    </div>
    <br/>

    <button>Register</button>
</form>

<script>
function goBack()
{
    history.go(-1);
}
</script>

</body>
</html>