<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        h1 {
            background-color: #333;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        #messages {
            padding: 20px;
            height: 300px;
            overflow-y: scroll;
        }

        #message-form {
            padding: 20px;
            background-color: #eee;
        }

        textarea {
            width: calc(100% - 20px);
            height: 60px;
            margin-bottom: 10px;
            padding: 10px;
            resize: none;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .message {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .user-message {
            text-align: right;
            background-color: #d4eafd;
        }
    </style>
</head>
<body>

<div id="container">





<?php
// ... alte secțiuni de cod
session_start();

if (!isset($_SESSION['admin_authenticated'])) {
    header("Location: login1.php");
    die();
}

function getUsersFromDatabase() {
    try {
        $string = "mysql:host=localhost;dbname=tennis";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        // Selectează utilizatorii din baza de date
        $query = "SELECT * FROM users";
        $stm = $con->query($query);
        $users = $stm->fetchAll(PDO::FETCH_OBJ);

        return $users;
    } catch (PDOException $e) {
        // Poți trata eroarea în funcție de necesitățile tale
        // Afișează un mesaj de eroare, înregistrează în jurnal, etc.
        return false;
    }
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

$users = getUsersFromDatabase();

// Utilizează rezultatul
if ($users !== false) {
    echo '<ul>';
    foreach ($users as $user) {
        echo '<li><a href="?user=' . $user->id . '">' . $user->username . '</a></li>';
    }
    echo '</ul>';
} else {
    echo "Eroare la obținerea utilizatorilor din baza de date.";
}

// Dacă un utilizator a fost selectat, afișează conversația și formularul de trimitere a mesajului
if (isset($_GET['user'])) {
    $userId = $_GET['user'];
    $messages = getMessages($userId);

    if ($messages !== false) {
        echo '<div>';
        foreach ($messages as $message) {
            echo "De la: " . $message->sender_id . "<br>";
            echo "Mesaj: " . $message->message . "<br>";
            echo "------------------------<br>";
        }
        echo '</div>';
    } else {
        echo "Eroare la obținerea mesajelor din baza de date.";
    }

    // Afișează conversația
    echo '<div>';
    foreach ($messages as $message) {
        echo '<p>' . $message->message . '</p>';
    }
    echo '</div>';
}
    ?>
    <form method="post" action="send_message.php">
    <input type="hidden" name="receiver_id" value="<?php echo $userId; ?>">
    <textarea name="message" placeholder="Type your message"></textarea>
    <input type="submit" value="Send">
</form>




</body>
</html>