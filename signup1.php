<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = signup($_POST);

	if(count($errors) == 0)
	{
		header("Location: login1.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tennis Club Sun</title>
    <link rel="stylesheet" href="style1.css">
	<link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">
	<style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sub-header {
            background-color: #333;
            color: white;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .nav-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .nav-links ul li {
            margin: 0 15px;
        }

        h1 {
            margin-top: 20px;
        }

        .div {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .div form {
            width: 300px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .div form input {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            box-sizing: border-box;
        }

        .div form input[type="submit"] {
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        .div form input[type="submit"]:hover {
            background-color: #555;
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
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="about.html">DESPRE NOI</a></li>
                    <li><a href="booking.php">INCHIRIAZA UN TEREN</a></li>
                    <li><a href="pagina3.html">DE CE TENIS CLUB SUN</a></li>
                    <li><a href="login1.php">LOGIN</a></li>
                    <li><a href="contact.html">CONTACT</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        
    </section>

	<h1>Signup</h1>

	<div>
		<div>
			<?php if(count($errors) > 0):?>
				<?php foreach ($errors as $error):?>
					<?= $error?> <br>	
				<?php endforeach;?>
			<?php endif;?>

		</div>
		<form method="post">
			<input type="text" name="username" placeholder="Username"><br>
			<input type="text" name="email" placeholder="Email"><br>
			<input type="text" name="password" placeholder="Password"><br>
			<input type="text" name="password2" placeholder="Retype Password"><br>
			<br>
			<input type="submit" value="Signup">
		</form>
		<br><br><br><br>
	</div>
</body>
</html>