<?php

	require "mail.php";
	require "functions.php";
	check_login();

	$errors = array();

	if($_SERVER['REQUEST_METHOD'] == "GET" && !check_verified()){

		//send email
		$vars['code'] =  rand(10000,99999);

		//save to database
		$vars['expires'] = (time() + (60 * 10));
		$vars['email'] = $_SESSION['USER']->email;

		$query = "insert into verify (code,expires,email) values (:code,:expires,:email)";
		database_run($query,$vars);

		$message = "your code is " . $vars['code'];
		$subject = "Email verification";
		$recipient = $vars['email'];
		send_mail($recipient,$subject,$message);
	}

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		if(!check_verified()){

			$query = "select * from verify where code = :code && email = :email";
			$vars = array();
			$vars['email'] = $_SESSION['USER']->email;
			$vars['code'] = $_POST['code'];

			$row = database_run($query,$vars);

			if(is_array($row)){
				$row = $row[0];
				$time = time();

				if($row->expires > $time){

					$id = $_SESSION['USER']->id;
					$query = "update user set email_verified = email where id = '$id' limit 1";
					
					database_run($query);

					header("Location: profile.php");
					die;
				}else{
					echo "Code expired";
				}

			}else{
				echo "wrong code";
			}
		}else{
			echo "You're already verified";
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tennis Club Sun</title>
    <link rel="stylesheet" href="style.css">
	
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,500;1,200;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css">

	<title>Verify</title>
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
                    <li><a href="profile.php">PROFIL</a></li>
                </ul>
            </div>
        </nav>

    </section>
	<br><br><br>
<h1>Verificare</h1>
 	<div>
			<br>Un email a fost trimis la adresa dumneavostră. Inserați codul primit aici.<br>
		<div>
			<?php if(count($errors) > 0):?>
				<?php foreach ($errors as $error):?>
					<?= $error?> <br>	
				<?php endforeach;?>
			<?php endif;?>

		</div><br>
		<form method="post">
			<input type="text" name="code" placeholder="Enter your Code"><br>
 			<br>
			<input type="submit" value="Verify">
		</form>
	</div>

</body>
</html>