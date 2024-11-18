<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="louvre.css">
    <title>Louvre | Rejestracja</title>
    <style>
        body {
			min-height: 100vh;
			background: url(https://api-www.louvre.fr/sites/default/files/2021-02/vue-de-la-pyramide-du-louvre-1.jpg) no-repeat;

			background-position: center;
			background-size: cover;
        }
    </style>
    <link rel="icon" href="images\favlouvre.ico">
</head>
<body>
   
    <nav>
        <p>Rejestracja</p>
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
    

    <section class="lg">

		<div class="rej">

			<div class="form-value">
                <p>Sukcesywnie zarejestrowany</p> 
                <p class="button"><a href="login.php">Dalej</a><p>
            </div>
        </div>
    </div>
</body>
</html>