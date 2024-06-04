<?php 
include 'processes/redirect.php';

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
        $_SESSION["contact"] = $_POST["contact"];
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
    <title>Tummy Avenue | Register Account</title>
    
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
            <h2 class="heading">Register &nbsp; Account</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="epic-form" enctype="multipart/form-data" method="post">
                <div>
                    <label>Name</label></br>
                    <input placeholder="Name" class="epic-txtbox" type="text" name="name" value="<?= htmlspecialchars($_POST["name"] ?? "") ?>" required>
                </div>
                <div>
                    <label>Email</label></br>
                    <input placeholder="user@email.com" class="epic-txtbox" type="email" name="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                </div>
                <div>
                    <label>Contact No.</label></br>
                    <input id="contact" placeholder="09XXXXXXXXX" class="epic-txtbox" type="text" maxlength="11" name="contact" value="<?= htmlspecialchars($_POST["contact"] ?? "") ?>" required>
                </div>
                <div>
                    <label>Username</label></br>
                    <input placeholder="Username" class="epic-txtbox" type="text" name="username" value="<?= htmlspecialchars($_POST["username"] ?? "") ?>" required>
                    <?php if ($username_taken): ?>
                        <em style="color: red;">Username already taken</em>
                    <?php endif; ?>
                </div>

                <!-- PASSWORD -->
                <h3 style="margin-top: 30px;">Password</h3>
                <div>
                    <input id="password" placeholder="Password" class="epic-txtbox registerpass" type="password" name="password" required>
                </div>
                <div>
                    <input id="rpassword" placeholder="Repeat Password" class="epic-txtbox registerpass" type="password" required>
                </div>
                <br/>
                <div style="text-align: right;">
                    <button id="btnSubmit" class="epic-btn">Register Account</button>
                    <p class="epic-sansr epic-txt16" style="margin-top: 30px;">Already have an account? <a class="epic-a" style="padding: 0; font-size: 16px;" href="login.php">Login here.</a></p>
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

<script>
let txtPass = document.getElementById("password");
let txtRPass = document.getElementById("rpassword");

let btnSubmit = document.getElementById("btnSubmit");

document.getElementById("contact").addEventListener('input', (e) => {
    var contact = e.target.value;
    var c = contact[contact.length - 1]
    if (!(c >= '0' && c <= '9')) e.target.value = contact.substring(0, contact.length - 1);
})

const passArr = document.querySelectorAll(".registerpass");
passArr.forEach(txt=>{
    txt.addEventListener('input', (e) => {
        if (txtPass.value === txtRPass.value) btnSubmit.disabled = false;
        else btnSubmit.disabled = true;
    })
})
</script>

</body>
</html>