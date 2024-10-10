<?php

require 'config2.php';

$url = "https://www.bankier.pl/surowce/notowania";

$dom = new DOMDocument();
@$dom->loadHTMLFile($url);

$xpath = new DOMXPath($dom);

$commodityXpaths = [

    'złoto' =>  /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[2]/td[2]',

    'gaz ziemny' => /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[9]/td[2]',

    'aluminium' =>  /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[8]/td[2]',

    'kakao'     => /*jedn*/ '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[10]/td[2]',

    'cukier'    => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[6]/td[2]',

    'pallad'    => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[5]/td[2]'
];

$rateXpaths = [

    'złoto' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[2]/td[3]',

    'gaz ziemny' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[9]/td[3]',

    'aluminium' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[8]/td[3]',

    'kakao' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[10]/td[3]',

    'cukier' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[2]/tr[6]/td[3]',

    'pallad' => '//*[@id="boxQuotes"]/div[2]/table[1]/tbody[1]/tr[5]/td[3]'
    
];

$stmt = $pdo2->prepare("INSERT INTO historyczne_ceny (surowiec, jednostka, cena, data_pobrana) VALUES (:surowiec, :jednostka, :cena, :data_pobrana)");

foreach ($commodityXpaths as $commodity => $xPathCommodity) {

    $commodityElements = $xpath->query($xPathCommodity);
    $jednostka = ($commodityElements->length > 0) ? trim($commodityElements->item(0)->nodeValue) : 'Brak danych.';

    $xPathRate = $rateXpaths[$commodity];
    $rateElements = $xpath->query($xPathRate);
    $cena = ($rateElements->length > 0) ? floatval(str_replace(',', '.', preg_replace('/[^\d.,]/', '', $rateElements->item(0)->nodeValue))) : null;
    
    $data_pobrana = date('Y-m-d H:i:s');
    
    if ($cena !== null) {
        $stmt->execute([
            ':surowiec' => ucfirst($commodity),
            ':jednostka' => $jednostka,
            ':cena' => $cena,
            ':data_pobrana' => $data_pobrana
        ]);
    }
}
?>
