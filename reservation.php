<?php
$mysqli = require __DIR__ . "/database.php";
require __DIR__ . "/global/funcs.php";

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

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
<title>Tummy Avenue | Venue Reservation</title>

<!--CSS-->
<?php 
include 'global/customercss.html';
?>
</head>

<body>
<?php 
include 'global/loader.html';
include 'global/customerheader.php';
?>
<!--Page header & Title-->
<section id="page_header">
    <div class="page_title">
        <div class="container">
            <div class="col-md-12">
                <h2 class="title">Book &nbsp; a &nbsp; Venue &nbsp; reservation</h2>
            </div>
        </div>
    </div>  
</section>

<!-- ## CONTENT HERE ## -->
<section id="reservations" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Your &nbsp; Venue &nbsp; Reservations</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result_rsv = $mysqli->query("SELECT * FROM reservations WHERE user_id = '$userid' AND status = 'Reserved' AND DATE(rsv_date) > '" . getCurrentDate() . "'");
            while ($rowrsv = $result_rsv->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8">
                    <h3 class="epic-bebas"><?= getLongDateFormat($rowrsv["rsv_date"]) ?></h3>
                    <p class="epic-sanssb"><?= getWeekDayName($rowrsv["rsv_date"])["dddd"] ?> &nbsp;•&nbsp; <?= $rowrsv["event"] ?></p>
                </div>
                <div class="col-md-4" style="text-align: right;">
                    <label class="epic-bebas" style="margin-right: 20px; font-weight: normal; color: #E25111;">Reserved</label>
                </div>
            </div>
            <?php
            }
            $result_req = $mysqli->query("SELECT * FROM reservations WHERE user_id = '$userid' AND status = 'Requested' AND DATE(rsv_date) > '" . getCurrentDate() . "'");
            while ($rowreq = $result_req->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8">
                    <h3 class="epic-bebas"><?= getLongDateFormat($rowreq["rsv_date"]) ?></h3>
                    <p class="epic-sanssb"><?= getWeekDayName($rowreq["rsv_date"])["dddd"] ?> &nbsp;•&nbsp; <?= $rowreq["event"] ?></p>
                </div>
                <div class="col-md-4" style="text-align: right;">
                    <form method="post" action="usercustomer/processes/reserve-process.php" style="margin: auto;">
                        <label class="epic-sanssb" style="margin-right: 20px;"><i>Requested</i></label>
                        <input type="hidden" name="id" value="<?= $rowreq["id"] ?>">
                        <input type="submit" class="epic-btn" name="cancel" value="Cancel">
                    </form>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result_rsv) === 0 && mysqli_num_rows($result_req) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>


