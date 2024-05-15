<?php
session_start();
$usertype = $_SESSION["user_type"];
session_abort();
?>
<ul style="list-style: none; overflow: hidden;">
    <li style="float: left;"><a href="../useradmin/"><button>Home</button></a></li>
    <li style="float: left;"><a href="foodslist.php"><button>Foods</button></a></li>
    <li style="float: left;"><a href="categories.php"><button>Food Categories</button></a></li>
    <li style="float: left;"><a href="reservations.php"><button>Reservations</button></a></li>
    <li style="float: left;"><a href="feedbacks.php"><button>Feedbacks</button></a></li>
    <li style="float: left;"><a href="news.php"><button>News</button></a></li>
    <li style="float: left;"><a href="accounts.php"><button>Accounts</button></a></li>
    <?php
    if ($usertype === "0")
        echo "<li style='float: left;'><a href='../user0/'><button>Super Admin Panel</button></a></li>";
    if ($usertype === "0" || $usertype === "1")
        echo "<li style='float: left;'><a href='../userowner/'><button>Owner Panel</button></a></li>";
    ?>
    <li style="float: left;"><a href="../usercashier/"><button>Cashier Panel</button></a></li>
    <li style="float: left;"><a href="../account/account.php"><button>Your Account</button></a></li>
</ul>