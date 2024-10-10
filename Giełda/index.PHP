<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursy giełdowe</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
    include 'config.php';
    include 'copy&save.php';
    ?>
</head>
<body>

    <header>

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

    </header>

    <main>

    <div class="stock">
        <h2>Dane surowców pobrane z :</h2><br>
        <a href="https://notowania.pb.pl/commodities/">https://notowania.pb.pl/commodities/</a>
<?php
$url = 'https://notowania.pb.pl/commodities/';
// cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    die('Błąd w pobieraniu danych.');
}

$dom = new DOMDocument();

libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

$commodityXpaths = [
    'złoto' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[2]',

    'gaz ziemny' => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[17]/td[2]',

    'aluminium' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[2]',

    'kakao'     => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[2]',

    'cukier'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[2]',

    'pallad'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[2]'


];

$rateXpaths = [
    'złoto' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[3]/span',

    'gaz ziemny' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[17]/td[3]/span',

    'aluminium' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[3]/span',

    'kakao' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[3]/span',

    'cukier' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[3]/span',

    'pallad' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[3]/span'

];

// Dane
echo '<table border="1">';
echo '<tr><th>Surowiec</th><th>Jednostka</th><th>Cena</th></tr>';

foreach ($commodityXpaths as $commodity => $xPathCommodity) {
    $commodityelements = $xpath->query($xPathCommodity);

    $xPathRate = $rateXpaths[$commodity];
    $rateElements = $xpath->query($xPathRate);

    echo '<tr><td>'.ucfirst($commodity) . '</td>';

    echo '<td>';
    if ($commodityelements->length > 0) {
        echo $commodityelements->item(0)->nodeValue;
    } else {
        echo 'Brak danych.';
    }
    echo '</td>';

    echo '<td>';


 if ($rateElements->length > 0) {
        echo $rateElements->item(0)->nodeValue;
    } else {
        echo 'Brak danych.';
    }
    echo '</td>';
    
    echo '</tr>';
}

echo '</table>';

?>

</div>

<div class="stock2">
    <p>Zobrazuj zmiany cen na wykresie</p>

    <a href="index_chart.PHP"><img src="chart-bar-solid.svg" class="chart-bar" alt="wykres"></a>

</div>

</main>

<div class="main2">
<div class="stock2_1">
        <h2>Dane surowców pobrane z :</h2><br>
        <a href="https://notowania.pb.pl/commodities/">https://notowania.pb.pl/commodities/</a>
<?php
$url = 'https://notowania.pb.pl/commodities/';
// cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    die('Błąd w pobieraniu danych.');
}

$dom = new DOMDocument();

libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

$commodityXpaths = [
    'złoto' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[2]',

    'gaz ziemny' => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[17]/td[2]',

    'aluminium' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[2]',

    'kakao'     => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[2]',

    'cukier'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[2]',

    'pallad'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[2]'


];

$rateXpaths = [
    'złoto' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[3]/span',

    'gaz ziemny' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[17]/td[3]/span',

    'aluminium' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[3]/span',

    'kakao' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[3]/span',

    'cukier' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[3]/span',

    'pallad' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[3]/span'

];

// Dane
echo '<table border="1">';
echo '<tr><th>Surowiec</th><th>Jednostka</th><th>Cena</th></tr>';

foreach ($commodityXpaths as $commodity => $xPathCommodity) {
    $commodityelements = $xpath->query($xPathCommodity);

    $xPathRate = $rateXpaths[$commodity];
    $rateElements = $xpath->query($xPathRate);

    echo '<tr><td>'.ucfirst($commodity) . '</td>';

    echo '<td>';
    if ($commodityelements->length > 0) {
        echo $commodityelements->item(0)->nodeValue;
    } else {
        echo 'Brak danych.';
    }
    echo '</td>';

    echo '<td>';


 if ($rateElements->length > 0) {
        echo $rateElements->item(0)->nodeValue;
    } else {
        echo 'Brak danych.';
    }
    echo '</td>';
    
    echo '</tr>';
}

echo '</table>';

?>

</div>

<div class="stock2_2">
    <p>Zobrazuj zmiany cen na wykresie</p>

    <a href="index_chart2.PHP"><img src="chart-bar-solid.svg" class="chart-bar" alt="wykres"></a>

</div>

</div>

<div class="main3">
<div class="stock3_1">
        <h2>Dane surowców pobrane z :</h2><br>
        <a href="https://notowania.pb.pl/commodities/">https://notowania.pb.pl/commodities/</a>
<?php
$url = 'https://notowania.pb.pl/commodities/';
// cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

if ($response === false) {
    die('Błąd w pobieraniu danych.');
}

$dom = new DOMDocument();

libxml_use_internal_errors(true);
$dom->loadHTML($response);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

$commodityXpaths = [
    'złoto' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[2]',

    'gaz ziemny' => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[17]/td[2]',

    'aluminium' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[2]',

    'kakao'     => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[2]',

    'cukier'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[2]',

    'pallad'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[2]'


];

$rateXpaths = [
    'złoto' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[3]/span',

    'gaz ziemny' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[17]/td[3]/span',

    'aluminium' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[3]/span',

    'kakao' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[3]/span',

    'cukier' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[3]/span',

    'pallad' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[3]/span'

];

// Dane
echo '<table border="1">';
echo '<tr><th>Surowiec</th><th>Jednostka</th><th>Cena</th></tr>';

foreach ($commodityXpaths as $commodity => $xPathCommodity) {
    $commodityelements = $xpath->query($xPathCommodity);

    $xPathRate = $rateXpaths[$commodity];
    $rateElements = $xpath->query($xPathRate);

    echo '<tr><td>'.ucfirst($commodity) . '</td>';

    echo '<td>';
    if ($commodityelements->length > 0) {
        echo $commodityelements->item(0)->nodeValue;
    } else {
        echo 'Brak danych.';
    }
    echo '</td>';

    echo '<td>';


 if ($rateElements->length > 0) {
        echo $rateElements->item(0)->nodeValue;
    } else {
        echo 'Brak danych.';
    }
    echo '</td>';
    
    echo '</tr>';
}

echo '</table>';

?>

</div>

<div class="stock3_2">
    <p>Zobrazuj zmiany cen na wykresie</p>

    <a href="index_chart3.PHP"><img src="chart-bar-solid.svg" class="chart-bar" alt="wykres"></a>

</div>

    
</div>
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