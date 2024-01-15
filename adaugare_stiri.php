<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Adaugă Știri</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        #container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
    </style>


    

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
       <h1> functionalitati Admin </h1>
    </section>





</head>

<body>
<div id="container">
    <br>
<?php
session_start();

if (!isset($_SESSION['admin_authenticated'])) {
    header("Location: login1.php");
    die();
}



          


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    //require_once("functions.php"); 

    if (addNews($title, $content)) {
        $success_message = "Știre adăugată cu succes!";
    } else {
        $error_message = "Eroare la adăugarea știrii.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Adaugă aici head-ul paginii tale -->
    <title>Adaugă Știri</title>
</head>
<body>

<div id="container">

<h2>Adaugă Știri</h2>

<?php
// Afișează mesajul de succes sau eroare, dacă există
if (isset($success_message)) {
    echo '<p style="color: green;">' . $success_message . '</p>';
} elseif (isset($error_message)) {
    echo '<p style="color: red;">' . $error_message . '</p>';


}













function database_run($query,$vars = array())
{
	$string = "mysql:host=localhost;dbname=tennis";
	$con = new PDO($string,'root','');

	if(!$con){
		return false;
	}

	$stm = $con->prepare($query);
	$check = $stm->execute($vars);

	if($check){
		
		$data = $stm->fetchAll(PDO::FETCH_OBJ);
		
		if(count($data) > 0){
			return $data;
		}
	}

	return false;
}

function check_login($redirect = true){

	if(isset($_SESSION['USER']) && isset($_SESSION['LOGGED_IN'])){

		return true;
	}

	if($redirect){
		header("Location: login1.php");
		die;
	}else{
		return false;
	}
	
}

function check_verified(){

	$id = $_SESSION['USER']->id;
	$query = "select * from user where id = '$id' limit 1";
	$row = database_run($query);

	if(is_array($row)){
		$row = $row[0];

		if($row->email == $row->email_verified){

			return true;
		}
	}
 
	return false;
 	
}






function addNews($title, $content) {
    try {
        $string = "mysql:host=localhost;dbname=tennis";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        $query = "INSERT INTO news (title, content) VALUES (:title, :content)";
        $stm = $con->prepare($query);
        $stm->bindParam(':title', $title, PDO::PARAM_STR);
        $stm->bindParam(':content', $content, PDO::PARAM_STR);
        $result = $stm->execute();

        return $result;
    } catch (PDOException $e) {
        return false;
    }
}




function getAllNews() {
    try {
        $string = "mysql:host=localhost;dbname=tennis";
        $con = new PDO($string, 'root', '');

        if (!$con) {
            return false;
        }

        $query = "SELECT * FROM news ORDER BY date DESC";
        $stm = $con->query($query);
        $news = $stm->fetchAll(PDO::FETCH_OBJ);

        return $news;
    } catch (PDOException $e) {
        return false;
    }
}
?>










<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="title">Titlu:</label>
    <input type="text" id="title" name="title" required>

    <label for="content">Știre:</label>
    <textarea id="content" name="content" rows="4" required></textarea>

    <input type="submit" value="Adaugă Știre">
</form>

<a href="stiri.php">Vezi Toate Știrile</a>
</div>
<br><br><br>
</body>
</html>