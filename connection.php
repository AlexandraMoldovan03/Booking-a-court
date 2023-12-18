<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "tennis";
$port= 3306;
$conn = new mysqli($servername, $username, $password, $db_name, 3306);
if($conn->connect_error){
    die("Connection failed".$conn->connect_error);
}
echo "";

?>