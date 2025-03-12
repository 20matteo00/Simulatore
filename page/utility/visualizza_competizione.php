<?php
global $db;
$partite = checkPartiteStatistiche("partite");
$statistiche = checkPartiteStatistiche("statistiche");
if (isset($_POST['blockcomp'])) {
    $blockcomp = $_POST['blockcomp'];
    switch ($blockcomp) {
        case 'calendario':
            include "page/view/calendario.php";
            break;
        case 'classifica':
            include "page/view/classifica.php";
            break;
        case 'tabellone':
            include "page/view/tabellone.php";
            break;
        case 'statistiche':
            include "page/view/statistiche.php";
            break;
        case 'home':
            include "page/view/home.php";
            break;
    }
} else {
    include "page/view/home.php";
}

include "block/competizioni.php";

?>