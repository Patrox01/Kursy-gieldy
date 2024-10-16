<?php

require 'config.php';

$url = "https://notowania.pb.pl/commodities/";

$dom = new DOMDocument();
@$dom->loadHTMLFile($url);

$xpath = new DOMXPath($dom);

$commodityXpaths = [

    'złoto' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[2]',

    'pszenica' => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[32]/td[2]',

    'aluminium' =>  /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[2]',

    'kakao'     => /*jedn*/ '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[2]',

    'cukier'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[2]',

    'pallad'    => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[2]'
];

$rateXpaths = [

    'złoto' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[14]/td[3]/span',

    'pszenica' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[32]/td[3]/span',

    'aluminium' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[1]/td[3]/span',

    'kakao' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[5]/td[3]/span',

    'cukier' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[31]/td[3]/span',

    'pallad' => '//*[@id="quotes-commodities-quotes-table-box"]/div/div/div[2]/div/table/tbody/tr[20]/td[3]/span'
    
];

$stmt = $pdo->prepare("INSERT INTO historyczne_ceny (surowiec, jednostka, cena, data_pobrana) VALUES (:surowiec, :jednostka, :cena, :data_pobrana)");

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
