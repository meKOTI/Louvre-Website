<?php

	session_start();

	if (isset($_SESSION['blad'])) unset($_SESSION['blad']);

	$polaczenie = mysqli_connect('localhost','root','','muzeum');
	
	if (isset($_POST['email']))
	{
		$wszystko_OK=true;
		
		//Sprawdź poprawność imienia
		$imie = $_POST['imie'];
		
		if ((strlen($imie)<3) || (strlen($imie)>50))
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Imie musi posiadać od 3 do 50 znaków!";
		}
		
		if (ctype_alnum($imie)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_imie']="Imie może składać się tylko z liter i cyfr!";
		}

		//Sprawdź poprawność nazwiska
		$nazwisko = $_POST['nazwisko'];
		
		if ((strlen($nazwisko)<3) || (strlen($nazwisko)>50))
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 50 znaków!";
		}
		
		if (ctype_alnum($imie)==false)
		{
			$wszystko_OK=false;
			$_SESSION['e_nazwisko']="Nazwisko może składać się tylko z liter i cyfr!";
		}
		
		// Sprawdź poprawność email'a
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			$_SESSION['e_email']="Podaj poprawny adres e-mail!";
		}
		
		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
		if (!isset($_POST['regulamin']))
		{
			$wszystko_OK=false;
			$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
		}					
		
		$_SESSION['fr_imie'] = $imie;
		$_SESSION['fr_nazwisko'] = $nazwisko;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
			if ($polaczenie->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				$rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto z takim adresem e-mail!";
				}		
				
				if ($wszystko_OK==true)
				{
					
					if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$haslo_hash', '$email', '$imie', '$nazwisko',0,0,0,0)"))
					{
						$_SESSION['udanarejestracja']=true;
						header('Location: udanarej.php');
					}
					else
					{
						throw new Exception($polaczenie->error);
					}
					
				}
				
				$polaczenie->close();
			}
			
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>';
			echo '<br />Informacja developerska: '.$e;
		}
		
	}
	
	
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Louvre - Rejestracja</title>
	<link rel="stylesheet" href="louvre.css">
	<style>
		body {
			overflow-y: scroll;
			background: url(https://api-www.louvre.fr/sites/default/files/2021-02/vue-de-la-pyramide-du-louvre-1.jpg) no-repeat;
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
		<p class='pojawianie'>Rejestracja</p>
	    <a href="index.php" class="logo"></a>
		<a href="login.php" class="login">
        <?php

        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) {
            echo "Konto";
        } else {
            echo "Zaloguj";
        }

        ?>
        </a>
	</nav><div class="nav"></div>
	

	<section class="sgn">

		<div class="sign">

			<div class="form-value">
			
				<form method="post">

				    <div class="box">
					<div class="input-box">
					    <ion-icon name="chevron-back-outline"></ion-icon>
						<input class="inf" type="text" value="<?php
						if (isset($_SESSION['fr_imie']))
						{
							echo $_SESSION['fr_imie'];
							unset($_SESSION['fr_imie']);
						}
					    ?>" name="imie" autocomplete="off">
						<label for="">Imie</label>
					</div>
					<?php
						if (isset($_SESSION['e_imie']))
						{
							echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
							unset($_SESSION['e_imie']);
						}
					?>
					</div>

					<div class="box">
					<div class="input-box">
					    <ion-icon name="chevron-back-outline"></ion-icon>
						<input class="inf" type="text" value="<?php
						if (isset($_SESSION['fr_nazwisko']))
						{
							echo $_SESSION['fr_nazwisko'];
							unset($_SESSION['fr_nazwisko']);
						}
					    ?>" name="nazwisko" autocomplete="off">
						<label for="">Nazwisko</label>
					</div>
					<?php
						if (isset($_SESSION['e_nazwisko']))
						{
							echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
							unset($_SESSION['e_nazwisko']);
						}
				    ?>
					</div>

                    <div class="box">
					<div class="input-box">
					    <ion-icon name="mail-outline"></ion-icon>
						<input class="inf" type="text" value="<?php
						if (isset($_SESSION['fr_email']))
						{
							echo $_SESSION['fr_email'];
							unset($_SESSION['fr_email']);
						}
					    ?>" name="email" autocomplete="off">
						<label for="">E-mail</label>
					</div>
					<?php
						if (isset($_SESSION['e_email']))
						{
							echo '<div class="error">'.$_SESSION['e_email'].'</div>';
							unset($_SESSION['e_email']);
						}
					?>
					</div>

					<div class="box">
					<div class="input-box">
					    <ion-icon name="lock-closed-outline"></ion-icon>
						<input class="inf" type="password"  value="<?php
						if (isset($_SESSION['fr_haslo1']))
						{
							echo $_SESSION['fr_haslo1'];
							unset($_SESSION['fr_haslo1']);
						}
					    ?>" name="haslo1" autocomplete="off">
						<label for="">Hasło</label>
					</div>
					<?php
						if (isset($_SESSION['e_haslo']))
						{
							echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
							unset($_SESSION['e_haslo']);
						}
					?>
					</div>

					<div class="box">
                    <div class="input-box">
					    <ion-icon name="lock-closed-outline"></ion-icon>
						<input class="inf" type="password" value="<?php
						if (isset($_SESSION['fr_haslo2']))
						{
							echo $_SESSION['fr_haslo2'];
							unset($_SESSION['fr_haslo2']);
						}
					    ?>" name="haslo2" autocomplete="off" >
						<label for="">Powtórz hasło</label>
					</div>
					<?php
						if (isset($_SESSION['e_haslo']))
						{
							echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
							unset($_SESSION['e_haslo']);
						}
					?>
					</div>

					<label>
						<p class="reg"><input type="checkbox" name="regulamin" <?php
						if (isset($_SESSION['fr_regulamin']))
						{
							echo "checked";
							unset($_SESSION['fr_regulamin']);
						}
							?>> Akceptuje regulamin<p>
					</label>
					
					<?php
						if (isset($_SESSION['e_regulamin']))
						{
							echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
							unset($_SESSION['e_regulamin']);
						}
					?>	
					
					<input class="button" type="submit" value="Zarejestruj">

				</form>

			</div>

		</div>

	</section>

	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>