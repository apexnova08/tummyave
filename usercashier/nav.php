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

<?php
if ($usertype != "3") {
?>
<section class="epic-sanssb epic-header" style="text-align: center;">
    <div class="epic-drop">
        <button class="epic-btn epic-dropbtn">Cashier &nbsp; Panel</button>
        <div class="epic-dropcontent">
            <?php
            //if ($usertype === "0") echo "<a href='../user0/'>Super Admin</a>";
            if ($usertype === "0" || $usertype === "1") echo "<a href='../userowner/'>Owner Panel</a>";
            ?>
            <a href="../useradmin/">Admin Panel</a>
        </div>
    </div>
</section>
<?php } ?>

<section class="epic-bebas epic-header" style="text-align: center;">
    <ul>
        <a href="../usercashier/"><li>Orders</li></a>
        <a href="../account/account.php"><li><?= explode(" ", $user["name"])[0] ?></li></a>
    </ul>
</section>