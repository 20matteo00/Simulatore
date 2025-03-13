<div style="margin-bottom: 60px;">
    <?php
    global $db;
    $partite = checkPartiteStatistiche("partite");
    $statistiche = checkPartiteStatistiche("statistiche");
    calcolateStatistiche($statistiche, $partite, $_GET['id']);

    // Quando 'blockcomp' è stato passato via POST, carica la vista corretta
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
            default:
                include "page/view/calendario.php"; // Fallback
                break;
        }
    } else {
        include "page/view/calendario.php";
    }

    // Carica il blocco delle competizioni
    include "block/competizioni.php";
    ?>
</div>
