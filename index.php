<?php

session_start();

if (isset($_SESSION['blad'])) unset($_SESSION['blad']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Louvre | Strona główna</title>

    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- CSS -->
    <link rel="stylesheet" href="home.css">

    <!-- Favicon -->
    <link rel="icon" href="images\favlouvre.ico">
</head>
<body>
<script>

    /* Slider */

    let i = 0;
        let images = [];

        images[0] = "images/THE ART OF PORTRAITURE.jpg";
        images[1] = "images/QUEENS, KINGS AND EMPERORS.jpg";
        images[2] = "images/MAJOR EVENTS IN HISTORY.jpg";
        images[3] = "images/ACQUISITIONS MADE IN 2020.jpg";
        images[4] = "images/MASTERPIECES OF THE LOUVRE.jpg";
        images[5] = "images/NATIONAL MUSEUMS RECOVERY.jpg";

        function changeImg() {
            document.slide.src = images[i];

            if(i < images.length - 1) {
                i++;
            } else {
                i = 0;
            }
            
            setTimeout("changeImg()", 4000);
        }

        window.onload = changeImg;

    /* hidden DIV */

    function op(obj) {
        x=document.getElementById(obj);
        if(x.style.display == "none") x.style.display = "block";
        else x.style.display = "none"
    }
         
    /* Date */

    function jakiDzien() {
        const data = new Date();
        dzien = data.getDay();
        switch(dzien){
            case 0: document.write("<p class='otwarte'>🟢 Dzisiaj od 9:00 do 18:00</p>"); break;
            case 1: document.write("<p class='otwarte'>🟢 Dzisiaj od 9:00 do 18:00</p>"); break;
            case 2: document.write("<p class='otwarte'>🔴 Zamknięte</p>"); break;
            case 3: document.write("<p class='otwarte'>🟢 Dzisiaj od 9:00 do 18:00</p>"); break;
            case 4: document.write("<p class='otwarte'>🟢 Dzisiaj od 9:00 do 18:00</p>"); break;
            case 5: document.write("<p class='otwarte'>🟢 Dzisiaj od 9:00 do 21:45</p>"); break;
            case 6: document.write("<p class='otwarte'>🟢 Dzisiaj od 9:00 do 18:00 </p>"); break;
            default: document.write("<p>Dziś mamy nieznany dzień tygodnia :)</p>");
        }
    }

</script>

<div class='background2'>
</div>

    <div class="spinner-box" id='preloader'>
        <div class="leo-border-1">
            <div class="leo-core-1"></div>
        </div> 
        <div class="leo-border-2">
            <div class="leo-core-2"></div>
        </div> 
    </div>

    <nav>
    <div class="ph-dot-nav nav">
        <a href="#start-1">Start</a>
        <a href="#bilety-2">Bilety</a>
        <a href="#kolekcje-3">Kolekcje</a>
        <a href="#galeria-4">Galeria</a>
        <a href="#mapa-5">Mapa</a>
        <div class="effect"></div>
    </div>

	    <a class="logo"></a>
		<a href="login.php" class="login">
        <?php

        if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) {
            echo $_SESSION['imie'];
        } else {
            echo "Zaloguj";
        }

        ?>
        </a>
	</nav>

