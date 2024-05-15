<?php
session_start();
$userid = "id";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
else header("location: login.php");
session_abort();

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

$user = $mysqli->query("SELECT * FROM users WHERE id = '$userid'")->fetch_assoc();
if (!$user) die ("Error: user not found");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Menu</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>


<!--#####-->
<button onclick="goBack()">Back</button>

<div>
    <h1>Your <?= $usertypes[$user["type"]] ?> Account</h1>
    <h3>Information</h3>
    <form enctype="multipart/form-data" action="processes/update-process.php" method="post">
        <label for="name">Name:</label>
        <div>
            <input id="txtVal" style="float: left;" name="name" type="text" value="<?= $user["name"] ?>" disabled="true">
            <button style="margin-left: 20px;" id="btnEdit" type="button">Edit</button>
            <button style="margin-left: 20px;" hidden="true">Update</button>
            <button style="background-color: red;" id="btnCancelEdit" type="button" hidden="true">Cancel</button>
        </div>
    </form>
    <form enctype="multipart/form-data" action="processes/update-process.php" method="post">
        <label for="username">Username:</label>
        <div>
            <input id="txtVal" style="float: left;" name="username" type="text" value="<?= $user["username"] ?>" disabled="true">
            <button style="margin-left: 20px;" id="btnEdit" type="button">Edit</button>
            <button style="margin-left: 20px;" hidden="true">Update</button>
            <button style="background-color: red;" id="btnCancelEdit" type="button" hidden="true">Cancel</button>
        </div>
    </form>

    <!-- ## FOR CUSTOMERS ## -->
    <?php
    if ($user["type"] === "4")
    {
    ?>
    <form enctype="multipart/form-data" action="processes/update-process.php" method="post">
        <label for="email">Email:</label>
        <div>
            <input id="txtVal" style="float: left;" name="email" type="email" value="<?= $user["email"] ?>" disabled="true">
            <button style="margin-left: 20px;" id="btnEdit" type="button">Edit</button>
            <button style="margin-left: 20px;" hidden="true">Update</button>
            <button style="background-color: red;" id="btnCancelEdit" type="button" hidden="true">Cancel</button>
        </div>
    </form>
    <form enctype="multipart/form-data" action="processes/update-process.php" method="post">
        <label for="contact">Contact No.:</label>
        <div>
            <input id="txtVal" style="float: left;" name="contact" type="text" maxlength="11" value="<?= $user["contact"] ?>" disabled="true">
            <button style="margin-left: 20px;" id="btnEdit" type="button">Edit</button>
            <button style="margin-left: 20px;" hidden="true">Update</button>
            <button style="background-color: red;" id="btnCancelEdit" type="button" hidden="true">Cancel</button>
        </div>
    </form>
    <?php
    }
    ?>

    <h3>Password</h3>
    <form enctype="multipart/form-data" action="processes/update-process.php" method="post">
        <button id="btnEditPass" type="button">Edit password</button>
        <div id="pnlPassword" hidden="true">
            <label for="cpassword">Current Password:</label>
            <input name="cpassword" type="password">
            <label for="password">New Password:</label>
            <input id="txtPass" name="password" type="password">
            <button disabled="true">Update</button>
            <button id="btnCancelEditPass" style="background-color: red;" type="button">Cancel</button>
        </div>
    </form>
</div>
</br></br>

<a href="logout.php"><button style="background-color: red;">Logout</button></a>

<script type="text/javascript">
function goBack()
{
    history.go(-1);
}

// INFO
var tempString = "";
const editBtns = document.querySelectorAll("#btnEdit");
editBtns.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        const siblings = e.target.parentElement.children;
        siblings[0].disabled = false;
        siblings[1].hidden = true;
        siblings[2].hidden = false;
        siblings[3].hidden = false;

        for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = true;
        document.getElementById("btnEditPass").disabled = true;
        tempString = siblings[0].value;
    })
})
const editCancelBtns = document.querySelectorAll("#btnCancelEdit");
editCancelBtns.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        const siblings = e.target.parentElement.children;
        siblings[0].disabled = true;
        siblings[1].hidden = false;
        siblings[2].hidden = true;
        siblings[2].disabled = false;
        siblings[3].hidden = true;

        for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = false;
        document.getElementById("btnEditPass").disabled = false;
        siblings[0].value = tempString;
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
    siblings[0].hidden = true;
    siblings[1].hidden = false;

    for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = true;
})
document.getElementById("btnCancelEditPass").addEventListener('click', (e) => {
    const pSiblings = e.target.parentElement.parentElement.children;
    pSiblings[0].hidden = false;
    pSiblings[1].hidden = true;
    e.target.previousElementSibling.disabled = true;

    for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = false;
    pSiblings[1].children[1].value = "";
    pSiblings[1].children[3].value = "";
})
document.getElementById("txtPass").addEventListener('input', (e) => {
    var btn = e.target.nextElementSibling;
    if (/\S/.test(e.target.value)) btn.disabled = false;
    else btn.disabled = true;
})

</script>

</body>
</html>