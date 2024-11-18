<?php

	session_start();

	unset($_SESSION['bld1']);
	unset($_SESSION['bld2']);
	unset($_SESSION['bld3']);
	
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: login.php');
		exit();
	}

	$code = 303;

	if (isset($_POST['doladowanie'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['self'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['audio'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['guide'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['group'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['id'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['pracownik0'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['pracownik1'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['ban0'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['ban1'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['kodzik'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['iden'])) {
		header('Location:zalogowany.php', true, $code);
	}
	if (isset($_POST['typ'])) {
		header('Location:zalogowany.php', true, $code);
	}

	$polaczenie = mysqli_connect('localhost','root','','muzeum');

	$data_zakupu = date('Y-m-d');

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="louvre.css">
	<title>Louvre | Konto</title>
	<style>
		<?php
		if ($_SESSION['pracownik'] == true) {
		?>
		body {
			background: url("images/tlowork.jpeg") no-repeat;
			background-position: center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			overflow-y: scroll;
        }
		<?php 
		}
		if ($_SESSION['ban'] == true) {
		?>
		body {
			background: url("images/tloban.jpg") no-repeat;
			background-position: center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			overflow-y: scroll;
        }
		<?php
		}
		if ($_SESSION['ban'] == false && $_SESSION['pracownik'] == false && $_SESSION['admin'] == false) {
		?>
		body {
			overflow-y: scroll;
			background: url("images/tlouser.webp") no-repeat;
			background-position: center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
		}
		<?php
		}
		if ($_SESSION['admin'] == true) {
		?>
		html::-webkit-scrollbar{
			width: 0.6rem;
		}
		html::-webkit-scrollbar-track{
			background-color: rgb(0, 0, 0);
		}

		html::-webkit-scrollbar-thumb{
			background: rgba(43, 255, 0, 1);
		}
		body {
			background-color: black;
			overflow-y: scroll;
		}
		<?php
		}
		?>
	</style>
	<link rel="icon" href="images\favlouvre.ico">
</head>

<body>

    <nav>
		<p class='pojawianie'><?php
		if($_SESSION['admin'] == true) {
			echo "Panel admina";
		} else {
			echo "Twoje konto";
		}
		?></p>
	    <a href="index.php" class="logo pojawianie"></a>
		<a href="index.php" class="login">
        <?php

        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) {
            echo "Główna";
        } else {
            echo "Zaloguj";
        }

        ?>
        </a>
	</nav><div class="nav"></div>
	
<?php

if($_SESSION['admin'] == false) {
	if($_SESSION['ban'] == false) {
	    if($_SESSION['pracownik'] == false) {

//KONTO UŻYTKOWNIKA

?>

<div class="logout-user">
	<a href="logout.php">Wyloguj</a>
</div>

<div class="info-user">

<?php

    echo "<p class='hello'>".$_SESSION['imie']." ".$_SESSION['nazwisko'].'</p>';
	
    echo "<p><b>E-mail</b>: ".$_SESSION['email']."</p>";

	if (!empty($_POST['doladowanie']) && ($_POST['doladowanie'])>0 && ($_POST['doladowanie'])<=2000 ) {
		
		$doladowanie = $_POST['doladowanie'];
	
		$polaczenie = new mysqli('localhost', 'root', '', 'muzeum');
	
		$_SESSION['saldo'] = $_SESSION['saldo'] + $doladowanie;
	
		$polaczenie->query("UPDATE uzytkownicy SET saldo = $_SESSION[saldo] where id = $_SESSION[id]");
	}
	unset($_POST['doladowanie']);

	echo "<p><b>Portfel</b>: ".$_SESSION['saldo']."Є</p>";

	$id = $_SESSION['id'];
?>
	<div class="wallet">
		<a href="wallet.php">Doładuj portfel</a>
	</div>

	<div class="ticket">
		<a href="ticket.php">Kup bilet</a>
	</div>
</div>

<?php
    $id = $_SESSION['id'];
	$querie = "SELECT zakup_id, ticket_id, ilosc, cena_b, typ, data_zakupu, kod, data FROM zakup JOIN ticket ON ticket.id = zakup.ticket_id WHERE user_id = $_SESSION[id] ORDER BY `zakup`.`data` ASC";
	$querie2 = "SELECT zakup_id, ticket_id, ilosc, cena_b, data_zakupu, kod, data FROM zakup WHERE user_id = $_SESSION[id] ORDER BY `zakup`.`data` ASC";
	$wynik = mysqli_query($polaczenie,$querie);
	$wynik2 = mysqli_query($polaczenie,$querie2);
	if (mysqli_num_rows($wynik)>0 OR mysqli_num_rows($wynik2)>0) {
	    echo "<div class='tabela-user'>
		<table class='table' border='1'><tr>
	    <th>Kod</th>
		<th>Data do wykorzystania</th>
		<th>Typ biletu</th>
		<th>Ilość ludzi</th>
		<th>Kwota</th>
		</tr>";
	}
    while($wiersz2 = mysqli_fetch_array($wynik2)) {
	    if($wiersz2['ticket_id'] == 0) {
		$ilosc = $wiersz2['ilosc'];
		$cena = $wiersz2['cena_b'];
		$kwota = $ilosc * $cena;
		echo "<tr>
        <td colspan='5'>Ten typ biletu został usunięty</td>
		<td><form action='zalogowany.php' method='post'>
		<input type='hidden' name='kwota' value=".$kwota.">
		<input type='hidden' name='id' value=".$wiersz2['zakup_id'].">
		<input type='submit' name='s' value='Zwrot pieniędzy'>
		</form></td></tr>";
		}
    } 
	while($wiersz = mysqli_fetch_array($wynik)) {
		$ilosc = $wiersz['ilosc'];
		$cena = $wiersz['cena_b'];
		$kwota = $ilosc * $cena;
		if($wiersz['data']>=$data_zakupu) {
		echo "<tr>
		    <td>".$wiersz['kod']."</td>
		    <td>".$wiersz['data']."</td>
		    <td>".$wiersz['typ']."</td>
			<td>".$wiersz['ilosc']."</td>
			<td>".$kwota."Є</td>
			<td><form action='zalogowany.php' method='post'>
			<input type='hidden' name='kwota' value=".$kwota.">
			<input type='hidden' name='id' value=".$wiersz['zakup_id'].">
			<input type='submit' name='s' value='Oddaj bilet'>
			</form></td>
			</tr>";
		} else {
		echo "<tr>
		    <td>".$wiersz['kod']."</td>
		    <td>".$wiersz['data']."</td>
		    <td>".$wiersz['typ']."</td>
			<td>".$wiersz['ilosc']."</td>
			<td>".$kwota."Є</td>
			<td><form action='zalogowany.php' method='post'>
			<input type='hidden' name='idk' value=".$wiersz['zakup_id'].">
			<input type='submit' name='s' value='Po terminie'>
			</form></td>
			</tr>";
		}
	}
	echo "</table></div>";
	if(isset($_POST['id'])) {
		$id = $_POST['id'];
		$cenka = $_POST['kwota'];
		$sql1 = "DELETE FROM zakup WHERE zakup_id = $id";
		$polaczenie->query($sql1);
		$_SESSION['saldo'] = $_SESSION['saldo'] + $cenka;
		$sql2 = "UPDATE uzytkownicy SET saldo = $_SESSION[saldo] where id = $_SESSION[id]";
		$polaczenie->query($sql2);
	}
	if(isset($_POST['idk'])) {
		$idk = $_POST['idk'];
		$sql4 = "DELETE FROM zakup WHERE zakup_id = $idk";
		$polaczenie->query($sql4);

	}
	
?>

<?php

        } else if($_SESSION['pracownik'] == true) {

//KONTO PRACOWNIKA

?>
<div class="logout">
    <a href='logout.php'>Wyloguj</a>
</div>
<div class='pracownik'>
	<form action="zalogowany.php" method="post">
		<div class="form-box">
			<label for="">KOD</label>
			<input type="number" name="kod">
		</div>
		<input type="submit" value="Szukaj" class="search">
	</form>
</div>
<?php

if (!empty($_POST['kod'])) {
	echo "<div class='tabela'>";

	$kod = $_POST['kod'];

	$zapytanie = "SELECT user_id, data_zakupu, ilosc, typ, kod, data FROM zakup JOIN ticket ON ticket.id = zakup.ticket_id WHERE kod = $kod";

	$wynik = mysqli_query($polaczenie, $zapytanie);

	if(mysqli_num_rows($wynik)<1) {
		echo "<p>~ nie znaleziono takiego biletu ~</p>";
	}
	if(mysqli_num_rows($wynik)>0) {
		echo "<table class='table' border='1'><tr>
		<th>Dzień zakupu</th>
		<th>Data do wykorzystania</th>
		<th>Typ biletu</th>
		<th>Ilość ludzi</th>
		</tr>";
	}

	while($row = mysqli_fetch_array($wynik)) {

		if($row['data']==$data_zakupu) {

			$uid = $row['user_id'];
			$pytanko = "SELECT ban FROM uzytkownicy where id=$uid";
			$wynik7 = mysqli_query($polaczenie,$pytanko);
		
		    echo "<tr>
			<td>".$row['data_zakupu']."</td>
			<td>".$row['data']."</td>
			<td>".$row['typ']."</td>
			<td>".$row['ilosc']."</td>
			<td class='button'>";
			while($spr = mysqli_fetch_array($wynik7)) {
				if ($spr['ban'] == true) {
					echo "Klient zablokowany";
				} else if ($spr['ban'] == false) {
					echo "<form action='zalogowany.php' method='post'>
						<input type='hidden' name='ile' value=".$row['ilosc'].">
						<input type='hidden' name='dz' value=".$row['data'].">
						<input type='hidden' name='kodzik' value=".$row['kod'].">
						<input type='submit' class='use' name='s'
						value='Wykorzystaj'>
						</form>";
				}
			}
			echo "</td>
		    </tr>";

		} else if($row['data']>$data_zakupu) {

			echo "<tr>
			<td>".$row['data_zakupu']."</td>
			<td>".$row['data']."</td>
			<td>".$row['typ']."</td>
			<td>".$row['ilosc']."</td>
			<td class='button'>Zła data</td>
		    </tr>";

		} else {

			echo "<tr>
			<td>".$row['data_zakupu']."</td>
			<td>".$row['data']."</td>
			<td>".$row['typ']."</td>
			<td>".$row['ilosc']."</td>
			<td class='button'>
			    <form action='zalogowany.php' method='post'>
				<input type='hidden' name='kodzik' value=".$row['kod'].">
				<input type='submit' class='after' name='s' value='Po terminie'>
				</form>
			</td>
		    </tr>";
		}
	}
echo "</div>";
}
if(isset($_POST['kodzik'])) {
	$kodzik = $_POST['kodzik'];
	$sql3 = "DELETE FROM zakup WHERE kod = $kodzik";
	$polaczenie->query($sql3);
	if (isset($_POST['ile']) && isset($_POST['dz'])) {
		$ile = $_POST['ile'];
		$dz = $_POST['dz'];
		$sql5 = "INSERT INTO goscie VALUES (NULL, $ile, '$dz')";
		$polaczenie->query($sql5);
	}
}

?>

<?php

        }
	} else if($_SESSION['ban'] == true) {

//ZBANOWANE KONTO

?>

<div class="banik">
	<img src="https://media.tenor.com/geRDKJL0zcIAAAAM/sad-crying.gif">
	<p>Zostałeś zablokowany <b>😥<b></p>
	<div class="button">
		<a href='logout.php'>Powrót</a>
    </div>
</div>       

<?php

	}
} else if($_SESSION['admin'] == true) {

//KONTO ADMINA

?>

<div class='pasek'></div>

<div class="logout-admin">
    <a href='logout.php'>Wyloguj</a>
</div>
<div class="staty">
    <a href='staty.php'>Statystyki</a>
</div>

<div class="zakladki">
	<button class="zakladka1" id="przycisk1">Klienci</button>
	<div class="sciana1" id="sciana1"></div>
	<div class="sciana2" id="sciana2"></div>
	<button class="zakladka2" id="przycisk2">Bilety</button>
</div>

    <div class="ile">Ile turystów dzisiaj</div>
	<div class="kolo"></div>
	<div class="nkolo"><p class="text"><?php

	$zapytanko = "SELECT sum(ile) as suma FROM goscie WHERE kiedy = '$data_zakupu'";
    $ludzie = mysqli_query($polaczenie,$zapytanko);
    $row1 = mysqli_fetch_array($ludzie);
    echo $row1['suma'];
    if($row1['suma'] == NULL) {
	    echo "0";
    }

	?></p></div>
	<div class="ile2">Dzisiejszy dochód</div>
	<div class="kolo2"></div>
	<div class="nkolo2"><p class="text"><?php

    $suma = 0;

	$zapytanko2 = "SELECT ilosc, cena FROM zakup JOIN ticket ON zakup.ticket_id = ticket.id WHERE data_zakupu = '$data_zakupu'";
	$dochod = mysqli_query($polaczenie,$zapytanko2);
	while($wierszyk = mysqli_fetch_array($dochod)) {
		$ilosc = $wierszyk['ilosc'];
		$cena = $wierszyk['cena'];

		$sum = $ilosc * $cena;

		$suma = $suma + $sum;
	}
	if ($suma == 0) {
		echo "-";
	} else {
	echo $suma."Є";
	}

	?></p></div>
<div id="pole2">
<div class="bilety">
<fieldset>
	<legend>Dodaj bilet</legend>
	<form action="zalogowany.php" method="post">
		<p>Typ biletu <input type="text" name="typ" autocomplete='off'></p>
		<p>Cena <input type="number" name="cena" min='1' max = '2000' autocomplete='off'></p>
		<p class='nawias'>Ile ludzi</p>
		<div class="sciana"></div>
		<p class='min'>Min <input type="number" name="od" min='1' max = '40' autocomplete='off'></p>
		<p class='max'>Max <input type="number" name="do" min='1' max = '40' autocomplete='off'></p>
		<input type="submit" value="Dodaj" class='dod'>
	</form>
</fieldset>
</div>

<?php
if(isset($_POST['typ']) AND isset($_POST['cena']) AND isset($_POST['od']) AND isset($_POST['do'])) {
	$typ = $_POST['typ'];
	$cena = $_POST['cena'];
	$od = $_POST['od'];
	$do = $_POST['do'];
	if($cena>0 AND $cena<2000) {
		if($od>0 AND $do>0 AND $od<=$do) {
			$polaczenie->query("INSERT INTO ticket (typ,cena,od,do) VALUES ('$typ', $cena, $od, $do)");
		}
	}
}
unset($_POST['typ']);
unset($_POST['cena']);
unset($_POST['od']);
unset($_POST['do']);

$zap = "SELECT * FROM ticket";
$res = mysqli_query($polaczenie,$zap);
if(mysqli_num_rows($res)>=1) {
	echo "<table class='tab-bilety'><tr>
	<th>Typ</th>
	<th>Cena</th>
	<th>Min</th>
	<th>Max</th>
	</tr>";
	while($row = mysqli_fetch_array($res)) {
		echo "<tr>";
		echo "<td>$row[typ]</td>";
		echo "<td>$row[cena]Є</td>";
		echo "<td>$row[od]</td>";
		echo "<td>$row[do]</td>";
		echo "<td><form action='zalogowany.php' method='post'>
		<input type='hidden' value='$row[id]' name='iden'>
		<input type='submit' value='Usuń'>
		</form></td>";
		echo "</tr>";	
	}
	echo "</table>";
}
if(isset($_POST['iden'])) {
	$iden = $_POST['iden'];
	$que1 = "DELETE FROM ticket WHERE id = $iden";
	$polaczenie->query($que1);
	$que2 = "UPDATE zakup SET ticket_id = 0 WHERE ticket_id = $iden";
	$polaczenie->query($que2);
}
unset($_POST['iden']);

?>
</div>
<div id="pole1">
    <form action="zalogowany.php" method="post">
		<table class="szukanie">
			<tr>
				<th>E-mail</th>
				<th>Imię</th>
				<th>Nazwisko</th>
			</tr>
			<tr>
				<td>
					<input type="email" name="email" autocomplete='off'>
				</td>
				<td>
					<input type="text" name="imie" autocomplete='off'>
				</td>
				<td>
					<input type="text" name="nazwisko" autocomplete='off'>
				</td>
				<td>
					<input type='hidden' name='hide'>
					<input type="submit" class="srch" value="Szukaj">
				</td>
			</tr>
		</table>
    </form>

<?php
if(isset($_POST['hide'])) {
	$email = $_POST['email'];
	$imie = $_POST['imie'];
	$nazwisko = $_POST['nazwisko'];

	$zapytanie1 = "SELECT id, email, imie, nazwisko, pracownik, admin, ban FROM uzytkownicy WHERE email = '$email' AND imie = '$imie' AND nazwisko = '$nazwisko'";

	$wynik1 = mysqli_query($polaczenie,$zapytanie1);

	if(mysqli_num_rows($wynik1)<1) {
		if (!empty($email) AND !empty($imie) AND !empty($nazwisko)) {
			echo "<div class='return'><form action='zalogowany.php' method='post'>
			<input type='submit' value='Powrót'>
			</form></div><p class='zero'>nie ma takiego użytkownika w bazie!</p>";
            $ok = "false";
        } else {
		$zapytanie2 = "SELECT id, email, imie, nazwisko, pracownik, admin, ban FROM uzytkownicy WHERE (email = '$email' AND imie = '$imie') OR (nazwisko = '$nazwisko' AND email = '$email') OR (imie = '$imie' AND nazwisko = '$nazwisko')";
		$wynik2 = mysqli_query($polaczenie,$zapytanie2);
		if(mysqli_num_rows($wynik2)<1) {
			if ((!empty($email) AND !empty($imie)) OR (!empty($email) AND !empty($nazwisko)) OR (!empty($imie) AND !empty($nazwisko))) {
				echo "<div class='return'><form action='zalogowany.php' method='post'>
				<input type='submit' value='Powrót'>
				</form></div><p class='zero'>nie ma takiego użytkownika w bazie!</p>";
                $ok = "false";
            } else {
			$zapytanie3 = "SELECT id, email, imie, nazwisko, pracownik, admin, ban FROM uzytkownicy WHERE email = '$email' OR imie = '$imie' OR nazwisko = '$nazwisko'";
			$wynik3 = mysqli_query($polaczenie,$zapytanie3);
			if(mysqli_num_rows($wynik3)<1) {
				echo "<div class='return'><form action='zalogowany.php' method='post'>
				<input type='submit' value='Powrót'>
				</form></div><p class='zero'>nie ma takiego użytkownika w bazie!</p>";
				$ok = "false";
			} else {
				$wynik = $wynik3;
				$ok = "true";
			}
		    }
		} else {
			$wynik = $wynik2;
			$ok = "true";
		}
	    }
	} else {
		$wynik = $wynik1;
		$ok = "true";
	}
	if ($ok == "true") {
		echo "<div class='return'><form action='zalogowany.php' method='post'>
		<input type='submit' value='Powrót'>
		</form></div>
		<table class='tab-users'>
			<tr>
			    <th>ID</th>
				<th>E-mail</th>
				<th>Imię</th>
				<th>Nazwisko</th>
				<th>Pracownik</th>
				<th>Ban</th>
			</tr>";
		while($row = mysqli_fetch_array($wynik)) {
			echo "<tr>";
			if($row['admin'] == true) {
				echo "<td class='gold'>".$row['id']."</td>";
				echo "<td class='gold'>".$row['email']."</td>
				<td class='gold'>".$row['imie']."</td>
				<td class='gold'>".$row['nazwisko']."</td>";
			} else {
			echo "<td class='id'>".$row['id']."</td>";
			echo "<td>".$row['email']."</td>
				<td>".$row['imie']."</td>
				<td>".$row['nazwisko']."</td>";
			}
			if($row['admin'] == true) {
				echo "<td class='brak'>Brak</td><td class='brak'>Brak</td>";
			} else if($row['admin'] == false) {
			if($row['pracownik'] == true) {
				echo "<td>
					<form action='zalogowany.php' method='post'>
					<input type='hidden' name='pracownik1' value=".$row['id'].">
					<input type='submit' name='s' value='Tak'>
					</form>
				    </td>";
			}
			if($row['pracownik'] == false) {
				echo "<td>
					<form action='zalogowany.php' method='post'>
					<input type='hidden' name='pracownik0' value=".$row['id'].">
					<input type='submit' name='s' value='Nie'>
					</form>
				    </td>";
			}
			if($row['ban'] == true) {
				echo "<td>
					<form action='zalogowany.php' method='post'>
					<input type='hidden' name='ban1' value=".$row['id'].">
					<input type='submit' name='s' value='Tak'>
					</form>
				    </td>";
			}
			if($row['ban'] == false) {
				echo "<td>
					<form action='zalogowany.php' method='post'>
					<input type='hidden' name='ban0' value=".$row['id'].">
					<input type='submit' name='s' value='Nie'>
					</form>
				    </td>";
			}
		    }
			
			echo "</tr>";
		}
    }
} else if(!isset($_POST['hide'])) {
	$zapytanie = "SELECT id, email, imie, nazwisko, pracownik, admin, ban FROM uzytkownicy";
	$wynik = mysqli_query($polaczenie,$zapytanie);
	echo "<table class='tab-users'>
			<tr>
			    <th>ID</th>
				<th>E-mail</th>
				<th>Imię</th>
				<th>Nazwisko</th>
				<th>Pracownik</th>
				<th>Ban</th>
			</tr>";
	while($row = mysqli_fetch_array($wynik)) {
		echo "<tr>";
		if($row['admin'] == true) {
			echo "<td class='gold'>".$row['id']."</td>";
			echo "<td class='gold'>".$row['email']."</td>
			<td class='gold'>".$row['imie']."</td>
			<td class='gold'>".$row['nazwisko']."</td>";
		} else {
		echo "<td class='id'>".$row['id']."</td>";
		echo "<td>".$row['email']."</td>
			<td>".$row['imie']."</td>
			<td>".$row['nazwisko']."</td>";
		}
		if($row['admin'] == true) {
			echo "<td class='brak'>Brak</td><td class='brak'>Brak</td>";
		} else if($row['admin'] == false) {
		if($row['pracownik'] == true) {
			echo "<td>
				<form action='zalogowany.php' method='post'>
				<input type='hidden' name='pracownik1' value=".$row['id'].">
				<input type='submit' name='s' value='Tak'>
				</form>
				</td>";
		}
		if($row['pracownik'] == false) {
			echo "<td>
				<form action='zalogowany.php' method='post'>
				<input type='hidden' name='pracownik0' value=".$row['id'].">
				<input type='submit' name='s' value='Nie'>
				</form>
				</td>";
		}
		if($row['ban'] == true) {
			echo "<td>
				<form action='zalogowany.php' method='post'>
				<input type='hidden' name='ban1' value=".$row['id'].">
				<input type='submit' name='s' value='Tak'>
				</form>
				</td>";
		}
		if($row['ban'] == false) {
			echo "<td>
				<form action='zalogowany.php' method='post'>
				<input type='hidden' name='ban0' value=".$row['id'].">
				<input type='submit' name='s' value='Nie'>
				</form>
				</td>";
		}
	    }
		echo "</tr>";
	}
echo "</table>";
}
if(isset($_POST['pracownik0'])) {
	echo "dziala";
	$id = $_POST['pracownik0'];
	$sql = "UPDATE uzytkownicy SET pracownik = 1 WHERE id = $id";
	$polaczenie->query($sql);
}
if(isset($_POST['pracownik1'])) {
	echo "dziala";
	$id = $_POST['pracownik1'];
	$sql = "UPDATE uzytkownicy SET pracownik = 0 WHERE id = $id";
	$polaczenie->query($sql);
}
if(isset($_POST['ban0'])) {
	echo "dziala";
	$id = $_POST['ban0'];
	$sql = "UPDATE uzytkownicy SET ban = 1 WHERE id = $id";
	$polaczenie->query($sql);
}
if(isset($_POST['ban1'])) {
	echo "dziala";
	$id = $_POST['ban1'];
	$sql = "UPDATE uzytkownicy SET ban = 0 WHERE id = $id";
	$polaczenie->query($sql);
}

?>

</div>

<?php

}	

?>

<script src="admin.js"></script>

</body>
</html>