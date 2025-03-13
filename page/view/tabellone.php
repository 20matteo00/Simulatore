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
            <h1 class="text-center mb-4"><?= TABELLONE ?></h1>
            <?php foreach ($statistiche as $campionatoId => $stat): ?>
                <section class="mb-5">
                    <h2 class="text-center fw-bold"><?= getCampionatoNameById($campionatoId) ?></h2>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header text-white bg-primary text-center">
                                    <?= TABELLONE ?>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th><?= SQUADRE ?></th>
                                                    <?php foreach ($stat as $squadra_col): ?>
                                                        <th><?php echo abbreviaStringa(getSquadraNameById($squadra_col['squadra'])); ?>
                                                        </th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($stat as $squadra_row): ?>
                                                    <tr>
                                                        <td><?php echo getSquadraNameById($squadra_row['squadra']); ?></td>
                                                        <?php foreach ($stat as $squadra_col): ?>
                                                            <?php
                                                            $bg = "inline";
                                                            // Se la cella rappresenta la stessa squadra, visualizza un simbolo (es. "X")
                                                            if ($squadra_row['squadra'] === $squadra_col['squadra']) {
                                                                $bg = "black";
                                                            }
                                                            ?>
                                                            <td style="background-color: <?php echo $bg; ?>">
                                                                <?php
                                                                // Se la cella rappresenta la stessa squadra, visualizza un simbolo (es. "X")
                                                                if ($squadra_row['squadra'] !== $squadra_col['squadra']) {
                                                                    // Costruisci la query utilizzando JSON_TABLE per esplodere la struttura JSON
                                                                    $query = "
                                                                            SELECT t.gol1, t.gol2
                                                                            FROM competizioni,
                                                                            JSON_TABLE(partite, '$.*' COLUMNS (
                                                                                campionato JSON PATH '$'
                                                                            )) AS ct,
                                                                            JSON_TABLE(ct.campionato, '$.*' COLUMNS (
                                                                                giornata JSON PATH '$'
                                                                            )) AS gt,
                                                                            JSON_TABLE(gt.giornata, '$.*' COLUMNS (
                                                                                gol1 INT PATH '$.gol1',
                                                                                gol2 INT PATH '$.gol2',
                                                                                squadra1 VARCHAR(10) PATH '$.squadra1',
                                                                                squadra2 VARCHAR(10) PATH '$.squadra2'
                                                                            )) AS t
                                                                            WHERE t.squadra1 = " . $squadra_row['squadra'] . " 
                                                                            AND t.squadra2 = " . $squadra_col['squadra'] . "
                                                                            LIMIT 1;
                                                                        ";
                                                                    $result = $db->getQueryResult($query);
                                                                    $r = $result->fetch_assoc();
                                                                    if ($r) {
                                                                        echo $r['gol1'] . " - " . $r['gol2'];
                                                                    } else {
                                                                        echo "- -";
                                                                    }
                                                                }
                                                                ?>
                                                            </td>


                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="card-footer text-muted text-center">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</div>