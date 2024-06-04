<?php
include 'processes/redirect.php';

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $mysqli = require __DIR__ . "/../database.php";

    $sql = sprintf("SELECT * FROM users WHERE NOT `disabled` AND username = '%s'", $mysqli->real_escape_string($_POST["username"]));
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
    if ($user)
    {
        if (password_verify($_POST["password"], $user["password"]))
        {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_type"] = $user["type"];
            $_SESSION["password"] = $user["password"];

            if ($user["type"] === "0") { header("Location: ../user0/"); }
            elseif ($user["type"] === "1") { header("Location: ../userowner/"); }
            elseif ($user["type"] === "2") { header("Location: ../useradmin/"); }
            elseif ($user["type"] === "3") { header("Location: ../usercashier/"); }
            elseif ($user["type"] === "4")
            {
                if ($user["activated"]) header("Location: ../");
                else header("Location: verify.php");
            }

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
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include '../global/uf/top.html';
    ?>

</head>

<body>

<!--#####-->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="../" class="epic-a"><< Home</a></div>
        <div class="text-center">
            <h2 class="heading">Login</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="epic-form" enctype="multipart/form-data" method="post">
                <?php if ($is_invalid): ?>
                    <em style="color: red;">Invalid login</em></br></br>
                <?php endif; ?>
                <div>
                    <label>Username</label></br>
                    <input placeholder="Username" class="epic-txtbox" type="text" name="username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required>
                </div>
                <div>
                    <label>Password</label></br>
                    <input placeholder="Password" class="epic-txtbox" type="password" name="password" required>
                    <div style="text-align: right;"><a href="forgetpass.php" class="epic-a" style="padding: 0; font-size: 16px;">Forgot password?</a></div>
                </div>
                <br/>
                <div style="text-align: right;">
                    <button class="epic-btn">Login</button>
                    <p class="epic-sansr epic-txt16" style="margin-top: 30px;">Don't have an account? <a class="epic-a" style="padding: 0; font-size: 16px;" href="register.php">Register here.</a></p>
                </div>
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