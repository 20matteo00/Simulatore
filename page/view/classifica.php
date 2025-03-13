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
            <h1 class="text-center mb-4"><?= CLASSIFICA ?></h1>
            <?php foreach ($statistiche as $campionatoId => $stat): ?>
                <section class="mb-5">
                    <h2 class="text-center fw-bold"><?= getCampionatoNameById($campionatoId) ?></h2>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header text-white bg-primary text-center">
                                    <?= CLASSIFICA ?>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th rowspan="2" class="text-center">#</th>
                                                    <th rowspan="2" class="text-center"><?php echo SQUADRA ?></th>
                                                    <th colspan="5" class="text-center"><?php echo CASA ?></th>
                                                    <th colspan="5" class="text-center"><?php echo TRASFERTA ?></th>
                                                </tr>
                                                <tr>
                                                    <th><?php echo VC ?></th>
                                                    <th><?php echo NC ?></th>
                                                    <th><?php echo PC ?></th>
                                                    <th><?php echo GFC ?></th>
                                                    <th><?php echo GSC ?></th>
                                                    <th><?php echo VT ?></th>
                                                    <th><?php echo NT ?></th>
                                                    <th><?php echo PT ?></th>
                                                    <th><?php echo GFT ?></th>
                                                    <th><?php echo GST ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $j = 1; ?>
                                                <?php foreach ($stat as $squadra): ?>
                                                    <tr>
                                                        <td><?php echo $j++; ?></td>
                                                        <td><?php echo getSquadraNameById($squadra['squadra']); ?></td>
                                                        <td><?php echo $squadra['VC']; ?></td>
                                                        <td><?php echo $squadra['NC']; ?></td>
                                                        <td><?php echo $squadra['PC']; ?></td>
                                                        <td><?php echo $squadra['GFC']; ?></td>
                                                        <td><?php echo $squadra['GSC']; ?></td>
                                                        <td><?php echo $squadra['VT']; ?></td>
                                                        <td><?php echo $squadra['NT']; ?></td>
                                                        <td><?php echo $squadra['PT']; ?></td>
                                                        <td><?php echo $squadra['GFT']; ?></td>
                                                        <td><?php echo $squadra['GST']; ?></td>
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