<?php

session_start();
	
if (!isset($_SESSION['zalogowany']))
{
	header('Location: login.php');
	exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="louvre.css">
    <title>Louvre | Konto</title>
    <style>
        body {
            overflow-y: scroll;
			background: url(https://media.cntraveler.com/photos/57d961ce3e6b32bf25f5ad0f/16:9/w_2560,c_limit/most-beautiful-paris-louvre-GettyImages-536267205.jpg) no-repeat;
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
		<p>Twoje konto</p>
	    <a href="index.php" class="logo"></a>
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
            <a href="zalogowany.php">Powrót ⮌</a>
        </div>
    </div>
<div class="tickets">
<?php

$user = $_SESSION['id'];

$data_zakupu = date('Y-m-d');

$polaczenie = mysqli_connect('localhost','root','','muzeum');

$zapytanie = "SELECT * FROM ticket";

$wynik = mysqli_query($polaczenie,$zapytanie);

while($row = mysqli_fetch_array($wynik)) {
    echo "<div class='one'>
    <form action='ticket.php' method='post'>	
		<select name='rok'>
			<option value = '2023'>2023
			<option value = '2024'>2024
			<option value = '2025'>2025
		</select>	
		<select name='miesiac'>
			<option value='01'>Styczeń
			<option value='02'>Luty
			<option value='03'>Marzec
			<option value='04'>Kwiecień
			<option value='05'>Maj
			<option value='06'>Czerwiec
			<option value='07'>Lipiec
			<option value='08'>Sierpień
			<option value='09'>Wrzesień
			<option value='10'>Październik
			<option value='11'>Listopad
			<option value='12'>Grudzień
		</select>
		<select name='dzien'>
			<option value='01'>01
			<option value='02'>02
			<option value='03'>03
			<option value='04'>04
			<option value='05'>05
			<option value='06'>06
			<option value='07'>07
			<option value='08'>08
			<option value='09'>09
			<option value='10'>10
			<option value='11'>11
			<option value='12'>12
			<option value='13'>13
			<option value='14'>14
			<option value='15'>15
			<option value='16'>16
			<option value='17'>17
			<option value='18'>18
			<option value='19'>19
			<option value='20'>20
			<option value='21'>21
			<option value='22'>22
			<option value='23'>23
			<option value='24'>24
			<option value='25'>25
			<option value='26'>26
			<option value='27'>27
			<option value='28'>28
			<option value='29'>29
			<option value='30'>30
			<option value='31'>31
		</select>
		<p>".$row['typ']." <input type='number' name='ilosc' class='ilosc'> ".$row['cena']."Є</p>
		<p>Od ".$row['od']." do ".$row['do']." osób</p>
		<input type='hidden' name='od' value=".$row['od'].">
		<input type='hidden' name='do' value=".$row['do'].">
        <input type='hidden' name='id' value=".$row['id'].">
        <input type='hidden' name='cena' value=".$row['cena'].">
		<input type='submit' value='Kup'></form></div>";
}
    if(!empty($_POST['rok']) && !empty($_POST['miesiac']) && !empty($_POST['dzien']) && !empty($_POST['ilosc'])) {

		$rok = $_POST['rok'];
		$miesiac = $_POST['miesiac'];
		$dzien = $_POST['dzien'];
		$od = $_POST['od'];
		$do = $_POST['do'];
		$ilosc = $_POST['ilosc'];
        $cena = $_POST['cena'];
        $id = $_POST['id'];
		$data = $rok . "-" . $miesiac . "-" . $dzien;

		if($_POST['ilosc']>=$od && $_POST['ilosc']<=$do) {
			for($i = 0; $i == 0;) {
				$kod1 = rand(100000,999999);
	
				$rezultat = $polaczenie->query("SELECT zakup_id FROM zakup WHERE kod='$kod1'");
					
				if (!$rezultat) throw new Exception($polaczenie->error);
					
				$ile_takich_kodow = $rezultat->num_rows;
				
				if($ile_takich_kodow<1) {
					$i++;
				}
			}
			if($ile_takich_kodow<1) {
				$zapytanie1 = "SELECT cena FROM ticket where id = $id";
				$result = mysqli_query($polaczenie,$zapytanie1);
				$row2 = mysqli_fetch_array($result);
				$zaplata = $cena * $ilosc;
				if($_SESSION['saldo']>=$zaplata) {
					if($data>=$data_zakupu) {
					$polaczenie->query("INSERT INTO zakup VALUES (NULL, '$data', '$ilosc', '$data_zakupu', '$user', '$id', '$kod1', '$cena')");
					$_SESSION['saldo'] = $_SESSION['saldo'] - $zaplata;
					$polaczenie->query("UPDATE uzytkownicy SET saldo = $_SESSION[saldo] where id = $_SESSION[id]");
					unset($_SESSION['bld3']);
					} else {
						$_SESSION['bld3'] = '<span style="color:red">zła data!</span>';
					}
				unset($_SESSION['bld2']);
				} else {
					$_SESSION['bld2'] = '<span style="color:red">za mało pieniędzy!</span>';
				}
			}
		unset($_SESSION['bld1']);
		} else {
			$_SESSION['bld1'] = '<span style="color:red">zła liczba osób!</span>';
		}
    }
	unset($_POST['id']);
	unset($_POST['rok']);
	unset($_POST['miesiac']);
	unset($_POST['dzien']);
	unset($_POST['ilosc']);
    unset($_POST['cena']);

?>

</div>

<?php

if(isset($_SESSION['bld1']) OR isset($_SESSION['bld2']) OR isset($_SESSION['bld3'])) {

echo "<div class='bledy'>";

if (isset($_SESSION['bld1'])) {
	echo "<p>".$_SESSION['bld1']."</p>";
}
if (isset($_SESSION['bld2'])) {
	echo "<p>".$_SESSION['bld2']."</p>";
}
if (isset($_SESSION['bld3'])) {
	echo "<p>".$_SESSION['bld3']."</p>";
}

echo "</div>";

}

?>

</body>
</html>