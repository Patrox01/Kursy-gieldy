<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursy giełdowe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

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
    'złoto' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[2]',
    'gaz ziemny' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[17]/td[2]',
    'aluminium' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[2]',
];
// Wyświetlenie danych

echo '<table border="1">';
echo '<tr><th>Surowiec</th><th>Jednostka</th><th>Cena</th></tr>';

foreach ($commodityXpaths as $commodity => $xPath) {
    $elements = $xpath->query($xPath);
    echo '<tr><td>'.ucfirst($commodity) . '</td><td> ';
    if ($elements->length > 0) {
        echo $elements->item(0)->nodeValue;
    } else {
        echo 'Brak danych.';
    }

    echo '</td></tr>';

    echo '</table>';
}
?>
    <header>
        <h1>Kursy giełdowe</h1>

        <nav>
            <a href="#">Surowiec1</a>
            <a href="#">Surowiec2</a>
            <a href="#">Surowiec3</a>
            <a href="#">Surowiec4</a>
        </nav>   

    </header>

    <main>

        <div class="stock">

            <table>
                <tr>
                    <th>Nazwa</th>
                    <th>Jednostka</th>
                    <th>Kurs</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>

    </main>
    
</body>
</html>