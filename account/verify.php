<?php
include '../usercustomer/processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

$is_incorrect = false;

session_start();
$userid = $_SESSION["user_id"];
session_abort();  

$result = $mysqli->query("SELECT * FROM users WHERE id = '$userid'");
$user = $result->fetch_assoc();
$otpdate = $user["otp_date"];
$cdate = getCurrentDateTime();

if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (password_verify($_POST["otp"], $user["otp"]))
    {
        $sql = "UPDATE users SET activated = true, otp = NULL, otp_date = NULL WHERE id = '$userid'";
        if ($mysqli->query($sql)) header("Location: ../");
        else die ("Error");

        exit;
    }
    $is_incorrect = true;
}
elseif ($user["activated"]) header("Location: ../");
elseif (!$user["otp_date"] || strtotime($user["otp_date"]) < strtotime($cdate))
{
    $otphash = password_hash(sendOTP($user["email"], $user["name"]), PASSWORD_DEFAULT);
    $date = date_add(new DateTime($cdate), new DateInterval('PT' . 2 . 'M'));
    $otpdate = $date->format("Y/m/d H:i:s");

    $sql = "UPDATE users SET otp = ?, otp_date = ? WHERE id = '$userid'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "ss", $otphash, $otpdate);
    if (!$stmt->execute()) die ("Error");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Verify Account</title>
    
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
            <h2 class="heading">Verify &nbsp; Your &nbsp; Email</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="epic-form" enctype="multipart/form-data" method="post">
                <input id="otpDate" type="hidden" value="<?= $otpdate ?>">
                <p class="epic-sanssb">An OTP has been sent to your email address <span class="epic-sansb"><?= hideEmail($user["email"]) ?></span></p>
                <br/>
                <div>
                    <label>6-Digit Pin Code</label></br>
                    <input id="otp" placeholder="XXXXXX" class="epic-txtbox" type="text" maxlength="6" name="otp" required>
                    <?php if ($is_incorrect): ?>
                        <em style="color: red;">Incorrect Pin</em>
                    <?php endif; ?>
                </div>
                
                </br></br></br>
                <div style="text-align: right;">
                    <button class="epic-btn">Submit</button>
                    </br></br>
                    <a id="counter" class="epic-a disabled" style="padding: 0; font-size: 16px;" href="verify.php">Resend OTP</a>
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
document.getElementById("otp").addEventListener('input', (e) => {
    var contact = e.target.value;
    var c = contact[contact.length - 1]
    if (!(c >= '0' && c <= '9')) e.target.value = contact.substring(0, contact.length - 1);
})

var countDownDate = new Date(document.getElementById("otpDate").value).getTime();

var x = setInterval(function() {
    var now = new Date().getTime();
    var count = Math.floor((countDownDate - now) / 1000);

    document.getElementById("counter").innerHTML = "Resend OTP in " + count + "s ";

    if (count < 0) {
        clearInterval(x);
        document.getElementById("counter").innerHTML = "Resend OTP";
        document.getElementById("counter").classList.remove("disabled");
    }
}, 1000);
</script>

</body>
</html>