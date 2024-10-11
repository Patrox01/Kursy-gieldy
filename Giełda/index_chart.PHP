<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursy giełdowe</title>
    <link rel="stylesheet" href="style2.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <?php
    include 'config.php';
    include 'copy&save.php';
    include 'config2.php';
    include 'copy&save2.php';
    include 'config3.php';
    include 'copy&save3.php';
    ?>
</head>
<body>

< <header>

<div class="navow">
    <a href="#">Z ostatniej chwili</a>
    <a href="#">Notowania</a>
    <a href="#">AI</a>
    <a href="#">Firma</a>

    <div class="rejestruj">
        <a href="">Załóż konto</a>
    </div>
</div>

<div class="rejestracja">
    <div class="head">
    <img class="lock" src="lock-solid.svg" alt="">
    </div>
    <a href="">Zaloguj się</a>
</div>

<div class="shared_chart">

        <h2>Sprawdź najnowsze zmiany cen surowców na rynku - Porównaj ceny z trzech różnych źródeł!</h2>
        <a href="index_shared_chart.php">Porównaj zmiany w jednym miejscu!</a>

        </div>

</header>

    <main>

    <?php
    include 'price_history.php';
    ?>

    </main>

    <footer>

<div class="footer1">
<h1>Przydatne informacje</h1>
<ul>
    <li><a href="#">Kursy walut</a></li>
    <li><a href="#">Pogoda</a></li>
    <li><a href="#">Sport</a></li>
    <li><a href="#">Dieta</a></li>
    <li><a href="#">Horoskop</a></li>
    <li><a href="#">Oferta</a></li>
    <li><a href="#">Powódź 2024</a></li>
</ul>
</div>

<div class="O_nas">
    <h1>Nazwa</h1>
    <ul>
        <li><a href="#">O nas</a></li>
        <li><a href="#">Kariera</a></li>
        <li><a href="#">Aktualności</a></li>
        <li><a href="#">Biuro prasowe</a></li>
        <li><a href="#">System partnerski</a></li>
        <li><a href="#">Obsługa klienta</a></li>   
    </ul>
</div>

<div class="Pomoc">
    <h1>Pomoc i kontakt</h1>
    <ul>
        <li><a href="#">Kontaktuj się online</a></li>
        <li><a href="#">Nasza placówka</a></li>
        <li><a href="#">Telefon: 1 9999</a></li><p>24h / 7dni</p>
        <li><a href="#">Pytania i odpowiedzi</a></li>
    </ul>   
</div>

<div class="footer2">
<h1>Znajdziesz nas też na</h1>
<img class="facb" src="facebook.png" alt="">
<img class="facb" src="instagram.png" alt="">
<img class="facb" src="x-twitter-s.svg" alt="">
<img class="facb" src="youtube.png" alt="">

    <div class="wersja">
        <h2>Wersja językowa</h2>

        <a href="#">PL</a>
        <a href="#">EN</a>
        <a href="#">ES</a>
    </div>
</div>

    <div class="footer3">
        <p>2024 &copy; Nazwa. Wszelkie prawa zastrzeżone.
        Nazwa i logo są zarejestrowanymi znakami towarowymi.</p>

        <p>Opłata za połączenie z infolinią wiadomości zgodna z taryfą danego operatora.
        Słowniczek pojęć i definicji dotyczących usług reprezentatywnych, wynikających z rozporządzenia
        <br>Ministra Rozwoju i Finansów z dnia 14 lipca 2017 r. w sprawie wykazu usług reprezentatywnych
            powiązanych z rachunkiem płatniczym,
        dostępny jest na stronie<br> strona.pl/PAD oraz w placówkach.</p>

    </div>

<div class="footer4">
    <img src="logo_stopka.png" alt="">
    <a href="#">Regulamin serwisu</a>
    <a href="#">Polityka prywatności</a>
    <a href="#">Polityka przetwarzania danych osobowych (RODO)</a>
    <a href="#">Polityka cookies</a>
</div>

</footer>
    
</body>
</html>