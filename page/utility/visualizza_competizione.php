<div style="margin-bottom: 60px;">
    <?php
    global $db;
    $partite = checkPartiteStatistiche("partite");
    $statistiche = checkPartiteStatistiche("statistiche");
    // Se 'blockcomp' è presente in GET, lo trasferiamo a POST e lo rimuoviamo dalla URL
    if (isset($_SESSION['blockcomp'])) {
        $_POST['blockcomp'] = $_SESSION['blockcomp'];
    }

    // Quando 'blockcomp' è stato passato via POST, carica la vista corretta
    if (isset($_POST['blockcomp'])) {
        $blockcomp = $_POST['blockcomp'];
        unset($_SESSION['blockcomp']);
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
            default:
                include "page/view/home.php"; // Fallback
                break;
        }
    } else {
        include "page/view/home.php";
    }

    // Carica il blocco delle competizioni
    include "block/competizioni.php";
    ?>
</div>
