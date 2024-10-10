<?php

require 'config3.php';

$url = "https://next.gazeta.pl/surowce/notowania-surowcow";

$dom = new DOMDocument();
@$dom->loadHTMLFile($url);

$xpath = new DOMXPath($dom);

$commodityXpaths = [

    'złoto' =>  /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[36]/div[2]',

    'gaz ziemny' => /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[6]/div[2]',

    'aluminium' =>  /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[1]/div[2]',

    'kakao'     => /*jedn*/ '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[8]/div[2]',

    'cukier'    => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[4]/div[2]',

    'pallad'    => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[22]/div[2]'
];

$rateXpaths = [

    'złoto' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[36]/div[3]',

    'gaz ziemny' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[6]/div[3]',

    'aluminium' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[1]/div[3]',

    'kakao' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[9]/div[3]',

    'cukier' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[4]/div[3]',

    'pallad' => '//*[@id="pageTypeId_0"]/div[7]/div/div[1]/div/div[3]/a[22]/div[3]'
    
];

$stmt = $pdo3->prepare("INSERT INTO historyczne_ceny (surowiec, jednostka, cena, data_pobrana) VALUES (:surowiec, :jednostka, :cena, :data_pobrana)");

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
