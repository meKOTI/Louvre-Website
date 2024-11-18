<?php

	session_start();
	
	if ((!isset($_POST['mail'])) || (!isset($_POST['haslo'])))
	{
		header('Location: login.php');
		exit();
	}

	require_once "connect.php";

	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($polaczenie->connect_errno!=0)
	{
		echo "Error: ".$polaczenie->connect_errno;
	}
	else
	{
		$mail = $_POST['mail'];
		$haslo = $_POST['haslo'];
		
		$mail = htmlentities($mail, ENT_QUOTES, "UTF-8");
	
		if ($rezultat = @$polaczenie->query(
		sprintf("SELECT * FROM uzytkownicy WHERE email='%s'",
		mysqli_real_escape_string($polaczenie,$mail))))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				$wiersz = $rezultat->fetch_assoc();
				
				if (password_verify($haslo, $wiersz['pass']))
				{
					$_SESSION['zalogowany'] = true;
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['imie'] = $wiersz['imie'];
					$_SESSION['nazwisko'] = $wiersz['nazwisko'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['admin'] = $wiersz['admin'];
					$_SESSION['pracownik'] = $wiersz['pracownik'];
					$_SESSION['saldo'] = $wiersz['saldo'];
					$_SESSION['ban'] = $wiersz['ban'];
					
					unset($_SESSION['blad']);
					$rezultat->free_result();
					header('Location: zalogowany.php');
				}
				else 
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy e-mail lub hasło!</span>';
					header('Location: login.php');
				}
				
			} else {
				
				$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy e-mail lub hasło!</span>';
				header('Location: login.php');
				
			}
			
		}
		
		$polaczenie->close();
	}
	
?>