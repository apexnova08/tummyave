<?php
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

// GET VARS
$vars = array();
$resultvars = $mysqli->query("SELECT * FROM vars");
while ($row = $resultvars->fetch_assoc())
{
    $vars[$row["name"]] = $row["value"];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | System Variables</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    ?>

</head>

<body>

<!-- ##### -->
<section id="vars" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="tummy.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">System &nbsp; Variables</h2>
            <hr class="heading_space">
        </div>
        <div class="col-md-6">
            <!-- ## GCASH ## -->
            <h3 class="epic-sanssb epic-txt25 epic-upper">GCash</h3></br>
            <div style="margin-bottom: 50px; overflow: hidden;">
                <label style="margin-bottom: 10px;">QR Code</label>
                <div class="work-item">
                    <div style="box-shadow: 2px 2px 10px;">
                        <div class="item-container">
                            <img src="../img-uploads/<?= $vars["qrcode"] ?>" style="width: center; height: 300px; object-fit: cover;" alt="QR Code"/>
                            <div class="overlay">
                                <a class="fancybox overlay-inner" href="../img-uploads/<?= $vars["qrcode"] ?>" data-fancybox-group="gallery"><i class=" icon-eye6"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                </br></br>
                <form enctype="multipart/form-data" action="processes/process.php" method="post">
                    <input type="file" class="epic-txtbox" name="image" required>
                    <input id="btnEditQR" name="qr" class="epic-btnr" style="float: right; margin-top: 20px;" type="submit" value="Update QR Code">
                </form>
            </div>
            <form style="overflow: hidden; margin-bottom: 30px;" enctype="multipart/form-data" method="post" action="processes/process.php">
                <div>
                    <div style="margin: 0;">
                        <label>GCash Ref No.</label>
                        <button id="btnEdit" class="epic-btnr" style="margin-left: 20px;" type="button">Edit</button>
                    </div>
                    <input placeholder="09XXXXXXXXX" id="txtVal" class="epic-txtbox" name="gcashnum" type="text" maxlength="11" value="<?= $vars["gcashnum"] ?>" disabled required>
                    <div style="margin: 0; padding-top: 10px;" hidden>
                        <button class="epic-btnr" style="float: right;">Update</button>
                        <button id="btnCancelEdit" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                </div>
            </form>

            </br></br>
            <h3 class="epic-sanssb epic-txt25 epic-upper">Venue</h3></br>
            <form style="overflow: hidden; margin-bottom: 30px;" enctype="multipart/form-data" method="post" action="processes/process.php">
                <div>
                    <div style="margin: 0;">
                        <label>Max Venue Capacity</label>
                        <button id="btnEdit" class="epic-btnr" style="margin-left: 20px;" type="button">Edit</button>
                    </div>
                    <input placeholder="Max No. of People" id="txtVal" class="epic-txtbox" name="pax" type="number" value="<?= $vars["max_pax"] ?>" disabled required>
                    <div style="margin: 0; padding-top: 10px;" hidden>
                        <button class="epic-btnr" style="float: right;">Update</button>
                        <button id="btnCancelEdit" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                </div>
            </form>

            </br></br>
            <h3 class="epic-sanssb epic-txt25 epic-upper">Google Map</h3></br>
            <form style="overflow: hidden; margin-bottom: 30px;" enctype="multipart/form-data" method="post" action="processes/process.php">
                <div>
                    <div style="margin: 0;">
                        <label>Embed Code</label>
                        <button id="btnEdit" class="epic-btnr" style="margin-left: 20px;" type="button">Edit</button>
                    </div>
                    <input placeholder="Google Maps Embedded HTML" id="txtVal" class="epic-txtbox" name="map" type="text" disabled required>
                    <div style="margin: 0; padding-top: 10px;" hidden>
                        <button class="epic-btnr" style="float: right;">Update</button>
                        <button id="btnCancelEdit" class="epic-btnrred" style="float: right; margin-right: 10px;" type="button">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
include '../global/uf/adminfooter.php';
?>

<script type="text/javascript">

var tempString = "";
const editBtns = document.querySelectorAll("#btnEdit");
editBtns.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        const siblings = e.target.parentElement.parentElement.children;
        e.target.hidden = true;
        siblings[1].disabled = false;
        siblings[2].hidden = false;

        for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = true;
        document.getElementById("btnEditQR").disabled = true;
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
        document.getElementById("btnEditQR").disabled = false;
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
</script>

</body>
</html>
