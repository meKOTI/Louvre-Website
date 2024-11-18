<?php

	session_start();

	//Usuwanie zmiennych pamiętających wartości wpisane do formularza
	if (isset($_SESSION['fr_imie'])) unset($_SESSION['fr_imie']);
	if (isset($_SESSION['fr_nazwisko'])) unset($_SESSION['fr_nazwisko']);
	if (isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
	if (isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
	if (isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
	if (isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);
	
	//Usuwanie błędów rejestracji
	if (isset($_SESSION['e_imie'])) unset($_SESSION['e_imie']);
	if (isset($_SESSION['e_nazwisko'])) unset($_SESSION['e_nazwisko']);
	if (isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
	if (isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
	if (isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
	
	if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: zalogowany.php');
		exit();
	}


?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="louvre.css">
	<title>Louvre | Logowanie</title>
	<style>
        body {
			overflow-y: scroll;
			background: url("images/tlologrej.webp") no-repeat;
			background-position: center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
        }
    </style>
	<link rel="icon" href="images\favlouvre.ico">
</head>

<body>

    <nav>
		<p class='pojawianie'>Logowanie</p>
	    <a href="index.php" class="logo pojawianie"></a>
		<a href="rejestracja.php" class="login">
        <?php

        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) {
            echo "Konto";
        } else {
            echo "Zarejestruj";
        }

        ?>
        </a>
	</nav><div class="nav"></div>

	<section class="lg">

		<div class="log">

			<div class="form-value">
		
				<form action="zaloguj.php" method="post">
				
					<div class="input-box">
						<ion-icon name="mail-outline"></ion-icon>
						<input type="email" name="mail" autocomplete="off">
						<label for="">Email</label>
					</div>
					<div class="input-box">
						<ion-icon name="lock-closed-outline"></ion-icon>
						<input type="password" name="haslo">
						<label for="">Hasło</label>
					</div>
					<?php
					if(isset($_SESSION['blad'])) { echo "<p class='blad'>".$_SESSION['blad']."</p>"; }
					?>
					<input class="button" type="submit" value="Zaloguj">
				
				</form>

			</div>

		</div>

	</section>

	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>