<?php

require 'config.php';

$surowce = ['złoto', 'gaz ziemny', 'aluminium', 'kakao', 'cukier', 'pallad'];

$stmt = $pdo->prepare("SELECT surowiec, jednostka, cena, data_pobrana FROM historyczne_ceny WHERE surowiec = :surowiec ORDER BY data_pobrana ASC");

$dane = [];

foreach ($surowce as $surowiec) {
    $stmt->execute([':surowiec' => ucfirst($surowiec)]);
    $dane[$surowiec] = $stmt->fetchAll();
}

echo '<h1>Historia Cen Surowców</h1>';

foreach ($dane as $surowiec => $rejestry) {
    echo '<h2>' . ucfirst($surowiec) . '</h2>';
    
    // Dane do wykrsu
    $labels = [];
    $ceny = [];
    
    foreach ($rejestry as $rekord) {
        $labels[] = date('Y-m-d H:i', strtotime($rekord['data_pobrana']));
        $ceny[] = $rekord['cena'];
    }
    
    $jednostka = (!empty($rejestry)) ? $rejestry[0]['jednostka'] : '';
    
    // Tabela HTML
    echo '<table border="1" cellpadding="5" cellspacing="0">';
    echo '<tr><th>Data i Godzina</th><th>Jednostka</th><th>Cena</th></tr>';
    
    foreach ($rejestry as $rekord) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($rekord['data_pobrana']) . '</td>';
        echo '<td>' . htmlspecialchars($rekord['jednostka']) . '</td>';
        echo '<td>' . htmlspecialchars($rekord['cena']) . '</td>';
        echo '</tr>';
    }
    
    echo '</table><br>';
    
    // Wykres
    echo '<canvas id="chart_' . $surowiec . '" width="800" height="400"></canvas>';
    echo '<script>
        const ctx_' . $surowiec . ' = document.getElementById("chart_' . $surowiec . '").getContext("2d");
        new Chart(ctx_' . $surowiec . ', {
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
    
    echo '<br><hr><br>';
}
?>
