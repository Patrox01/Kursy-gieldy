<?php
// shared_price_history.php

// Włącz wyświetlanie błędów (do debugowania)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Załaduj pliki konfiguracyjne do połączeń z bazami danych
require 'config.php';  // Baza 1
require 'config2.php'; // Baza 2
require 'config3.php'; // Baza 3

// Pobranie wszystkich surowców
$materials = ['złoto', 'gaz ziemny', 'aluminium', 'kakao', 'cukier', 'pallad'];

// Domyślne wartości dla surowca i zakresu dat
$chosenMaterial = $_GET['surowiec'] ?? 'złoto';
$dateFrom = $_GET['data_od'] ?? '2023-01-01';
$dateTo = $_GET['data_do'] ?? date('Y-m-d');

// Funkcja do pobierania danych z danej bazy danych
function getData($pdo, $chosenMaterial, $dateFrom, $dateTo) {
    $stmt = $pdo->prepare("
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
    return $stmt->fetchAll();
}

// Pobierz dane z trzech baz danych
$data1 = getData($pdo, $chosenMaterial, $dateFrom, $dateTo);  // Dane z bazy 1
$data2 = getData($pdo2, $chosenMaterial, $dateFrom, $dateTo); // Dane z bazy 2
$data3 = getData($pdo3, $chosenMaterial, $dateFrom, $dateTo); // Dane z bazy 3

// Przygotowanie danych do wykresu
$labels = [];  // Etykiety (daty) będą wspólne dla wszystkich baz
$prices1 = []; // Ceny z bazy 1
$prices2 = []; // Ceny z bazy 2
$prices3 = []; // Ceny z bazy 3

// Wypełnij dane dla pierwszej bazy
foreach ($data1 as $record) {
    $labels[] = date('Y-m-d H:i', strtotime($record['data_pobrana']));
    $prices1[] = $record['cena'];
}

// Wypełnij dane dla drugiej bazy (dodaj puste pola do etykiet, jeśli potrzebne)
foreach ($data2 as $index => $record) {
    if (!isset($labels[$index])) {
        $labels[] = date('Y-m-d H:i', strtotime($record['data_pobrana']));
    }
    $prices2[] = $record['cena'];
}

// Wypełnij dane dla trzeciej bazy (dodaj puste pola do etykiet, jeśli potrzebne)
foreach ($data3 as $index => $record) {
    if (!isset($labels[$index])) {
        $labels[] = date('Y-m-d H:i', strtotime($record['data_pobrana']));
    }
    $prices3[] = $record['cena'];
}

// Unikalna jednostka (przyjmujemy, że jest taka sama dla wszystkich baz)
$jednostka = (!empty($data1)) ? $data1[0]['jednostka'] : '';

// Formularz wyboru zakresu dat i surowca
echo '<h1>Historia Cen Surowców z Trzech Baz Danych</h1>';
echo '<form method="GET" action="shared_price_history.php">';
echo '<label for="surowiec">Wybierz surowiec: </label>';
echo '<select name="surowiec" id="surowiec">';
foreach ($materials as $material) {
    $selected = ($chosenMaterial == $material) ? 'selected' : '';
    echo '<option value="' . htmlspecialchars($material) . '" ' . $selected . '>' . ucfirst($material) . '</option>';
}
echo '</select><br><br>';

echo '<label for="data_od">Data od: </label>';
echo '<input type="date" name="data_od" id="data_od" value="' . htmlspecialchars($dateFrom) . '"><br><br>';

echo '<label for="data_do">Data do: </label>';
echo '<input type="date" name="data_do" id="data_do" value="' . htmlspecialchars($dateTo) . '"><br><br>';

echo '<button type="submit">Pokaż</button>';
echo '</form>';
echo '<br>';

// Wykres
if (empty($data1) && empty($data2) && empty($data3)) {
    echo '<p>Brak danych dla wybranego surowca lub zakresu dat.</p>';
} else {
    echo '<canvas id="chart_' . htmlspecialchars($chosenMaterial) . '" width="800" height="400"></canvas>';
    echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
    echo '<script>
        const ctx_' . htmlspecialchars($chosenMaterial) . ' = document.getElementById("chart_' . htmlspecialchars($chosenMaterial) . '").getContext("2d");
        new Chart(ctx_' . htmlspecialchars($chosenMaterial) . ', {
            type: "line",
            data: {
                labels: ' . json_encode($labels) . ',
                datasets: [
                    {
                        label: "Cena z Bazy 1 (' . htmlspecialchars($jednostka) . ')",
                        data: ' . json_encode($prices1) . ',
                        borderColor: "rgba(75, 192, 192, 1)",
                        backgroundColor: "rgba(75, 192, 192, 0.2)",
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: "Cena z Bazy 2 (' . htmlspecialchars($jednostka) . ')",
                        data: ' . json_encode($prices2) . ',
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255, 99, 132, 0.2)",
                        fill: true,
                        tension: 0.1
                    },
                    {
                        label: "Cena z Bazy 3 (' . htmlspecialchars($jednostka) . ')",
                        data: ' . json_encode($prices3) . ',
                        borderColor: "rgba(54, 162, 235, 1)",
                        backgroundColor: "rgba(54, 162, 235, 0.2)",
                        fill: true,
                        tension: 0.1
                    }
                ]
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
