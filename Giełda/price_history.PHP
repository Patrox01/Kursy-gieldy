<?php
// historia_cen.php

// Włącz wyświetlanie błędów (do debugowania)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'config.php';

// Pobranie wszystkich surowców
$surowce = ['złoto', 'gaz ziemny', 'aluminium', 'kakao', 'cukier', 'pallad'];

// Domyślne wartości dla surowca i zakresu dat
$wybranySurowiec = $_GET['surowiec'] ?? 'złoto';
$dataOd = $_GET['data_od'] ?? '2023-01-01';
$dataDo = $_GET['data_do'] ?? date('Y-m-d');

// Przygotowanie zapytania SQL z zakresu dat i wybranym surowcem
$stmt = $pdo->prepare("
    SELECT surowiec, jednostka, cena, data_pobrana 
    FROM historyczne_ceny 
    WHERE surowiec = :surowiec 
    AND data_pobrana BETWEEN :data_od AND :data_do 
    ORDER BY data_pobrana ASC
");

// Wykonanie zapytania SQL
$stmt->execute([
    ':surowiec' => ucfirst($wybranySurowiec),
    ':data_od' => $dataOd . ' 00:00:00',
    ':data_do' => $dataDo . ' 23:59:59'
]);

$dane = $stmt->fetchAll();

// Formularz wyboru zakresu dat i surowca
echo '<h1>Historia Cen Surowców</h1>';
echo '<form method="GET" action="price_history.php">';
echo '<label for="surowiec">Wybierz surowiec: </label>';
echo '<select name="surowiec" id="surowiec">';
foreach ($surowce as $surowiec) {
    $selected = ($wybranySurowiec == $surowiec) ? 'selected' : '';
    echo '<option value="' . htmlspecialchars($surowiec) . '" ' . $selected . '>' . ucfirst($surowiec) . '</option>';
}
echo '</select><br><br>';

echo '<label for="data_od">Data od: </label>';
echo '<input type="date" name="data_od" id="data_od" value="' . htmlspecialchars($dataOd) . '"><br><br>';

echo '<label for="data_do">Data do: </label>';
echo '<input type="date" name="data_do" id="data_do" value="' . htmlspecialchars($dataDo) . '"><br><br>';

echo '<button type="submit">Pokaż</button>';
echo '</form>';

echo '<br>';

if (empty($dane)) {
    echo '<p>Brak danych dla wybranego surowca lub zakresu dat.</p>';
} else {
    // Przygotowanie danych do wykresu
    $labels = [];
    $ceny = [];
    foreach ($dane as $rekord) {
        $labels[] = date('Y-m-d H:i', strtotime($rekord['data_pobrana']));
        $ceny[] = $rekord['cena'];
    }
    
    // Unikalna jednostka
    $jednostka = (!empty($dane)) ? $dane[0]['jednostka'] : '';

    

    // Wykres
    echo '<canvas id="chart_' . htmlspecialchars($wybranySurowiec) . '" width="800" height="400"></canvas>';
    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
    echo '<script>
        const ctx_' . htmlspecialchars($wybranySurowiec) . ' = document.getElementById("chart_' . htmlspecialchars($wybranySurowiec) . '").getContext("2d");
        new Chart(ctx_' . htmlspecialchars($wybranySurowiec) . ', {
            type: "line",
            data: {
                labels: ' . json_encode($labels) . ',
                datasets: [{
                    label: "Cena (' . htmlspecialchars($jednostka) . ')",
                    data: ' . json_encode($ceny) . ',
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
