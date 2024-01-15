<!DOCTYPE html>
<html>
<head>
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <title>Tennis Club Sun </title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">

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
                    <li><a href="Cursuri.html">INITIERE SI ANTRENAMENTE</a></li>
                    <li><a href="pagina3.html">DE CE TENIS CLUB SUN</a></li>
                    <li><a href="obiective.html">OBIECTIVE</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        <h1>Contact</h1>

    </section>

<?php
    session_start();

if (!isset($_SESSION['USER']) || !isset($_SESSION['LOGGED_IN'])) {
    header("Location: login1.php");
    die;
}


unction getMessages($userId) {
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
        $messages = $stm->fetchAll(PDO::FETCH_ASSOC);

        return $messages;
    } catch (PDOException $e) {
        // Poți trata eroarea în funcție de necesitățile tale
        // Afișează un mesaj de eroare, înregistrează în jurnal, etc.
        return false;
    }
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
// Obține lista utilizatorilor din baza de date
$users = getUsersFromDatabase();

// Utilizează rezultatul
if ($users !== false) {
    echo '<ul>';
    foreach ($users as $user) {
        echo '<li><a href="?user=' . $user['id'] . '">' . $user['username'] . '</a></li>';
    }
    echo '</ul>';
}

// Dacă un utilizator a fost selectat, afișează conversația și formularul de trimitere a mesajului
if (isset($_GET['user'])) {
    $userId = $_GET['user'];
    $messages = getMessages($userId); // implementează această funcție pentru a obține mesajele

    if ($messages !== false) {
        echo '<div>';
        foreach ($messages as $message) {
            echo '<p>' . $message['message'] . '</p>';
        }
        echo '</div>';
    } else {
        echo "Eroare la obținerea mesajelor din baza de date.";
    }

    // Formularul de trimitere a mesajului


    echo '<form method="post" action="send_message.php">';
    echo '<input type="hidden" name="receiver_id" value="' . $userId . '">';
    echo '<textarea name="message" placeholder="Type your message"></textarea>';
    echo '<input type="submit" value="Send">';
    echo '</form>';
}
?>



      


     


    </body>
</html>

