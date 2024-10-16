<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historyczne ceny</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<div class ="chart_script">
<a href="index.PHP">Powrót</a>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config3.php';

$materials = ['złoto', 'pszenica', 'aluminium', 'kakao', 'cukier', 'pallad'];

$chosenMaterial = $_GET['surowiec'] ?? 'złoto';
$dateFrom = $_GET['data_od'] ?? date('Y-m-d', strtotime('-1 day'));
$dateTo = $_GET['data_do'] ?? date('Y-m-d');

$stmt = $pdo3->prepare("
    SELECT surowiec, jednostka, cena, data_pobrana 
    FROM historyczne_ceny 
    WHERE surowiec = :surowiec 
    AND data_pobrana BETWEEN :data_od AND :data_do 
    ORDER BY data_pobrana ASC
");

$stmt->execute([
    ':surowiec' => ucfirst($chosenMaterial),
    ':data_od' => $dateFrom . ' 00:00:00',
    ':data_do' => $dateTo . ' 23:59:59'
]);

$data = $stmt->fetchAll();

echo '<h1>Historia Cen Surowców</h1>';
echo '<form method="GET" action="index_chart3.php">';
echo '<label for="surowiec">Wybierz surowiec: </label>';
echo '<select name="surowiec" id="surowiec">';
foreach ($materials as $surowiec) {
    $selected = ($chosenMaterial == $surowiec) ? 'selected' : '';
    echo '<option value="' . htmlspecialchars($surowiec) . '" ' . $selected . '>' . ucfirst($surowiec) . '</option>';
}
echo '</select><br><br>';

echo '<label for="data_od">Data od: </label>';
echo '<input type="date" name="data_od" id="data_od" value="' . htmlspecialchars($dateFrom) . '"><br><br>';

echo '<label for="data_do">Data do: </label>';
echo '<input type="date" name="data_do" id="data_do" value="' . htmlspecialchars($dateTo) . '"><br><br>';

echo '<button type="submit">Pokaż</button>';
echo '</form>';

echo '<br>';

if (empty($data)) {
    echo '<p>Brak danych dla wybranego surowca lub zakresu dat.</p>';
} else {
    $labels = [];
    $prices = [];
    foreach ($data as $rekord) {
        $labels[] = date('Y-m-d H:i', strtotime($rekord['data_pobrana']));
        $prices[] = $rekord['cena'];
    }
    
    $jednostka = (!empty($data)) ? $data[0]['jednostka'] : '';

    

    // Wykres
    echo '<canvas id="chart_' . htmlspecialchars($chosenMaterial) . '" width="1000" height="500"></canvas>';
    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
    echo '<script>
        const ctx_' . htmlspecialchars($chosenMaterial) . ' = document.getElementById("chart_' . htmlspecialchars($chosenMaterial) . '").getContext("2d");
        new Chart(ctx_' . htmlspecialchars($chosenMaterial) . ', {
            type: "line",
            data: {
                labels: ' . json_encode($labels) . ',
                datasets: [{
                    label: "Cena (' . htmlspecialchars($jednostka) . ')",
                    data: ' . json_encode($prices) . ',
                    borderColor: "rgba(75, 192, 192, 1)",
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    fill: true,
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: "Data i Godzina"
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: "Cena (' . htmlspecialchars($jednostka) . ')"
                        }
                    }
                }
            }
        });
    </script>';
}
?>
</div>
</body>
</html>
