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
    <title>Admin Panel | Reservation History</title>
    
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
            <h2 class="heading">Venue &nbsp; Reservation &nbsp; History</h2>
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
                    <label class="epic-sanssb"><?= $users[$row["user_id"]]["name"] ?> &nbsp;•&nbsp; <span><?= $row["event"] ?></span></label>
                    <input type="hidden" value="<?= $users[$row["user_id"]]["name"] ?>">
                    <input type="hidden" value="<?= $users[$row["user_id"]]["contact"] ?> &nbsp;•&nbsp; <?= $users[$row["user_id"]]["email"] ?>">
                    <input type="hidden" value="<?= get12HourFormat($row["time_start"]) . " - " . get12HourFormat($row["time_end"]) ?>">
                    <input type="hidden" value="<?= $row["event"] ?> &nbsp;•&nbsp; <?= $row["pax"] ?> est. attendees">
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
            <div style="overflow: hidden;">
                <h2 id="modalDateText" style="float: left;">Date</h2>
                <h3 id="modalTimeText" style="float: left; margin-left: 20px;">Time</h3>
            </div>
            <p id="modalCustomer" class="epic-sansr epic-txt16" style="margin: 0;">Customer Name</p>
            <p id="modalContact" class="epic-sansr epic-txt16">Contact No. &nbsp;•&nbsp; Email</p>
            <h3 id="modalDetails">Event &nbsp;•&nbsp; est. attendees</h3>
            <p id="modalRemarks" class="epic-sansr epic-txt16">"<em>Remarks</em>"</p>
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
let txtTime = document.getElementById("modalTimeText");
let txtCustomer = document.getElementById("modalCustomer");
let txtContact = document.getElementById("modalContact");
let txtDetails = document.getElementById("modalDetails");
let txtRemarks = document.getElementById("modalRemarks");
let txtStatus = document.getElementById("modalRsvStatus");

const rsvBtn = document.querySelectorAll("#btnRsv");
rsvBtn.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        valsSec = e.target.parentElement.parentElement.children[0];
        status = e.target.parentElement.children[0].children[0].innerHTML;

        txtDate.innerHTML = valsSec.children[0].innerHTML;
        txtCustomer.innerHTML = valsSec.children[2].value;
        txtContact.innerHTML = valsSec.children[3].value;
        txtTime.innerHTML = valsSec.children[4].value;
        txtDetails.innerHTML = valsSec.children[5].value;

        if (valsSec.children[6].value)
            txtRemarks.innerHTML = '<em>"' + valsSec.children[6].value + '"</em>';
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
