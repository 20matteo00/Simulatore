<?php
ob_start();
global $db;
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$compId = $_GET['id']; // L'ID della competizione
?>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1 class="text-center mb-4"><?= CALENDARIO ?></h1>
            <?php foreach ($partite as $campionatoId => $campionato): ?>
                <section class="mb-5">
                    <h2 class="text-center fw-bold"><?= getCampionatoNameById($campionatoId) ?></h2>
                    <div class="row">
                        <?php $giornataIndex = 1; ?>
                        <?php foreach ($campionato as $giornata): ?>
                            <div class="col-12 col-xl-6 mb-4" id="campionato<?= $campionatoId ?>giornata<?= $giornataIndex ?>">
                                <div class="card shadow-sm">
                                    <div class="card-header text-white bg-primary text-center">
                                        <?= GIORNATA . " " . $giornataIndex ?>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($giornata as $match): ?>
                                            <li class="list-group-item">
                                                <!-- Form singolo per ogni partita -->
                                                <form action="" method="post">
                                                    <div class="row align-items-center">
                                                        <div class="col-3 text-center">
                                                            <strong><?= getSquadraNameById($match['squadra1']) ?></strong>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <strong><?= getSquadraNameById($match['squadra2']) ?></strong>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <?php
                                                            // Se i gol non sono impostati, mostra 0 come default
                                                            $gol1_val = ($match['gol1'] === "") ? "" : $match['gol1'];
                                                            $gol2_val = ($match['gol2'] === "") ? "" : $match['gol2'];
                                                            ?>
                                                            <div class="d-flex justify-content-center">
                                                                <input type="text" class="form-control form-control-sm text-center"
                                                                    inputmode="numeric" pattern="[0-9]*" min="0"
                                                                    name="gol1" value="<?= $gol1_val ?>">
                                                                <span class="mx-1">-</span>
                                                                <input type="text" class="form-control form-control-sm text-center"
                                                                    inputmode="numeric" pattern="[0-9]*" min="0"
                                                                    name="gol2" value="<?= $gol2_val ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-3 text-center">
                                                            <button type="submit" name="invia_partita" class="btn btn-success p-1">
                                                                <span class="bi bi-check"></span>
                                                            </button>
                                                            <button type="submit" name="elimina_partita" class="btn btn-danger p-1">
                                                                <span class="bi bi-x"></span>
                                                            </button>
                                                            <button type="submit" name="simula_partita" class="btn btn-warning p-1">
                                                                <span class="bi bi-gear"></span>
                                                            </button>
                                                        </div>
                                                        <!-- Hidden inputs specifici per questa partita -->
                                                        <input type="hidden" name="comp" value="<?= $compId ?>">
                                                        <input type="hidden" name="campionato" value="<?= $campionatoId ?>">
                                                        <input type="hidden" name="giornata" value="<?= $giornataIndex ?>">
                                                        <input type="hidden" name="squadra1" value="<?= $match['squadra1'] ?>">
                                                        <input type="hidden" name="squadra2" value="<?= $match['squadra2'] ?>">
                                                    </div>
                                                </form>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <!-- Form per le azioni a livello di giornata -->
                                    <div class="card-footer text-muted text-center">
                                        <form action="" method="post">
                                            <input type="hidden" name="comp" value="<?= $compId ?>">
                                            <input type="hidden" name="campionato" value="<?= $campionatoId ?>">
                                            <input type="hidden" name="giornata" value="<?= $giornataIndex ?>">
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-between">
                                                    <button type="submit" name="invia_giornata" class="btn btn-success p-1">
                                                        <span class="bi bi-check"> Invia</span>
                                                    </button>
                                                    <button type="submit" name="elimina_giornata" class="btn btn-danger p-1">
                                                        <span class="bi bi-x"> Elimina</span>
                                                    </button>
                                                    <button type="submit" name="simula_giornata" class="btn btn-warning p-1">
                                                        <span class="bi bi-gear"> Simula</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php $giornataIndex++; ?>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['blockcomp'] = "calendario";
    // Invia partita: aggiorna il punteggio di una singola partita
    if (isset($_POST['invia_partita'])) {
        $campionato = $_POST['campionato'];
        $giornataIndex = $_POST['giornata'];
        $squadra1 = $_POST['squadra1'];
        $squadra2 = $_POST['squadra2'];
        $gol1 = $_POST['gol1'];
        $gol2 = $_POST['gol2'];
        $compId = $_POST['comp'];

        $json = getPartiteJSON($compId);
        $giornataKey = "giornata" . $giornataIndex;

        if (isset($json[$campionato][$giornataKey])) {
            foreach ($json[$campionato][$giornataKey] as $matchKey => $match) {
                if ($match['squadra1'] == $squadra1 && $match['squadra2'] == $squadra2) {
                    $json[$campionato][$giornataKey][$matchKey]['gol1'] = $gol1;
                    $json[$campionato][$giornataKey][$matchKey]['gol2'] = $gol2;
                    break;
                }
            }
            updatePartiteJSON($compId, $json);
        }
        header("Location: index.php?group=utility&page=visualizza_competizione&id=" . $_GET['id'] . "#campionato" . $campionato . "giornata" . $giornataIndex);
        exit;
    }

    // Elimina partita: resetta il punteggio della partita (lo imposta a "-")
    if (isset($_POST['elimina_partita'])) {
        $campionato = $_POST['campionato'];
        $giornataIndex = $_POST['giornata'];
        $squadra1 = $_POST['squadra1'];
        $squadra2 = $_POST['squadra2'];
        $compId = $_POST['comp'];

        $json = getPartiteJSON($compId);
        $giornataKey = "giornata" . $giornataIndex;

        if (isset($json[$campionato][$giornataKey])) {
            foreach ($json[$campionato][$giornataKey] as $matchKey => $match) {
                if ($match['squadra1'] == $squadra1 && $match['squadra2'] == $squadra2) {
                    $json[$campionato][$giornataKey][$matchKey]['gol1'] = "";
                    $json[$campionato][$giornataKey][$matchKey]['gol2'] = "";
                    break;
                }
            }
            updatePartiteJSON($compId, $json);
        }
        header("Location: index.php?group=utility&page=visualizza_competizione&id=" . $_GET['id'] . "#campionato" . $campionato . "giornata" . $giornataIndex);
        exit;
    }
    
}
ob_end_flush();
?>