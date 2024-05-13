<?php
// ## VARS
$usertypes = array("0"=>"Super Admin", "1"=>"Owner", "2"=>"Admin", "3"=>"Cashier", "4"=>"Customer");





// ## FUNCS
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
    $arr = explode(" ", $datestring);
    return $arr[1];
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
?>