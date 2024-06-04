<?php
include 'processes/settings-redirect.php';

session_start();
$userid = $_SESSION["user_id"];
$usertype = $_SESSION["user_type"];
session_abort();

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    $user = $mysqli->query("SELECT * FROM users WHERE id = '$id'")->fetch_assoc();
}
else $user = $mysqli->query("SELECT * FROM users WHERE id = '$userid'")->fetch_assoc();
if (!$user) die ("Error: user not found");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Account</title>
    
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
            <h2 class="heading">Your &nbsp; <?= $usertypes[$user["type"]] ?> &nbsp; Account</h2>
            <hr class="heading_space">
        </div>
        <div>
            <form class="epic-form" enctype="multipart/form-data" action="processes/update-process.php" method="post">
                <div>
                    <div style="margin: 0;">
                        <label>Name</label>
                        <?php
                        if ($usertype != "3") { ?> <button id="btnEdit" class="epic-btnr" style="margin-left: 20px;" type="button">Edit</button> <?php }
                        ?>
                    </div>
                    <input placeholder="Name" id="txtVal" class="epic-txtbox" style="float: left;" name="name" type="text" value="<?= $user["name"] ?>" disabled>
                    <div style="margin: 0; padding-top: 10px;" hidden>
                        <button class="epic-btnr" style="float: right;">Update</button>
                        <button id="btnCancelEdit" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                    <?php if (isset($_POST["id"])) echo "<input type='hidden' name='updateid' value=" . $_POST["id"] . ">" ?>
                </div>
            </form>
            <form class="epic-form" enctype="multipart/form-data" action="processes/update-process.php" method="post">
                <div>
                    <div style="margin: 0;">
                        <label>Username</label>
                        <?php
                        if ($usertype != "3") { ?> <button id="btnEdit" class="epic-btnr" style="margin-left: 20px;" type="button">Edit</button> <?php }
                        ?>
                    </div>
                    <input placeholder="Username" id="txtVal" class="epic-txtbox" style="float: left;" name="username" type="text" value="<?= $user["username"] ?>" disabled>
                    <div style="margin: 0; padding-top: 10px;" hidden>
                        <button class="epic-btnr" style="float: right;">Update</button>
                        <button id="btnCancelEdit" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                    <?php if (isset($_POST["id"])) echo "<input type='hidden' name='updateid' value=" . $_POST["id"] . ">" ?>
                </div>
            </form>

            <!-- ## FOR CUSTOMERS ## -->
            <?php
            if ($user["type"] === "4")
            {
            ?>
            <form class="epic-form" enctype="multipart/form-data" action="processes/update-process.php" method="post">
                <div>
                    <div style="margin: 0;">
                        <label>Contact No.</label>
                        <button id="btnEdit" class="epic-btnr" style="margin-left: 20px;" type="button">Edit</button>
                    </div>
                    <input placeholder="09XXXXXXXXX" id="txtVal" class="epic-txtbox" style="float: left;" name="contact" type="text" maxlength="11" value="<?= $user["contact"] ?>" disabled>
                    <div style="margin: 0; padding-top: 10px;" hidden>
                        <button class="epic-btnr" style="float: right;">Update</button>
                        <button id="btnCancelEdit" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                </div>
            </form>
            <form class="epic-form" enctype="multipart/form-data" action="processes/update-process.php" method="post">
                <div>
                    <div style="margin: 0;">
                        <label>Email</label>
                        <button id="btnEdit" class="epic-btnr" style="margin-left: 20px;" type="button">Edit</button>
                    </div>
                    <input placeholder="user@email.com" id="txtVal" class="epic-txtbox" style="float: left;" name="email" type="email" value="<?= $user["email"] ?>" disabled>
                    <div style="margin: 0; padding-top: 10px;" hidden>
                        <button class="epic-btnr" style="float: right;">Update</button>
                        <button id="btnCancelEdit" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                </div>
            </form>
            <?php
            }
            ?>
            </br>

            <!-- ## PASSWORD ## -->
            <?php
            if ($usertype != "3") {
            ?>
            <form class="epic-form" enctype="multipart/form-data" action="processes/update-process.php" method="post">
                <h3>Password</h3>
                <button id="btnEditPass" class="epic-btnr" style="margin-top: 10px;" type="button">Edit password</button>
                <div id="pnlPassword" style="margin-top: 10px;" hidden>
                    <?php
                    if (!isset($_POST["id"])) {
                    ?>
                    <label>Current Password</label>
                    <input placeholder="Current Password" class="epic-txtbox" name="cpassword" type="password">
                    <?php
                    } else echo "<input type='hidden' name='updateid' value=" . $_POST["id"] . ">";
                    ?>
                    <label>New Password</label>
                    <input placeholder="New Password" id="txtPass" class="epic-txtbox" name="password" type="password">
                    <div style="margin: 0; padding-top: 10px;">
                        <button id="btnSubmitPass" class="epic-btnr" style="float: right;" disabled>Update</button>
                        <button id="btnCancelEditPass" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                </div>
            </form>
            </br></br>
            <?php } ?>
            <div class="epic-form" style="text-align: right; margin-top: 50px;">
                <a href="logout.php"><button class="epic-btnred">Logout</button></a>
            </div>
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

<script type="text/javascript">

// INFO
var tempString = "";
const editBtns = document.querySelectorAll("#btnEdit");
editBtns.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        const siblings = e.target.parentElement.parentElement.children;
        e.target.hidden = true;
        siblings[1].disabled = false;
        siblings[2].hidden = false;

        for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = true;
        document.getElementById("btnEditPass").disabled = true;
        tempString = siblings[1].value;
    })
})
const editCancelBtns = document.querySelectorAll("#btnCancelEdit");
editCancelBtns.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        const siblings = e.target.parentElement.parentElement.children;
        siblings[0].children[1].hidden = false;
        siblings[1].disabled = true;
        siblings[2].hidden = true;

        for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = false;
        document.getElementById("btnEditPass").disabled = false;
        siblings[1].value = tempString;
    })
})
const txtVal = document.querySelectorAll("#txtVal");
txtVal.forEach(txt=>{
    txt.addEventListener('input', (e) => {
        if (e.target.name === "contact")
        {
            var contact = e.target.value;
            var c = contact[contact.length - 1]
            if (!(c >= '0' && c <= '9')) e.target.value = contact.substring(0, contact.length - 1);
        }

        var btn = e.target.parentElement.children[2];
        if (/\S/.test(e.target.value)) btn.disabled = false;
        else btn.disabled = true;
    })
})


// PASSWORD
document.getElementById("btnEditPass").addEventListener('click', (e) => {
    const siblings = e.target.parentElement.children;
    siblings[1].hidden = true;
    siblings[2].hidden = false;

    for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = true;
})
document.getElementById("btnCancelEditPass").addEventListener('click', (e) => {
    const pSiblings = e.target.parentElement.parentElement.parentElement.children;
    pSiblings[1].hidden = false;
    pSiblings[2].hidden = true;
    document.getElementById("btnSubmitPass").disabled = true;

    for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = false;
    pSiblings[2].children[1].value = "";
    pSiblings[2].children[3].value = "";
})
document.getElementById("txtPass").addEventListener('input', (e) => {
    var btn = document.getElementById("btnSubmitPass");
    if (/\S/.test(e.target.value)) btn.disabled = false;
    else btn.disabled = true;
})

</script>

</body>
</html>