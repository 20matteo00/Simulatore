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
           
            <?php endforeach; ?>
        </div>
    </div>
</div>