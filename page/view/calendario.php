<?php

global $db;
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

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
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header text-white bg-primary text-center">
                                        <?= GIORNATA ." ". $giornataIndex++ ?>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($giornata as $match): ?>
                                            <li class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-6 col-sm-4 text-center">
                                                        <strong><?= getSquadraNameById($match['squadra1']) ?></strong>
                                                    </div>
                                                    <div class="col-6 col-sm-4 text-center">
                                                        <strong><?= getSquadraNameById($match['squadra2']) ?></strong>
                                                    </div>
                                                    <div class="col-12 col-sm-4 text-center">
                                                        <?php if ($match['gol1'] === "-" || $match['gol2'] === "-"): ?>
                                                            <div class="d-flex justify-content-center">
                                                                <input type="text" class="form-control form-control-sm text-center"
                                                                    placeholder="0" inputmode="numeric" pattern="[0-9]*" min="0">
                                                                <span class="mx-1">-</span>
                                                                <input type="text" class="form-control form-control-sm text-center"
                                                                    placeholder="0" inputmode="numeric" pattern="[0-9]*" min="0">
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