<?php 
include 'processes/redirect.php';
?>

<?php
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
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $_POST["password"];

    header("Location: processes/register-process.php");
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

  <!--NAV-->
  <?php 
  include 'nav.html';
  ?>

</head>

<body>


<!--#####-->
<h1>Register Account</h1>
<form method="post">
  <div>
    <label for="name">Name</label>
    <input type="text" id="name" name="name"
    value="<?= htmlspecialchars($_POST["name"] ?? "") ?>">
  </div>
  <div>
    <label for="email">Email</label>
    <input type="email" id="email" name="email"
    value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
  </div>
  <br/>

  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username"
    value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
  </div>
  <?php if ($username_taken): ?>
    <em style="color: red;">Username already taken</em>
  <?php endif; ?>
  <br/>

  <div>
    <label for="password">Passsword</label>
    <input type="password" id="password" name="password">
  </div>
  <br/>
  
  <button>Register</button>

</form>

</body>
</html>