<div class="container">

    <div class="kotwica" id="start-1"></div>
    <div class='przerwa'></div>

    <div class='info'>
        <div class="one-info">
            <h2><marquee behavior="scroll" direction="left">MUZEUM SZTUKI LOUVRE</marquee></h2>

            <script type="text/javascript">jakiDzien()</script>

            <div class="hours" onclick="op('hidden'); return false;">
                <p>godziny otwarte</p><p class="arrow">→</p>
            </div>
 
            <div id="hidden">
                <table class="plan">
                <tr>
                    <td>OD 9:00 DO 18:00</td>
                    <td>Poniedziałek, środa, czwartek, sobota, niedziela</td>
                </tr>
                <tr>
                    <td>OD 9:00 DO 21:45</td>
                    <td>Piątek</td>
                </tr>
                <tr>
                    <td>ZAMKNIĘTE</td>
                    <td>Wtorek</td>
                </tr>
                </table>
            </div>
        </div>
        <div class="two-info">
            <div class="column-line">
                <div></div>
            </div>
            <div class="img">
                <img src='https://c1.wallpaperflare.com/preview/502/634/441/mona-lisa-painting-art-oil-painting.jpg' alt='monalisa'>
            </div>
            <div class="column-line">
                <div></div>
            </div>
        </div>
    </div>

    <div class="kotwica" id="bilety-2"></div>
    <div class="przerwa"></div>
    
    <div class="bilet">

        <h2>BILETY</h2>

        <div class="ticket-table">
            <table>
            <?php
            $polaczenie = mysqli_connect("localhost","root","","muzeum");
            $zapytanie = "SELECT cena, typ FROM ticket";
            $wynik = mysqli_query($polaczenie, $zapytanie);
            $i = 0;
            while ($row = mysqli_fetch_array($wynik)) {
                $i++;
                if ($i<=5) {
                    echo "<tr>";
                echo "<td><h3>".$row['cena']."€</h3><p>".$row['typ']."</td>";
                echo "</tr>";
                } else {
                    break;
                }
            }
            ?>
            </table>
        </div>
        <div class='div-kup'>
            <?php
            if (isset($_SESSION['admin'])) {
                if ($_SESSION['admin']==true OR $_SESSION['pracownik']==true OR $_SESSION['ban']==true) {
                    echo "<p class='nie'><a>KUP</a></p>"; 
                 } else {
                    echo '<p class="kup"><a href="ticket.php">KUP</a></p>';
                 }
            } else {
                echo "<p class='nie'><a>KUP</a></p>";
            }
            ?>
        </div>
        <?php

        if ($i > 5) {
            echo "<p class='duzo'>...</p>";
        }
        
        ?>
    </div>
    <div class="zdj-bilet">
        <i class="fa-solid fa-ticket"></i>
    </div>

    <div class="kotwica" id="kolekcje-3"></div>
    <div class="przerwa"></div>

    <div class="kolekcje">
        <div class="info-kol">
            <h2>Kolekcje</h2>
            <ul>
                <li>THE ART OF PORTRAITURE</li>
                <li>QUEENS, KINGS AND EMPERORS</li>
                <li>MAJOR EVENTS IN HISTORY</li>
                <li>ACQUISITIONS MADE IN 2020</li>
                <li>MASTERPIECES OF THE LOUVRE</li>
                <li>NATIONAL MUSEUMS RECOVERY</li>
            </ul>
        </div>
        <div class="slider">
            <img name="slide" class='slide'>
        </div>
    </div>
    
    <div class="kotwica" id="galeria-4"></div>
    <div class="przerwa"></div>

    <div class="galeria">
        <h2>Galeria</h2>
        <script>

            function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("mySlides");
            let dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display="block";
            dots[slideIndex-1].className+=" active";
            }

            let slideIndex = 1;
            showSlides(slideIndex);

            function plusSlides(n) {
            showSlides(slideIndex += n);
            }

            function currentSlide(n) {
            showSlides(slideIndex = n);
            }
        </script>
        <div class="slideshow-container">

            <div class="mySlides fade first">
            <img src="https://api-www.louvre.fr/sites/default/files/2021-12/DSC5740.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
            <img src="https://api-www.louvre.fr/sites/default/files/2021-03/la-grande-galerie.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
            <img src="https://api-www.louvre.fr/sites/default/files/2020-12/galerie-d-apollon.png" style="width:100%">
            </div>
            <div class="mySlides fade">
            <img src="https://images.adsttc.com/media/images/6279/6977/ff0a/4701/65c8/5848/large_jpg/louvre32.jpg?1652124043" style="width:100%">
            </div>
            <div class="mySlides fade">
            <img src="https://api-www.louvre.fr/sites/default/files/2021-02/galerie-d-apollon-les-vitrines-des-joyaux-de-la-couronne.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
            <img src="https://api-www.louvre.fr/sites/default/files/2021-03/petite-galerie-5-figure-d-artiste-2.jpg" style="width:100%">
            </div>
            <div class="mySlides fade">
            <img src="https://api-www.louvre.fr/sites/default/files/2021-01/cour-napoleon-et-pyramide.jpg" style="width:100%">
            </div>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
            <br>

            <div style="text-align:center">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
            <span class="dot" onclick="currentSlide(5)"></span>
            <span class="dot" onclick="currentSlide(6)"></span>
            <span class="dot" onclick="currentSlide(7)"></span>
        </div>
    </div>

    <div class="kotwica" id="mapa-5"></div>
    <div class="przerwa"></div>

    <div class="mapa">
        <h2>Mapa</h2>
        <p>Pobierz mapę louvre'u <a href="mapalouvre.pdf">tutaj</a> ( EN )</p>

    <div style="width: 50%" class='gmap'>
        <iframe width="100%" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=320&amp;hl=en&amp;q=Mus%C4%99e%20du%20Louvre%20Paris,%20France+(Louvre)&amp;t=&amp;z=17&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.maps.ie/distance-area-calculator.html">measure distance on map</a></iframe>
    </div>

    </div>

    <div class="przerwa-f"></div>

    <footer>
        <div class="contact-info">
            <div class="info">
                <a href="https://www.facebook.com/museedulouvre"><i class="fa-brands fa-facebook-f"></i></a>
            </div>
            <div class="info">
                <a href="https://www.instagram.com/museelouvre/"><i class="fa-brands fa-instagram"></i></a>
            </div>
            <div class="info">
                <a href="https://twitter.com/museelouvre"><i class="fa-brands fa-twitter"></i></a>
            </div>
            <div class="info">
                <a href="https://www.youtube.com/user/louvre"><i class="fa-brands fa-youtube"></i></a>
            </div>
            <div class="info">
                <a href="https://www.pinterest.fr/museedulouvre/"><i class="fa-brands fa-pinterest"></i></a>
            </div>
            <div class="info">
                <a href="https://fr.linkedin.com/company/musee-du-louvre"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        </div>
        <div class="last">
            <p>Witryna stworzona przez: Patryk Kotula</p>
        </div>
    </footer>
</div>

</body>
</html>