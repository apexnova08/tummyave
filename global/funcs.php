<?php
// ## VARS
$usertypes = array("0"=>"Superadmin", "1"=>"Owner", "2"=>"Admin", "3"=>"Cashier", "4"=>"Customer");
$boolstring = array("0"=>"False", "1"=>"True");
$paidString = array("0"=>"Unpaid", "1"=>"Paid");
$enabledString = array("0"=>"Enabled", "1"=>"Disabled");
$publicString = array("0"=>"Public", "1"=>"Private");
$boolColor = array("0"=>"Green", "1"=>"Red");

// # RESERVATIONS
function getRHS(string $status) // Reservation History Status
{
    if ($status === "Requested") return "Missed";
    else return $status;
}
function getRHSColor(string $status)
{
    if ($status === "Reserved") return "Green";
    elseif ($status === "Denied" || $status === "Cancelled") return "Red";
    else return "Grey";
}

// # ORDERS
function getOPI(string $status) // Order Payment Instructions
{
    if ($status === "Waiting for payment") return "Waiting for payment (Go to 'details' to pay)";
    else return $status;
}





// ## FUNCS DATE
function getCurrentDateTime()
{
    date_default_timezone_set("Asia/Manila");
    return date("Y/m/d H:i:s");
}
function getCurrentDate()
{
    date_default_timezone_set("Asia/Manila");
    return date("Y/m/d");
}
function getYear(string $datestring)
{
    $dateSeperator = "/";
    if (str_contains($datestring, "-")) $dateSeperator = "-";
    if (str_contains($datestring, " ")) return explode($dateSeperator, explode(" ", $datestring)[0])[0];
    else return explode($dateSeperator, $datestring)[0];
}
function getMonth(string $datestring)
{
    $dateSeperator = "/";
    if (str_contains($datestring, "-")) $dateSeperator = "-";
    if (str_contains($datestring, " ")) return explode($dateSeperator, explode(" ", $datestring)[0])[1];
    else return explode($dateSeperator, $datestring)[1];
}
function getDay(string $datestring)
{
    $dateSeperator = "/";
    if (str_contains($datestring, "-")) $dateSeperator = "-";
    if (str_contains($datestring, " ")) return explode($dateSeperator, explode(" ", $datestring)[0])[2];
    else return explode($dateSeperator, $datestring)[2];
}
function getTime(string $datestring)
{
    $datearr = explode(" ", $datestring);
    $timearr = explode(":", $datearr[1]);
    return array("his"=>$datearr[1], "hi"=>$timearr[0] . ":" . $timearr[1]);
}
function getMonthName(string $month)
{
    if (str_contains($month, "/") || str_contains($month, "-")) $month = getMonth($month);
    if ((int)$month === 1) return array("MMMM"=>"January", "MMM"=>"Jan");
    elseif ((int)$month === 2) return array("MMMM"=>"February", "MMM"=>"Feb");
    elseif ((int)$month === 3) return array("MMMM"=>"March", "MMM"=>"Mar");
    elseif ((int)$month === 4) return array("MMMM"=>"April", "MMM"=>"Apr");
    elseif ((int)$month === 5) return array("MMMM"=>"May", "MMM"=>"May");
    elseif ((int)$month === 6) return array("MMMM"=>"June", "MMM"=>"Jun");
    elseif ((int)$month === 7) return array("MMMM"=>"July", "MMM"=>"Jul");
    elseif ((int)$month === 8) return array("MMMM"=>"August", "MMM"=>"Aug");
    elseif ((int)$month === 9) return array("MMMM"=>"September", "MMM"=>"Sep");
    elseif ((int)$month === 10) return array("MMMM"=>"October", "MMM"=>"Oct");
    elseif ((int)$month === 11) return array("MMMM"=>"November", "MMM"=>"Nov");
    elseif ((int)$month === 12) return array("MMMM"=>"December", "MMM"=>"Dec");
    else return array("MMMM"=>"Error: Undefined month - " . $month, "MMM"=>"Error: Undefined month - " . $month);
}
function getDaysOfMonth(string $year, string $month)
{
    return cal_days_in_month(CAL_GREGORIAN, $month, $year);
}
function getDayOfWeek(?string $year = null, ?string $month = null, ?string $day = null, ?string $datestring = null)
{
    if (isset($datestring)) return (int)date('w', strtotime($datestring));
    else return (int)date('w', strtotime($year . "/" . $month . "/" . $day));
}
function getWeekDayName(string $day)
{
    if (str_contains($day, "/") || str_contains($day, "-")) $day = getDayOfWeek(datestring: $day);
    if ((int)$day === 0) return array("dddd"=>"Sunday", "ddd"=>"Sun");
    elseif ((int)$day === 1) return array("dddd"=>"Monday", "ddd"=>"Mon");
    elseif ((int)$day === 2) return array("dddd"=>"Tuesday", "ddd"=>"Tue");
    elseif ((int)$day === 3) return array("dddd"=>"Wednesday", "ddd"=>"Wed");
    elseif ((int)$day === 4) return array("dddd"=>"Thursday", "ddd"=>"Thu");
    elseif ((int)$day === 5) return array("dddd"=>"Friday", "ddd"=>"Fri");
    elseif ((int)$day === 6) return array("dddd"=>"Saturday", "ddd"=>"Sat");
    else return array("dddd"=>"Error: Undefined weekday - " . $day, "ddd"=>"Error: Undefined weekday - " . $day);
}
function getLongDateFormat(string $rawdatestring)
{
    $datestring = getMonthName($rawdatestring)["MMMM"] . " " . getDay($rawdatestring) . ", " . getYear($rawdatestring);
    if (str_contains($rawdatestring, " ")) $datestring = $datestring . " &nbsp; " . getTime($rawdatestring)["hi"];
    return $datestring;
}
function get12HourFormat(string $timestring)
{
    $ampm = "AM";
    $arr = explode(":", $timestring);
    $hourint = (int)$arr[0];
    if ($hourint >= 12) $ampm = "PM";
    if ($hourint > 12) $hourint = $hourint - 12;
    if ($hourint == 0) $hourint = 12;
    $hourstring = (string)$hourint;
    return $hourstring . ":" . $arr[1] . " " . $ampm;
}
function subtractDaysFromDate(string $datestring, int $days)
{
    $date = date_create($datestring);
    date_sub($date,date_interval_create_from_date_string( $days . " days"));
    return date_format($date,"Y-m-d");
}





