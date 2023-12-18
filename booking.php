<?php
function build_calendar($month,$year){
$mysqli=new mysqli('localhost','root','','tennis');
/*$stmt=$mysqli->prepare("select * from bookings where MONTH(date)=? AND YEAR(date)=?");
$stmt->bind_param('ss',$month,$year);
$bookings=array();
if($stmt->execute()){
    $result=$stmt->get_result();
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $bookings[]=$row['date'];
        }
        $stmt->close();
    }
}

    
}*/


$daysOfWeek = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
$numberDays = date('t', $firstDayOfMonth);
$dateComponents = getdate($firstDayOfMonth);
$monthName = $dateComponents['month'];
$dayOfWeek = $dateComponents['wday'];

if ($dayOfWeek == 0) {
    $dayOfWeek = 6;
} else {
    $dayOfWeek = $dayOfWeek - 1;
}

$dateToday = date('Y-m-d');

$calendar = "<table class='table table-bordered'>";
$calendar .= "<center><h2>$monthName $year</h2>";

$calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a>";
$calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a>";
$calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";

$calendar .= "<tr>";

foreach ($daysOfWeek as $day) {
    $calendar .= "<th class='header'>$day</th>";
}

$currentDay = 1;
$calendar .= "</tr><tr>";

if ($dayOfWeek > 0) {
    for ($k = 0; $k < $dayOfWeek; $k++) {
        $calendar .= "<td class='empty'></td>";
    }
}

$month = str_pad($month, 2, "0", STR_PAD_LEFT);
while ($currentDay <= $numberDays) {
    if ($dayOfWeek == 7) {
        $dayOfWeek = 0;
        $calendar .= "</tr><tr>";
    }

    $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
    $date = "$year-$month-$currentDayRel";

    $dayname = strtolower(date('l', strtotime($date)));
    $eventNum = 0;
    $today = $date == date('Y-m-d') ? "today" : "";
    if ($dayname == '' || $dayname == '') {
        $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Holiday</<button>";
    } elseif ($date < date('Y-m-d')) {
        $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>N/A</<button>";
    } else {
        $totalbookings = checkSlots($mysqli, $date);
        if ($totalbookings == 14) {
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='#' class='btn btn-danger btn-xs'>All Booked</a>";
        } else {
            $availableslots = 14 - $totalbookings;
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='book.php?date=" . $date . "' class='btn btn-success btn-xs'>Book</a><small><i>$availableslots  slots available</i></small>";
        }
    }

    $calendar .= "</td>";
    $currentDay++;
    $dayOfWeek++;
}

if ($dayOfWeek != 7) {
    $remainingDays = 7 - $dayOfWeek;
    for ($i = 0; $i < $remainingDays; $i++) {
        $calendar .= "<td class='empty'></td>";
    }
}

$calendar .= "</tr>";
$calendar .= "</table>";

echo $calendar;
}

function checkSlots($mysqli, $date){
    $stmt=$mysqli->prepare("select * from bookings where date=?");
$stmt->bind_param('s',$date);
$totalbookings=0;
if($stmt->execute()){
    $result=$stmt->get_result();
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            $totalbookings++;
         }   
        $stmt->close();
        }
    }

    return $totalbookings;
}    









?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <?php include('navbar.php')?>
    <style>
        @media only screen and (max-width: 760px),
        (min-device-width: 802px) and (max-device-width: 1020px) {
            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            .empty {
                display: none;
            }

            .navbar {
                background-color: #2ec1ac;
                padding: 10px;
                color: white;
                position: fixed;
                width: 100%;
                z-index: 1000;
            }

            .navbar-brand {
                color: white;
            }

            th {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
            }

            td:nth-of-type(1):before {
                content: "Monday";
            }

            td:nth-of-type(2):before {
                content: "Tuesday";
            }

            td:nth-of-type(3):before {
                content: "Wednesday";
            }

            td:nth-of-type(4):before {
                content: "Thursday";
            }

            td:nth-of-type(5):before {
                content: "Friday";
            }

            td:nth-of-type(6):before {
                content: "Saturday";
            }

            td:nth-of-type(7):before {
                content: "Sunday";
            }
        }

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
            body {
                padding: 0;
                margin: 0;
            }
        }

        @media only screen and (min-device-width: 820px) and (max-device-width: 1020px) {
            body {
                width: 495px;
            }
        }

        @media (min-width: 641px) {
            table {
                table-layout: fixed;
            }

            td {
                width: 33%;
            }
        }

        .row {
            margin-top: 20px;
        }

        .today {
            background: yellow;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php    
                    $dateComponents = getdate();
                    if (isset($_GET['month']) && ($_GET['year'])) {
                        $month = $_GET['month'];
                        $year = $_GET['year'];
                    } else {
                        $month = $dateComponents['mon'];
                        $year = $dateComponents['year'];
                    }
                    echo build_calendar($month, $year);
                ?>
            </div>
        </div>
    </div>
</body>
</html>
