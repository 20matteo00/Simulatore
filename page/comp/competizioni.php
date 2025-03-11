<?php
global $db;
$user_id = $_SESSION['user_id'];
if ($_SESSION['role'] === 1) {
    $colspan = 3;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crea_competizione'])) {
        $exp = $_POST['stato'] ?? '';
        $exp = explode("-", $exp);
        $stato = $exp[0];
        $tipo = $exp[1];
        $statistiche = '{}';
        $partite = '{}';
        // Spostiamo il file nella cartella dell'utente con il nome scelto
        if (!empty($stato) && !empty($tipo)) {

            $checkQuery = "
                SELECT DISTINCT CONCAT(JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')), '-', JSON_UNQUOTE(JSON_EXTRACT(params, '$.tipo'))) AS coppia
                FROM competizioni
                WHERE JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')) = '$stato' AND JSON_UNQUOTE(JSON_EXTRACT(params, '$.tipo')) = '$tipo';
            ";
            $check = $db->getQueryResult($checkQuery)->fetch_assoc();
            if ($check) {
                $error = CAMPIONATO_GIA_CREATO;
            } else {
                // Crea un array con i parametri JSON
                $params = json_encode([
                    'stato' => $stato,
                    'tipo' => $tipo
                ]);

                // Query di inserimento dei dati
                $query = "INSERT INTO competizioni (user_id, params, statistiche, partite) VALUES (?, ?, ?, ?)";

                // Parametri per la query
                $params_db = ['isss', $user_id, $params, $statistiche, $partite];

                // Esegui la query preparata
                $db->executePreparedStatement($query, $params_db);

                $success = CAMPIONATO_CREATO;
                header("Location: index.php?group=comp&page=competizioni");
                exit();
            }
        }
    }
    $query = "
    SELECT DISTINCT CONCAT(JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')), '-', JSON_UNQUOTE(JSON_EXTRACT(params, '$.tipo'))) AS coppia
    FROM campionati;
";
    $result = $db->getQueryResult($query); // Esegui la query

    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><?php echo CREAZIONE_COMPETIZIONE ?></h4>
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
                                <!-- Stato del campionato -->
                                <div class="col-12">
                                    <label class="form-label"><?php echo STATO . ": " . TIPO ?></label>
                                    <select class="form-control" name="stato" required>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            $exp = explode("-", $row['coppia']);
                                            $tipo = $exp[1];
                                            $stato = $exp[0];
                                            echo "<option value=" . $row['coppia'] . ">$stato: $tipo</option>";
                                        }

                                        ?>
                                    </select>
                                </div>


                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-4"
                                name="crea_competizione"><?php echo CREA_COMPETIZIONE ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
} else {
    $colspan = 2;
}
$query = "SELECT * FROM competizioni WHERE user_id = $user_id ORDER BY JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')) ASC, id DESC";
$competizioni = $db->getQueryResult($query);
?>
<h2 class="mt-5 mb-3 text-center"><?php echo LISTA_COMPETIZIONI ?></h2>
<div class="table-responsive">
    <table class="table table-bordered table-striped text-center" id="ordered-table">
        <thead class="table-dark">
            <tr>
                <th class="col-auto"><?php echo TIPO ?></th>
                <th class="col-auto"><?php echo STATO ?></th>
                <?php if ($_SESSION['role'] === 1): ?>
                    <th class="col-2"><?php echo AZIONI ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($competizioni)): ?>
                <?php foreach ($competizioni as $competizione): ?>
                    <?php
                    $params = json_decode($competizione['params'], true);
                    $query2 = "SELECT COUNT(*) AS partecipanti FROM squadre WHERE campionato_id = " . $competizione['id'];
                    $partecipanti = $db->getQueryResult($query2)->fetch_assoc();
                    ?>
                    <tr id="row-<?= $competizione['id'] ?>">
                        <!-- Colonna Tipo -->
                        <td class="text-center align-middle"><?= $params['tipo'] ?></td>

                        <!-- Colonna Stato -->
                        <td class="text-center align-middle"><?= $params['stato'] ?></td>

                        <?php if ($_SESSION['role'] === 1): ?>
                            <!-- Colonna Azione -->
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column">
                                    <a href="index.php?group=utility&page=visualizza_competizione&id=<?= $competizione['id'] ?>"
                                        class="btn btn-success btn-sm mb-2">
                                        <span class="bi-eye me-1"></span> <?php echo VISUALIZZA ?>
                                    </a>
                                    <a href="index.php?group=utility&page=elimina_competizione&id=<?= $competizione['id'] ?>"
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
                    <td colspan="<?php echo $colspan ?>" class="text-center text-muted"><?php echo NESSUNA_COMPETIZIONE ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>