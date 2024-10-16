<?php
if (isset($_POST['submitData'])) {
    include 'config.php';
    include 'copy&save.php';
    include 'config2.php';
    include 'copy&save2.php';
    include 'config3.php';
    include 'copy&save3.php';

    header('Location: index_shared_chart.php?success=1');
    exit();

}
?>