<section id="reserve" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Request &nbsp; For &nbsp; a &nbsp; Venue &nbsp; Reservation</h2>
            <hr class="heading_space">
        </div>
        <div class="epic-calendar">
            <?php
            $dateTime = getCurrentDateTime();
            $cYear = getYear($dateTime);
            $cMonth = getMonth($dateTime);
            $cDay = getDay($dateTime);

            $sYear = $cYear;
            $sMonth = $cMonth;
            $sDay = $cDay;

            // SET MONTH AND YEAR
            if (isset($_GET["monthNext"]))
            {
                if ($_GET["monthNext"] == 12)
                {
                    $sMonth = "1";
                    $sYear = (string)($_GET["year"] + 1);
                }
                else 
                {
                    $sMonth = (string)($_GET["monthNext"] + 1);
                    $sYear = (string)$_GET["year"];
                }
            }
            if (isset($_GET["monthPrev"]))
            {
                if ($_GET["monthPrev"] == 1)
                {
                    $sMonth = "12";
                    $sYear = (string)($_GET["year"] - 1);
                }
                else 
                {
                    $sMonth = (string)($_GET["monthPrev"] - 1);
                    $sYear = (string)$_GET["year"];
                }
            }
            ?>
            <div class="epic-month">      
                <ul>
                    <li class="prev">
                        <form method="get">
                            <input type="submit" value="&#10094" style="width: 50px">
                            <input type="hidden" name="monthPrev" value="<?= (int)$sMonth ?>">
                            <input type="hidden" name="year" value="<?= (int)$sYear ?>">
                        </form>
                    </li>
                    <li class="next">
                        <form method="get">
                            <input type="submit" value="&#10095" style="width: 50px">
                            <input type="hidden" name="monthNext" value="<?= (int)$sMonth ?>">
                            <input type="hidden" name="year" value="<?= (int)$sYear ?>">
                        </form>
                    </li>
                    <li>
                    <h2 id="selectedMonth"><?= getMonthName($sMonth)["MMMM"] ?></h2>
                    <span id="selectedYear" class="epic-sanssb" style="font-size:18px"><?= $sYear ?></span>
                    </li>
                </ul>
            </div>

            <ul class="epic-weekdays">
                <li>Sun</li>
                <li>Mon</li>
                <li>Tue</li>
                <li>Wed</li>
                <li>Thu</li>
                <li>Fri</li>
                <li>Sat</li>
            </ul>

            <ul class="epic-days">
                <?php
                $daysInMonth = getDaysOfMonth($sYear, $sMonth);
                $startDay = getDayOfWeek($sYear, $sMonth, "01");
                for ($i = 1 - $startDay; ; $i++)
                {
                    if ($i >= 1)
                    {
                        if ($sYear > $cYear) DisplayDay($sYear, $sMonth, $i, $userid);
                        elseif ($sYear < $cYear) { ?> <li><div class="epic-dayDisabled"><div><?= $i ?></div></div></li> <?php }
                        else
                        {
                            if ($sMonth > $cMonth) DisplayDay($sYear, $sMonth, $i, $userid);
                            elseif ($sMonth < $cMonth) { ?> <li><div class="epic-dayDisabled"><div><?= $i ?></div></div></li> <?php }
                            else
                            {
                                if ($i === (int)$cDay) { ?> <li><div class="epic-dayDisabled" style="color: #FFBBA1;"><div><b><?= $i ?></b></div></div></li> <?php }
                                elseif ($i >= (int)$cDay) DisplayDay($sYear, $sMonth, $i, $userid);
                                elseif ($i <= (int)$cDay) { ?> <li><div class="epic-dayDisabled"><div><?= $i ?></div></div></li> <?php }
                            }
                        }
                    } else { ?> <li></li> <?php }
                    if ($i >= $daysInMonth) break;
                }

                // DISABLE RESERVED DAYS
                function DisplayDay(string $sYear, string $sMonth, int $sDay, string $userid)
                {
                    $mysqli = require __DIR__ . "/database.php";
                    $date = $sYear . "/" . $sMonth . "/" . $sDay;
                    $rsv = $mysqli->query("SELECT * FROM reservations WHERE rsv_date = '$date' AND (status = 'Reserved' OR (status = 'Requested' AND user_id = '$userid')) LIMIT 1")->fetch_assoc();

                    if ($rsv)
                    {
                        if ($rsv["status"] === "Reserved") { ?> <li><div class="<?php if ($rsv["user_id"] === $userid) echo "epic-user-reserved"; else echo "epic-dayDisabled"; ?>"><div style="padding-top: 5px;"><label><?= $sDay ?></label><label class="epic-bebas">Reserved</label></div></div></li> <?php }
                        else { ?> <li><div class="epic-dayDisabled"><div style="padding-top: 5px;"><label><?= $sDay ?></label><label><i>Requested</i></label></div></div></li> <?php }
                    }
                    else { ?> <li><div class="epic-dayEnabled"><div id="epicday"><?= $sDay ?></div></div></li> <?php }
                }
                ?>
            </ul>
        </div>
        <h4 class="epic-sanssb" style="width: 100%; text-align: center;"><i>(Select a suitable date to reserve)</i></h4>
    </div>
</section>

<section id="gallery" class="padding bg_white">
    <div class="container">
        <div class="text-center">
            <h2 class="heading">Our &nbsp; Recent &nbsp; Events</h2>
            <hr class="heading_space">
        </div>
        <div class="col-md-12">
            <div class="cheffs_wrap_slider">
                <div id="news-slider" class="owl-carousel">

                    <?php
                    $resultfeat = $mysqli->query("SELECT * FROM event_gallery ORDER BY `date` DESC");
                    while ($row = $resultfeat->fetch_assoc()) {
                    ?>
                    <a class="fancybox" href="img-uploads/<?= $row["filename"] ?>"><div id="newsItem" class="item epic-texthover" style="padding: 0; margin: 10px; box-shadow: 2px 2px 10px;">
                        <div class="news_content" style="pointer-events: none;">
                            <img src="img-uploads/<?= $row["filename"] ?>" style="width: center; height: 255px; object-fit: cover;" alt="image">
                        </div>
                    </div></a>
                    <?php
                    }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>