// ## FUNCS
function getPriceFormat(int $price)
{
    return number_format($price, 2);
}
function chars25Max(string $str)
{
    if (strlen($str) > 25) return substr($str, 0, 25) . "...";
    else return $str;
}

function generateID(string $datestring)
{
    $arr = explode(" ", $datestring);
    $datearr = explode("/", $arr[0]);
    $timearr = explode(":", $arr[1]);
    
    return $datearr[0] . $datearr[1] . $datearr[2] . $timearr[0] . $timearr[1] . $timearr[2];
}

function uploadImage(string $filename)
{
    // Reject uploaded file larger than 1MB
    if ($_FILES["image"]["size"] > 10485760) {
        exit('File too large (max 1MB)');
    }

    // Use fileinfo to get the mime type
    $mime_types = ["image/gif", "image/png", "image/jpeg"];
    if ( ! in_array($_FILES["image"]["type"], $mime_types)) {
        exit("Invalid file type");
        return;
    }

    // Upload
    $pathinfo = pathinfo($_FILES["image"]["name"]);
    $filename = $filename . "." . $pathinfo["extension"];
    $destination = __DIR__ . "/../img-uploads/" . $filename;

    if ( ! move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
        exit("Can't move uploaded file");
        return;
    }

    return $filename;
}
function generatePaxList(int $max = 500)
{
    $list = array("Less than 10");
    $estpax = 10;

    while ($estpax < $max)
    {
        array_push($list, (string)$estpax);
        
        if ($estpax < 100) $estpax = $estpax * 2;
        elseif ($estpax >= 1000) $estpax = $estpax + 1000;
        elseif ($estpax >= 100) $estpax = $estpax + 100;

        if ($estpax === 40) $estpax = 50;
    }

    array_push($list, (string)$max);
    array_push($list, "More than " . $max);

    return $list;
}
function generateRand(int $length = 6, bool $text = false) {
    $characters = '0123456789';
    if ($text) $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}





// ## FUNCS EMAIL
use PHPMailer\PHPMailer\PHPMailer;
function hideEmail(string $email)
{
    $domain = explode("@", $email)[1];
    return substr($email, 0, 3) . "*****@" . $domain;
}
function sendOTP(string $email, string $name)
{
    $config = parse_ini_file(__DIR__ . "/../config.ini", true);
    require "../vendor/autoload.php";
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = $config["email"]["email"];
    $mail->Password = $config["email"]["pass"];

    $mail->setFrom($config["email"]["email"], $config["email"]["name"]);
    $mail->addAddress($email, $name);

    $otp = generateRand();
    $message = "Hello, $name!\n\nYour OTP is:\n$otp\n\n\nPlease be minded to not share this code to anyone.";

    $mail->Subject = "Your One-Time-Pin";
    $mail->Body = $message;

    $mail->send();
    return $otp;
}
function changePass(string $email, string $name)
{
    $config = parse_ini_file(__DIR__ . "/../config.ini", true);
    require "../vendor/autoload.php";
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = $config["email"]["email"];
    $mail->Password = $config["email"]["pass"];

    $mail->setFrom($config["email"]["email"], $config["email"]["name"]);
    $mail->addAddress($email, $name);

    $newpass = generateRand(8, true);
    $message = "Hello, $name!\n\nYour temporary password is:\n$newpass\n\n\nPlease update your password to a more secure one as soon as possible.";

    $mail->Subject = "Your New Temporary Password";
    $mail->Body = $message;

    $mail->send();
    return $newpass;
}
function NotifyOrderReady(string $email, string $name, string $orderid, string $totalitems)
{
    $config = parse_ini_file(__DIR__ . "/../config.ini", true);
    require "../../vendor/autoload.php";
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = $config["email"]["email"];
    $mail->Password = $config["email"]["pass"];

    $mail->setFrom($config["email"]["email"], $config["email"]["name"]);
    $mail->addAddress($email, $name);

    $newpass = generateRand(8, true);
    $message = "Hello, $name!\n\nYour order Order#$orderid with $totalitems items is now ready to pickup!";

    $mail->Subject = "Your Order is Ready to Pickup!";
    $mail->Body = $message;

    $mail->send();
    return $newpass;
}
?>