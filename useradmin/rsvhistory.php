<?php
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

// GET USERS
$users = array();
$result_users = $mysqli->query("SELECT * FROM users");
while ($rowuser = $result_users->fetch_assoc())
{
    $users[$rowuser["id"]] = $rowuser;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Menu</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!--#####-->
<section id="reservations" class="padding bg_white">
    <div class="container">
    <div style="text-align: right;"><a href="reservations.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Reservation &nbsp; History</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM reservations WHERE (NOT status = 'Reserved' AND NOT status = 'Requested') OR DATE(rsv_date) <= '" . getCurrentDate() . "' ORDER BY rsv_date DESC");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-6" style="overflow: hidden; margin-bottom: 10px;">
                    <h3 class="epic-bebas"><?= getLongDateFormat($row["rsv_date"]) ?></h3>
                    <label class="epic-sanssb"><?= $users[$row["user_id"]]["name"] ?> &nbsp;•&nbsp; <span><?= $users[$row["user_id"]]["contact"] ?></span></label>
                    <input type="hidden" value="<?= $row["remarks"] ?>">
                </div>
                <div class="col-md-6 right">
                    <label class="epic-sanssb" style="color: <?= getRHSColor($row["status"]) ?>;"><em><?= getRHS($row["status"]) ?></em></label>
                    <button id="btnRsv" class="epic-btn" style="margin-left: 20px;">Details</button>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Reservation &nbsp; Details</h2>
        </div>
        <div class="epic-modal-body" style="overflow: hidden;">
            <h2 id="modalDateText">Date</h2>
            <p id="modalCustomer" class="epic-sanssb epic-txt16">Customer Name &nbsp;•&nbsp; Contact</p>
            <p id="modalRemarks" class="epic-sans epic-txt16">"<em>Remarks</em>"</p>
            <div style="overflow: hidden; margin-top: 20px;">
                <em id="modalRsvStatus" class="epic-sanssb epic-txt16" style="float: right; margin-right: 50px; color: grey;">Reservation Status</em>
            </div>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

<script>
let txtDate = document.getElementById("modalDateText");
let txtCustomer = document.getElementById("modalCustomer");
let txtRemarks = document.getElementById("modalRemarks");
let txtStatus = document.getElementById("modalRsvStatus");

const reqBtn = document.querySelectorAll("#btnReq");
reqBtn.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        valsSec = e.target.parentElement.parentElement.children[0];
        txtDate.innerHTML = valsSec.children[0].innerHTML;
        txtCustomer.innerHTML = valsSec.children[1].innerHTML;

        if (valsSec.children[2].value)
            txtRemarks.innerHTML = '<em>"' + valsSec.children[2].value + '"</em>';
        else
            txtRemarks.innerHTML = "";

        

        formAccept.hidden = false;
        btnRed.name = "reject";
        btnRed.innerHTML = "Deny";
        idAccept.value = valsSec.children[3].value;
        idRed.value = valsSec.children[3].value;
        
        epicOpenModal();
    })
})

const rsvBtn = document.querySelectorAll("#btnRsv");
rsvBtn.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        valsSec = e.target.parentElement.parentElement.children[0];
        status = e.target.parentElement.children[0].children[0].innerHTML;

        txtDate.innerHTML = valsSec.children[0].innerHTML;
        txtCustomer.innerHTML = valsSec.children[1].innerHTML;

        if (valsSec.children[2].value)
            txtRemarks.innerHTML = '<em>"' + valsSec.children[2].value + '"</em>';
        else
            txtRemarks.innerHTML = "";

        if (status === "Reserved") txtStatus.innerHTML = "Reserved";
        else txtStatus.innerHTML = "Reservation " + status;
        
        epicOpenModal();
    })
})
</script>

</body>
</html>