<!--Page Footer-->
<?php 
include 'global/customerfooter.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--Notifications-->
<section id="notifContainer" class="epic-notifcontainer">
</section>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Request &nbsp; a &nbsp; Venue &nbsp; Reservation</h2>
        </div>
        <div class="epic-modal-body">
            <h3>Submit a venue reservation request on:</h3></br>
            <h2 id="modalDateString"></h2></br></br>
            <form action="usercustomer/processes/reserve-process.php" method="post" style="overflow: hidden;">
                <!-- Time -->
                <div style="position: relative; overflow: hidden;">
                    <div style="width: 50%; float: left;">
                        <label class="epic-sansr">From</label>
                        <input id="modalTimeS" class="epic-txtbox" name="timeS" type="time" value="07:00" required>
                    </div>
                    <div style="width: 50%; float: left; padding-left: 20px;">
                        <label class="epic-sansr">To</label>
                        <input id="modalTimeE" class="epic-txtbox" name="timeE" type="time" value="18:00" required>
                    </div>
                </div></br>
                <!-- Dropdowns -->
                <div style="position: relative; overflow: hidden;">
                    <div style="width: 50%; float: left;">
                        <label class="epic-sansr">Venue Event</label>
                        <select class="epic-txtbox" name="event" required>
                            <?php
                            $resultctg = $mysqli->query("SELECT * FROM rsv_categories WHERE NOT `hidden`");
                            while ($row = $resultctg->fetch_assoc()) {
                            ?>
                            <option value="<?= $row["name"] ?>"><?= $row["name"] ?></option>
                            <?php
                            }
                            ?>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div style="width: 50%; float: left; padding-left: 20px;">
                        <label class="epic-sansr">Estimated amount of Pax</label>
                        <select class="epic-txtbox" name="pax" required>
                            <?php
                            foreach (generatePaxList((int)$vars["max_pax"]) as $x) {
                            ?>
                            <option value="<?= $x ?>"><?= $x ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div></br>
                <!-- Remarks -->
                <label hidden class="epic-sansr">Remarks (Optional)</label>
                <textarea hidden placeholder="Type here..." id="modalRemarks" style="width: 100%; height: 100px; padding: 10px; overflow: auto; resize: none;" name="remarks"></textarea>
                <input type="hidden" name="day" id="submitDay">
                <input type="hidden" name="month" value="<?= $sMonth ?>">
                <input type="hidden" name="year" value="<?= $sYear ?>">
                <div style="text-align: right; margin-top: 10px;">
                    <input class="epic-btn" name="request" type="submit">
                </div>
            </form>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<!--JS-->
<?php 
include 'global/customerjs.html';
?>
<script>
let year = document.getElementById("selectedYear").innerHTML;
let month = document.getElementById("selectedMonth").innerHTML;
let txtDate = document.getElementById("modalDateString");

let timeStart = document.getElementById("modalTimeS");
let timeEnd = document.getElementById("modalTimeE");

const daysArr = document.querySelectorAll("#epicday");
daysArr.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        daystring = e.target.innerHTML.trim();
        document.getElementById("modalRemarks").value = "";
        
        weekDay = "";
        weekDayNum = new Date(month + " " + daystring + ", " + year).getDay();
        if (weekDayNum === 0) weekDay = "Sunday";
        else if (weekDayNum === 1) weekDay = "Monday";
        else if (weekDayNum === 2) weekDay = "Tuesday";
        else if (weekDayNum === 3) weekDay = "Wednesday";
        else if (weekDayNum === 4) weekDay = "Thursday";
        else if (weekDayNum === 5) weekDay = "Friday";
        else if (weekDayNum === 6) weekDay = "Saturday";

        txtDate.innerHTML = month + " &nbsp; " + daystring + ", &nbsp; " + year + " &nbsp; (" + weekDay + ")";
        
        document.getElementById("submitDay").value = daystring;
        epicOpenModal();
    })
})

timeStart.addEventListener('change', (e) => {
    timeEnd.min = timeStart.value;
    if (timeEnd.value < timeStart.value) timeEnd.value = timeStart.value;
});
timeEnd.addEventListener('change', (e) => {
    timeStart.max = timeEnd.value
    if (timeStart.value > timeEnd.value) timeStart.value = timeEnd.value;
});

loadDoc();
</script>
 
</body>
</html>