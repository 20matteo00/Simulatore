<?php
global $db;
if ($_SESSION['role'] === 1) {
    $colspan = 5;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crea_campionato'])) {
        $nome = $_POST['nome'] ?? '';
        $logo = $_POST['logo'] ?? '';
        $colore1 = $_POST['colore1'] ?? '#000000';
        $colore2 = $_POST['colore2'] ?? '#ffffff';
        $colore3 = $_POST['colore3'] ?? '#000000';
        $valore = $_POST['valore'] ?? 0;
        $campionato = $_POST['campionato'] ?? '';
        $user_id = $_SESSION['user_id']; // L'ID dell'utente loggato

        // Spostiamo il file nella cartella dell'utente con il nome scelto
        if (!empty($logo) && !empty($nome) && !empty($campionato)) {
            // Crea un array con i parametri JSON
            $params = json_encode([
                'colore1' => $colore1,
                'colore2' => $colore2,
                'colore3' => $colore3,
                'valore' => $valore
            ]);

            // Query di inserimento dei dati
            $query = "INSERT INTO squadre (nome, logo, params, campionato_id) VALUES (?, ?, ?, ?)";

            // Parametri per la query
            $params_db = ['sssi', $nome, $logo, $params, $campionato];

            // Esegui la query preparata
            $db->executePreparedStatement($query, $params_db);

            $success = SQUADRA_CREATA;
            header("Location: index.php?group=comp&page=squadre");
            exit();
        }
    }

    $query = "SELECT id, nome FROM campionati";
    $campionati = $db->getQueryResult($query);  // Eseguiamo la query e otteniamo i risultati

    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><?php echo CREAZIONE_SQUADRE ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <p class="alert alert-danger text-center"><?= $error ?></p>
                        <?php endif; ?>

                        <?php if (isset($success)): ?>
                            <p class="alert alert-success text-center"><?= $success ?></p>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="row g-3">
                                <!-- Nome della squadra -->
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo NOME ?></label>
                                    <input type="text" class="form-control" name="nome" required>
                                </div>

                                <!-- Logo della squadra -->
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo LOGO ?></label>
                                    <input type="text" class="form-control" name="logo" required>
                                </div>

                                <!-- Campionato -->
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo CAMPIONATO ?></label>
                                    <select class="form-select" name="campionato" required>
                                        <?php
                                        foreach ($campionati as $campionato) {
                                            echo "<option value='{$campionato['id']}'>{$campionato['nome']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Colore 1 della squadra -->
                                <div class="col-md-3">
                                    <label class="form-label"><?php echo COLORE1 ?></label>
                                    <input type="color" class="form-control" name="colore1" value="#000000">
                                </div>

                                <!-- Colore 2 della squadra -->
                                <div class="col-md-3">
                                    <label class="form-label"><?php echo COLORE2 ?></label>
                                    <input type="color" class="form-control" name="colore2" value="#ffffff">
                                </div>

                                <!-- Colore 3 della squadra -->
                                <div class="col-md-3">
                                    <label class="form-label"><?php echo COLORE3 ?></label>
                                    <input type="color" class="form-control" name="colore3" value="#000000">
                                </div>

                                <!-- Valore della squadra -->
                                <div class="col-md-3">
                                    <label class="form-label"><?php echo VALORE ?></label>
                                    <input type="number" class="form-control" name="valore" value="0">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-4"
                                name="crea_campionato"><?php echo CREA_SQUADRA ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
} else {
    $colspan = 4;
}
// Query per ottenere squadre con i dettagli del campionato tramite una JOIN
$query = "
    SELECT 
        squadre.id, 
        squadre.nome AS squadra_nome, 
        squadre.logo, 
        squadre.params, 
        campionati.nome AS campionato_nome
    FROM squadre
    JOIN campionati ON squadre.campionato_id = campionati.id
    ORDER BY squadre.campionato_id ASC, 
            CAST(JSON_UNQUOTE(JSON_EXTRACT(squadre.params, '$.valore')) AS UNSIGNED) DESC, 
            squadre.id ASC
";
$squadre = $db->getQueryResult($query);
?>

<h2 class="mt-5 mb-3 text-center"><?php echo LISTA_CAMPIONATI ?></h2>
<div class="table-responsive">
    <table class="table table-bordered table-striped text-center" id="ordered-table">
        <thead class="table-dark">
            <tr>
                <th class="col-1"><?php echo LOGO ?></th>
                <th class="col-auto"><?php echo NOME ?></th>
                <th class="col-2"><?php echo CAMPIONATO ?></th>
                <th class="col-2"><?php echo VALORE . " (Mln)" ?></th>
                <?php if ($_SESSION['role'] === 1): ?>
                    <th class="col-2"><?php echo AZIONI ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($squadre)): ?>
                <?php foreach ($squadre as $squadra): ?>
                    <?php
                    $params = json_decode($squadra['params'], true);
                    $colore1 = $params['colore1'] ?? '#000000';
                    $colore2 = $params['colore2'] ?? '#ffffff';
                    $colore3 = $params['colore3'] ?? '#000000';
                    ?>
                    <tr id="row-<?= $squadra['id'] ?>">
                        <!-- Colonna Logo -->
                        <td class="text-center align-middle">
                            <img src="<?= htmlspecialchars($squadra['logo']) ?>" alt="Logo" class="rounded-circle myimg">
                        </td>

                        <!-- Colonna Nome -->
                        <td class="fw-bold align-middle">
                            <div style="background-color: <?php echo $colore1 ?>; color: <?php echo $colore2 ?>; border: 5px solid <?php echo $colore3 ?>;"
                                class="rounded-pill p-2">
                                <?= htmlspecialchars($squadra['squadra_nome']) ?>
                            </div>
                        </td>

                        <!-- Colonna Campionato -->
                        <td class="fw-bold align-middle"><?= htmlspecialchars($squadra['campionato_nome']) ?></td>

                        <!-- Colonna Valore -->
                        <td class="align-middle"><?php echo $params['valore']; ?></td>

                        <?php if ($_SESSION['role'] === 1): ?>
                            <!-- Colonna Azione -->
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column">
                                    <a href="index.php?group=utility&page=modifica_squadra&id=<?= $squadra['id'] ?>"
                                        class="btn btn-warning btn-sm mb-2">
                                        <span class="bi-pencil me-1"></span> <?php echo MODIFICA ?>
                                    </a>
                                    <a href="index.php?group=utility&page=elimina_squadra&id=<?= $squadra['id'] ?>"
                                        class="btn btn-danger btn-sm">
                                        <span class="bi-trash me-1"></span> <?php echo ELIMINA ?>
                                    </a>
                                </div>
                            </td>
                        <?php endif; ?>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?php echo $colspan; ?>" class="text-center text-muted"><?php echo NESSUN_CAMPIONATO ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>