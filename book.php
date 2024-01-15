<?php
$mysqli=new mysqli('localhost','root','','tennis');
    if(isset($_GET['date'])){
        $date=$_GET['date'];
        $stmt=$mysqli->prepare("select * from bookings where date=?");
        $stmt->bind_param('s',$date);
        $bookings=array();
        if($stmt->execute()){
            $result=$stmt->get_result();
            if($result->num_rows>0){
                while($row = $result->fetch_assoc()){
                    $bookings[]=$row['timeslot'];
                }
                $stmt->close();
            }
        }
    }


    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $timeslot=$_POST['timeslot'];
        $stmt=$mysqli->prepare("select * from bookings where date=? AND timeslot = ?");
        $stmt->bind_param('ss',$date, $timeslot);
        if($stmt->execute()){
            $result=$stmt->get_result();
            if($result->num_rows>0){
                $msg="<div class='alert alert-danger'>Already Booked</div>";
            }else{
                $stmt=$mysqli->prepare("INSERT INTO bookings (name,timeslot,email,date) VALUES (?,?,?,?)");
                $stmt->bind_param('ssss',$name,$timeslot,$email,$date);
                $stmt->execute();
                $msg="<div class='alert alert-success'>Booking Successfull</div>";
                $bookings[]=$timeslot;
                $stmt->close();
                $mysqli->close();
            }
        }
        
    }      
    

$duration=60;
$cleanup=0;
$start="08:00";
$end="22:00";


function timeslots($duration, $cleanup, $start, $end){
    $start=new DateTime($start);
    $end=new DateTime($end);
    $interval=new DateInterval("PT".$duration."M");
    $cleanupInterval=new DateInterval("PT".$cleanup."M");
    $slots=array();

    for($intStart=$start; $intStart<$end; $intStart->add($interval)->add($cleanupInterval)){
        $endPeriod=clone $intStart;
        $endPeriod->add($interval);
        if($endPeriod>$end){
            break;
        }

        $slots[]=$intStart->format("H:iA")."-".$endPeriod->format("H:iA");
    }
    return $slots;
}



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" >

    <title>Booking System</title>
    
   
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 
        </head>

    

    <body>

    <section class="sub-header">
        <nav>
            <a href="index.html"><img src="images/logo1.png"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                <li><a href="about.html">DESPRE NOI</a></li>
                    <li><a href="booking.php">INCHIRIAZA UN TEREN</a></li>
                    <li><a href="pagina3.html">DE CE TENIS CLUB SUN</a></li>
                    <li><a href="login1.php">LOGIN</a></li>
                    <li><a href="stiri.php">STIRI</a></li>
                    <li><a href="profile.php">PROFIL</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        
    </section>






    <div class="container">
        <h1 class="text-center">Book for Date: <?php echo date('d/m/Y', strtotime($date)); ?></h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-12">
                    <?php echo (isset($msg)) ? $msg : ""; ?>
                </div>
                <?php
                $timeslots = timeslots($duration, $cleanup, $start, $end);
                $halfway = count($timeslots) / 2; // Indicele la care se divide în două

                foreach ($timeslots as $index => $ts) {
                    ?>
                    <div class="form-group mb-3">
                        <?php if (in_array($ts, $bookings)) { ?>
                            <button class="btn btn-danger w-100"><?php echo $ts; ?></button>
                        <?php } else { ?>
                            <button class="btn btn-success book w-100" data-timeslot="<?php echo $ts; ?>"><?php echo $ts; ?></button>
                        <?php } ?>
                    </div>
                    <?php
                    // Adăugarea unui spațiu după primele 6 ore pentru a împărți pe două rânduri
                    if ($index === $halfway - 1) {
                        echo '</div><div class="col-md-6">';
                    }
                } ?>
            </div>
        </div>
    </div>



                <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Booking: <span id="slot"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Timeslot</label>
                                    <input required type="text" readonly name="timeslot" id="timeslot" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input required type="text" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input required type="email" name="email" class="form-control">
                                </div>
                                <br>
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   
  
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    
     <script>
        $(".book").click(function() {
            
            var timeslot = $(this).attr('data-timeslot')
            $("#slot").html(timeslot);
            $("#timeslot").val(timeslot);
            $("#myModal").modal("show");
        })
    </script>           
                
</body>

</html>                  
  