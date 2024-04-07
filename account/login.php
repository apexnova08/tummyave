<?php 
include 'processes/redirect.php';
?>

<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
  $mysqli = require __DIR__ . "/../database.php";

  $sql = sprintf("SELECT * FROM users WHERE username = '%s'", $mysqli->real_escape_string($_POST["username"]));
  $result = $mysqli->query($sql);
  $user = $result->fetch_assoc();
  if ($user)
  {
    if (password_verify($_POST["password"], $user["password"]))
    {
      session_start();
      session_regenerate_id();
      $_SESSION["user_id"] = $user["id"];

      if ($user["type"] === "0") { header("Location: ../user0/index.php"); }
      elseif ($user["type"] === "1") { header("Location: ../userowner/index.php"); }
      elseif ($user["type"] === "2") { header("Location: ../useradmin/index.php"); }
      elseif ($user["type"] === "3") { header("Location: ../usercashier/index.php"); }
      elseif ($user["type"] === "4") { header("Location: ../index.php"); }

      exit;
    }
  }

  $is_invalid = true;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tummy Avenue | Login</title>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

  <!--NAV-->
  <?php 
  include 'nav.html';
  ?>
</head>

<body>

<!--#####-->
<h1>Login</h1>
<?php if ($is_invalid): ?>
  <em style="color: red;">Invalid login</em>
<?php endif; ?>

<form method="post">
  <div>
    <label for="username">Username</label>
    <input type="text" id="username" name="username"
    value="<?= htmlspecialchars($_POST["username"] ?? "") ?>">
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
  </div>
  <br/>

  <button>Login</button>
</form>

</body>
</html>
