<?php
session_start();
$userid = "id";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
else header("location: login.php");
$usertype = $_SESSION["user_type"];
session_abort();

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

$username_taken = false;

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $username = $_POST["username"];
    $duperaw = $mysqli->query("SELECT COUNT(*) AS total FROM users WHERE (username = '$username')");
    $dupes = $duperaw->fetch_assoc();
    if ($dupes['total'] === "0")
    {
        $name = $_POST["name"];
        $type = $_POST["type"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $passwordhash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, username, password, type, disabled) VALUES (?, ?, ?, ?, 0)";
        $stmt = $mysqli->stmt_init();
        if (!$stmt->prepare($sql)) {
            die("SQL error: " . $mysqli->errno);
        }
        mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $passwordhash, $type);
        if ($stmt->execute())
        {
            echo '<script type="text/javascript">', 'history.go(-2);', '</script>';
        }
        else die ("Error");
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
    <title>Admin Panel | Menu</title>
    
    <!--CSS-->
    <?php 
    include '../global/uf/css.html';
    include '../global/uf/top.html';
    ?>

</head>

<body>

<!--#####-->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="javascript:history.go(-1);" class="epic-a"><< Back</a></div>
        <div class="text-center">
            <h2 class="heading">Create &nbsp; an &nbsp; Account</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="epic-form" enctype="multipart/form-data" method="post">
                <div>
                    <label>Account type</label></br>
                    <select class="epic-txtbox" style="text-align: center;" name="type" required>
                        <?php
                        if ($usertype === "0") echo "<option value='1'>Owner</option>", "<option value='2'>Admin</option>";
                        if ($usertype === "1") echo "<option value='2'>Admin</option>";
                        ?>
                        <option value="3">Cashier</option>
                    </select>
                </div>
                <div>
                    <label>Name</label></br>
                    <input placeholder="Name" class="epic-txtbox" type="text" name="name" value="<?= htmlspecialchars($_POST["name"] ?? "") ?>" required>
                </div>
                <div>
                    <label>Username</label></br>
                    <input placeholder="Username" class="epic-txtbox" type="text" name="username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required>
                    <?php if ($username_taken): ?>
                        <em style="color: red;">Username already taken</em>
                    <?php endif; ?>
                </div>
                <div>
                    <label>Temporary Passsword</label></br>
                    <input type="hidden" name="password" value="tummypass">
                    <input class="epic-txtbox" value="tummypass" disabled>
                </div>
                <br/>
                <button class="epic-btn" style="float: right;">Register</button>
            </form>
        </div>
    </div>
</section>

<!--Page Footer-->
<?php 
include '../global/uf/footer.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>