<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" >

    <title>Admin</title>
    
   
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 


    <script>
        function confirmDelete() {
            return confirm("Sigur doriți să ștergeți această rezervare?");
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        #container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            color: #dc3545;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
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
                    
                <li><a href="admin.php">STERGERE REZERVARI</a></li>
                <li><a href="adaugare_stiri.php">ADAUGARE STIRI</a></li>
                    <li><a href="login1.php">LOGIN</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
             
        </nav>
       
    </section>
    <div id="container">
<h1> Stergere rezervari </h1>

<div id="container">
    <br>
<?php
session_start();

if (!isset($_SESSION['admin_authenticated'])) {
    header("Location: login1.php");
    die();
}


function getAllReservations() {
        try {
            $string = "mysql:host=localhost;dbname=tennis";
            $con = new PDO($string, 'root', '');
    
            if (!$con) {
                return false;
            }
    
            // Selectează toate rezervările din baza de date
            $query = "SELECT * FROM bookings ORDER BY date DESC, timeslot DESC";
                $stm = $con->query($query);
                $reservations = $stm->fetchAll(PDO::FETCH_OBJ);

    
            return $reservations;
        } catch (PDOException $e) {
            return false;
        }
    }


    $reservations = getAllReservations();
   ?>
 <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($reservations !== false) {
                    foreach ($reservations as $reservation) {
                        echo '<tr>';
                        echo '<td>' . $reservation->name . '</td>';
                        echo '<td>' . $reservation->date . '</td>';
                        echo '<td>' . $reservation->timeslot . '</td>';
                        echo '<td><a href="?delete_reservation&date=' . urlencode($reservation->date) . '&time=' . urlencode($reservation->timeslot) . '"&confirm=1" onclick="return confirmDelete()">Delete</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">Error retrieving reservations from the database.</td></tr>';
                }
               
                if (isset($_GET['delete_reservation']) && isset($_GET['date']) && isset($_GET['time'])) {
                    $date = urldecode($_GET['date']);
                    $time = urldecode($_GET['time']);
                
                    try {
                        $string = "mysql:host=localhost;dbname=tennis";
                        $con = new PDO($string, 'root', '');
                
                        if (!$con) {
                            die("Connection failed");
                        }
                
                        // Delete the reservation with the specified ID
                        $query = "DELETE FROM bookings WHERE date = :date AND timeslot = :time";
                        $stm = $con->prepare($query);
                        $stm->bindParam(':date', $date, PDO::PARAM_STR);
                        $stm->bindParam(':time', $time, PDO::PARAM_STR);
                        $result = $stm->execute();
                
                        if ($result) {
                            // Redirect the user back to the reservations page
                            //header("Location: admin.php");
                            exit();
                        } else {
                            echo "Error deleting reservation.";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
?>
 
<br><br><br>
</body>
</html>