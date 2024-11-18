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
            <a href="zalogowany.php">Powrót ⮌</a>
        </div>

        <div class="ticket">
            <a href="ticket.php">Kup bilet</a>
        </div>
    </div>

    <div class="charge">
        <form action="wallet.php" method="post">
            <input type="number" name="doladowanie" min="1" max="2000">
            <input type="submit" value="Doładuj" class="chrg">
        </form>
    </div>
    
</body>
</html>