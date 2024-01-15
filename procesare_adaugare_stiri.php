<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    require_once("functions.php"); 

   // if (addNews($title, $content)) {
      //  echo "Știre adăugată cu succes!";
   // } else {
     //   echo "Eroare la adăugarea știrii.";
   // }
}
?>
