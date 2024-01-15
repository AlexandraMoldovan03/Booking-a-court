<?php
session_start();
function build_calendar($month,$year){
$mysqli=new mysqli('localhost','root','','tennis');
$isLogged = isset($_SESSION['email_verified']);


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

$calendar .= "<a class='btn btn-xs btn-primary' style='margin-right: 6px;' href='?month=" . date('m', mktime(0, 0, 0, $month - 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month - 1, 1, $year)) . "'>Previous Month</a>";
$calendar .= "<a class='btn btn-xs btn-primary' style='margin-right: 6px;' href='?month=" . date('m') . "&year=" . date('Y') . "'>Current Month</a>";
$calendar .= "<a class='btn btn-xs btn-primary' style='margin-right: 6px;' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>Next Month</a></center><br>";

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
        $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>Holiday</button>";
    } elseif ($date < date('Y-m-d')) {
        $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'>N/A</button>";
    } else {
        $totalbookings = checkSlots($mysqli, $date);
        if ($totalbookings == 14) {
            $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='#' class='btn btn-danger btn-xs'>All Booked</a>";
        } else {
            // Verifică dacă utilizatorul este autentificat înainte de a arăta butonul "Rezervă"
            if ($isLogged) {
                $availableslots = 14 - $totalbookings;
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href='book.php?date=" . $date . "' class='btn btn-success btn-xs'>Book</a><small><i>$availableslots  slots available</i></small>";
            } else {
                $calendar .= "<td class='$today'><h4>$currentDay</h4> <span class='text-danger'>Login to book</span>";
            }
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
<meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Tennis Club Sun </title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" >
     

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

            .calendar-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-calendar {
            display: inline-block;
            padding: 8px 15px;
            margin: 0 5px;
            border: 1px solid #007bff;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-calendar:hover {
            background-color: #0056b3;
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
<section class="sub-header">
        <nav>
            <a href="index.html"><img src="images/logo1.png"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                <li><a href="index.html">HOME</a></li>
                    <li><a href="about.html">DESPRE NOI</a></li>
                    <li><a href="booking.php">INCHIRIAZA UN TEREN</a></li>
                    <li><a href="pagina3.html">DE CE TENIS CLUB SUN</a></li>
                    <li><a href="login1.php">LOGIN</a></li>
                    <li><a href="stiri.php">STIRI</a></li>
                    <li><a href="profile.php">PROFIL</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        <!--<h1>Închiriază un teren</h1> -->

    </section>


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

                
<br><br><br>
            </div>
        </div>
    </div>





<!---------JavaScript for Toggle Menu-------->
<script>

var navLinks = document.getElementById("navLinks");
function shouMenu() {
    navLinks.style.right = "0";
}
function hideMenu() {
    navLinks.style.right = "-200px";
}
</script>





</body>
</html>
