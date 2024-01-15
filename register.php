<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesează datele trimise prin formular
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Poți adăuga aici logica pentru validarea și stocarea datelor

    // Redirecționează către o pagină de succes sau afișează un mesaj de succes
    header("Location: success.html");
    exit();
}
?>
