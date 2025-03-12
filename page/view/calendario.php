<?php

global $db;
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$query = "SELECT partite from competizioni where id = " . $_GET['id'];
$result = $db->getQueryResult($query);
$r = $result->fetch_assoc();
$partite = $r['partite'];
$partite = json_decode($partite, true);

if (empty($partite)) {

    $result = generaHome();
    $campionati = [];

    // Raggruppa le squadre per campionato usando direttamente l'id come chiave
    while ($row = $result->fetch_assoc()) {
        $campionato_id = $row['campionato_id'];
        $campionati[$campionato_id]['squadre'][] = $row['squadra_id'];
    }

    // Recupera il JSON esistente dal DB (usando l'id passato in GET)
    $querySelect = "SELECT partite FROM competizioni WHERE id = " . $_GET['id'];
    $resultSelect = $db->getQueryResult($querySelect);
    $rowSelect = $resultSelect->fetch_assoc();
    $existingPartite = !empty($rowSelect['partite']) ? json_decode($rowSelect['partite'], true) : [];

    // Per ogni campionato, genera il calendario e lo aggiunge all'array
    foreach ($campionati as $campionato_id => $campionato) {
        $newCalendar = json_decode(generaCalendario($campionato['squadre']), true);
        // Usa direttamente l'id del campionato come chiave (convertito in stringa se necessario)
        $existingPartite[(string) $campionato_id] = $newCalendar;
    }

    // Aggiorna il record con il JSON aggiornato contenente tutti i calendari
    $mergedJSON = json_encode($existingPartite);
    $queryUpdate = "UPDATE competizioni SET partite = '" . $mergedJSON . "' WHERE id = " . $_GET['id'];
    $db->executeQuery($queryUpdate);

    // Recupera il calendario aggiornato
    $query = "SELECT partite FROM competizioni WHERE id = " . $_GET['id'];
    $result = $db->getQueryResult($query);
    $r = $result->fetch_assoc();
    $partite = json_decode($r['partite'], true);

}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1 class="text-center mb-4"><?= CALENDARIO ?></h1>
            <?php foreach ($partite as $campionatoId => $campionato): ?>
                <section class="mb-5">
                    <h2 class="text-center"><?= getCampionatoNameById($campionatoId) ?></h2>
                    <div class="row">
                        <?php $giornataIndex = 1; ?>
                        <?php foreach ($campionato as $giornata): ?>
                            <div class="col-12 col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header text-white bg-primary text-center">
                                        Giornata <?= $giornataIndex++ ?>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($giornata as $match): ?>
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-5 text-right">
                                                        <strong><?= getSquadraNameById($match['squadra1']) ?></strong>
                                                    </div>
                                                    <div class="col-5">
                                                        <strong><?= getSquadraNameById($match['squadra2']) ?></strong>
                                                    </div>
                                                    <div class="col-2 text-center">
                                                        <?php if ($match['gol1'] === "-" || $match['gol2'] === "-"): ?>
                                                            <div class="d-flex justify-content-center">
                                                                <input type="text" class="form-control form-control-sm text-center"
                                                                    placeholder="Gol 1" inputmode="numeric" pattern="[0-9]*" min="0">
                                                                <span class="mx-1">-</span>
                                                                <input type="text" class="form-control form-control-sm text-center"
                                                                    placeholder="Gol 2" inputmode="numeric" pattern="[0-9]*" min="0">
                                                            </div>
                                                        <?php else: ?>
                                                            <?= $match['gol1'] ?> - <?= $match['gol2'] ?>
                                                        <?php endif; ?>
                                                    </div>

                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="card-footer text-muted text-center">
                                        Fine giornata
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</div>