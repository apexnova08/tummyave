<?php
session_start();
$userid = "id";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

$mysqli = require __DIR__ . "/../database.php";

$user = $mysqli->query("SELECT * FROM users WHERE id = '$userid'")->fetch_assoc();
if (!$user) die ("Error: user not found");

$usertype = $user["type"];
?>

<section class="epic-sanssb epic-header" style="text-align: center;">
    <div class="epic-drop">
        <button class="epic-btn epic-dropbtn">Admin &nbsp; Panel</button>
        <div class="epic-dropcontent">
            <?php
            if ($usertype === "0") echo "<a href='../user0/'>Super Admin</a>";
            if ($usertype === "0" || $usertype === "1") echo "<a href='../userowner/'>Owner Panel</a>";
            ?>
            <a href="../usercashier/">Cashier Panel</a>
        </div>
    </div>
</section>
<section class="epic-bebas epic-header" style="text-align: center;">
    <ul>
        <a href="../useradmin/"><li>Foods</li></a>
        <a href="categories.php"><li>Categories</li></a>
        <a href="reservations.php"><li>Venue &nbsp; Reservations</li></a>
        <a href="tummy.php"><li>Tummy &nbsp; Avenue</li></a>
        <a href="accounts.php"><li>Accounts</li></a>
        <a href="../account/account.php"><li><?= explode(" ", $user["name"])[0] ?></li></a>
    </ul>
</section>