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

    <title>Admin</title>
    
   
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
 


    <script>
        function confirmDelete() {
            return confirm("Sigur doriți să ștergeți această rezervare?");
        }
    </script>
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
       <h1>Stiri </h1>
    </section>




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

        .logout-btn {
            float: right;
            margin-top: -40px;
            margin-right: 20px;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }



        .news-container {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .news-date {
            color: #888;
            font-size: 12px;
            text-align: right;
        }
    </style>
</head>

<body>
<div id="container">
    <br>
    
    
    
    

<?php
    //require_once("functions.php"); 
    $news = getAllNews();

    if ($news !== false) {
        foreach ($news as $article) {
            echo '<div class="news-container">';
            echo '<strong>Titlu:</strong> ' . $article->title . '<br>';
            echo '<strong>Știre:</strong> ' . $article->content . '<br>';
            echo '<div class="news-date">' . date('Y-m-d H:i:s', strtotime($article->date)) . '</div>';
            echo '</div>';
        }
    } else {
        echo "Error retrieving news from the database.";
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
    


   

</div>

</body>
</html>
