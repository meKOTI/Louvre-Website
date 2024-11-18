<?php

session_start();
	
if (!isset($_SESSION['zalogowany']))
{
	header('Location: login.php');
	exit();
}
if ($_SESSION['admin'] == false)
{
	header('Location: login.php');
	exit();
}

$polaczenie = mysqli_connect('localhost','root','','muzeum');

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
            background-color: black;
            overflow-y: scroll;
        }
    </style>
    <link rel="icon" href="images\favlouvre.ico">
</head>
<body>
    <nav>
		<p>Panel admina</p>
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

    <div class='pasek'></div>

    <div class='ret'>
        <a href="zalogowany.php">Return</a>
    </div>

    <form action="staty.php" method="post">
		<table class="rmd">
			<tr>
				<th>Rok</th>
				<th>Miesiąc</th>
				<th>Dzień</th>
			</tr>
			<tr>
				<td>
					<input type="number" name="rok" autocomplete='off' min="2023" max="9999">
				</td>
				<td>
					<input type="number" name="mies" autocomplete='off' min="1" max="12">
				</td>
				<td>
					<input type="number" name="dzien" autocomplete='off' min="1" max="31">
				</td>
				<td>
					<input type='hidden' name='hide'>
					<input type="submit" class="srh" value="Szukaj">
				</td>
			</tr>
		</table>
    </form>

<?php

if(isset($_POST['hide'])) {
	$rok = $_POST['rok'];
	$miesiac = $_POST['mies'];
	$dzien = $_POST['dzien'];

    echo "<p class='data'>";
    if(!empty($rok)) {
        echo $rok;
    } else if (empty($rok)) {
        echo "XXXX";
    }
    echo ":";
    if(!empty($miesiac)) {
        if (strlen($miesiac) == 2) {
            echo "$miesiac";
        } else {
            echo "0$miesiac";
        }
    } else if (empty($miesiac)) {
        echo "XX";
    }
    echo ":";
    if(!empty($dzien)) {
        if (strlen($dzien) == 2) {
            echo "$dzien";
        } else {
            echo "0$dzien";
        }
    } else if (empty($dzien)) {
        echo "XX";
    }
    echo "</p>";
    echo "<table class='staty-table'><tr><th>Dochód</th><th>Turyści</th></tr><tr>";

	$zapytanie1 = "SELECT ilosc, cena_b FROM zakup WHERE YEAR(data_zakupu) = '$rok' AND MONTH(data_zakupu) = '$miesiac' AND DAY(data_zakupu) = '$dzien'";

	$wynik1 = mysqli_query($polaczenie,$zapytanie1);

	if(mysqli_num_rows($wynik1)<1) {

        if (!empty($rok) AND !empty($miesiac) AND !empty($dzien)) {
            $ok = "false";
        } else {
		$zapytanie2 = "SELECT ilosc, cena_b FROM zakup WHERE (YEAR(data_zakupu) = '$rok' AND MONTH(data_zakupu) = '$miesiac') OR (DAY(data_zakupu) = '$dzien' AND YEAR(data_zakupu) = '$rok') OR (MONTH(data_zakupu) = '$miesiac' AND DAY(data_zakupu) = '$dzien')";
		$wynik2 = mysqli_query($polaczenie,$zapytanie2);
		if(mysqli_num_rows($wynik2)<1) {
            if ((!empty($rok) AND !empty($miesiac)) OR (!empty($rok) AND !empty($dzien)) OR (!empty($miesiac) AND !empty($dzien))) {
                $ok = "false";
            } else {
			$zapytanie3 = "SELECT ilosc, cena_b FROM zakup WHERE YEAR(data_zakupu) = '$rok' OR MONTH(data_zakupu) = '$miesiac' OR DAY(data_zakupu) = '$dzien'";
			$wynik3 = mysqli_query($polaczenie,$zapytanie3);
			if(mysqli_num_rows($wynik3)<1) {
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
        $suma = 0;
		while($row = mysqli_fetch_array($wynik)) {

            $suma = $suma + $row['ilosc'] * $row['cena_b'];

		}
        echo "<td class='frst'>".$suma."Є</td>";
    } else if ($ok == "false") {
        echo "<td class='frst'>0Є</td>";
    }

    $zap1 = "SELECT ile FROM goscie WHERE YEAR(kiedy) = '$rok' AND MONTH(kiedy) = '$miesiac' AND DAY(kiedy) = '$dzien'";

	$wyn1 = mysqli_query($polaczenie,$zap1);

	if(mysqli_num_rows($wyn1)<1) {

        if (!empty($rok) AND !empty($miesiac) AND !empty($dzien)) {
            $oki = "false";
        } else {
		$zap2 = "SELECT ile FROM goscie WHERE (YEAR(kiedy) = '$rok' AND MONTH(kiedy) = '$miesiac') OR (DAY(kiedy) = '$dzien' AND YEAR(kiedy) = '$rok') OR (MONTH(kiedy) = '$miesiac' AND DAY(kiedy) = '$dzien')";
		$wyn2 = mysqli_query($polaczenie,$zap2);
		if(mysqli_num_rows($wyn2)<1) {
            if ((!empty($rok) AND !empty($miesiac)) OR (!empty($rok) AND !empty($dzien)) OR (!empty($miesiac) AND !empty($dzien))) {
                $oki = "false";
            } else {
			$zap3 = "SELECT ile FROM goscie WHERE YEAR(kiedy) = '$rok' OR MONTH(kiedy) = '$miesiac' OR DAY(kiedy) = '$dzien'";
			$wyn3 = mysqli_query($polaczenie,$zap3);
			if(mysqli_num_rows($wyn3)<1) {
				$oki = "false";
			} else {
				$wyn = $wyn3;
				$oki = "true";
			}
            }
		} else {
			$wyn = $wyn2;
			$oki = "true";
		}
        }
	} else {
		$wyn = $wyn1;
		$oki = "true";
	}
	if ($oki == "true") {
        $sum = 0;
		while($row2 = mysqli_fetch_array($wyn)) {

            $sum = $sum + $row2['ile'];

		}
        echo "<td class='scnd'>$sum</td>";
    } else if ($oki == "false") {
        echo "<td class='scnd'>0</td>";
    }
    echo "</tr></table>";
}

?>
    
</body>
</html>