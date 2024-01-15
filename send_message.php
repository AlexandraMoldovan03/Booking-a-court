<?php
session_start();

if (!isset($_SESSION['admin_authenticated'])) {
    header("Location: login1.php");
    die();
}
function getMessages($userId) {
    try {
        $string = "mysql:host=localhost;dbname=tennis";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        // Selectează mesajele pentru utilizatorul dat
        $query = "SELECT * FROM messages WHERE receiver_id = :userId";
        $stm = $con->prepare($query);
        $stm->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stm->execute();
        $messages = $stm->fetchAll(PDO::FETCH_OBJ);

        return $messages;
    } catch (PDOException $e) {
        // Poți trata eroarea în funcție de necesitățile tale
        // Afișează un mesaj de eroare, înregistrează în jurnal, etc.
        return false;
    }
}

function saveMessageToDatabase($senderId, $receiverId, $message) {
    try {
        $string = "mysql:host=localhost;dbname=tennis";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        // Inserează mesajul în baza de date
        $query = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (:senderId, :receiverId, :message)";
        $stm = $con->prepare($query);
        $stm->bindParam(':senderId', $senderId, PDO::PARAM_INT);
        $stm->bindParam(':receiverId', $receiverId, PDO::PARAM_INT);
        $stm->bindParam(':message', $message, PDO::PARAM_STR);

        $stm->execute();

        return true;
    } catch (PDOException $e) {
        // Poți trata eroarea în funcție de necesitățile tale
        // Afișează un mesaj de eroare, înregistrează în jurnal, etc.
        return false;
    }
}






// Verifică dacă datele au fost trimise prin POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $receiverId = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Verifică dacă mesajul nu este gol
    if (!empty($message)) {
        // Salvează mesajul în baza de date
        saveMessageToDatabase($_SESSION['admin_id'], $receiverId, $message); // implementează această funcție
    }
}

// Redirecționează înapoi la pagina cu conversația
header("Location: admin_dashboard.php?user=" . $receiverId);
die();




?>