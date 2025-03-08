<?php
global $db;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM campionati WHERE id = $id";
    $result = $db->getQueryResult($query);
    $row = $result->fetch_assoc();
    $params = json_decode($row['params'], true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifica_campionato'])) {
    $stato = $_POST['stato'] ?? '';
    $livello = $_POST['livello'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    // Crea un array con i parametri JSON
    $params = json_encode([
        'stato' => $stato,
        'livello' => $livello,
        'tipo' => $tipo
    ]);

    $query = "UPDATE campionati SET params = ? WHERE id = ?";
    // Parametri per la query
    $params_db = ['si', $params, $id];

    // Esegui la query preparata
    $db->executePreparedStatement($query, $params_db);

    $success = CAMPIONATO_MODIFICATO;
    header("Location: index.php?group=comp&page=campionati");
    exit();
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4><?php echo MODIFICA_CAMPIONATO ?></h4>
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
                            <!-- Nome del campionato -->
                            <div class="col-md-6">
                            <label class="form-label"><?php echo NOME ?></label>
                            <input type="text" class="form-control" value="<?= $row['nome'] ?>" disabled>
                            </div>

                            <!-- Logo del campionato -->
                            <div class="col-md-6">
                                <?php if (!empty($row['logo'])): ?>
                                    <div class="mb-2">
                                    <label class="form-label"><?php echo LOGO ?></label>
                                    <img src="<?= htmlspecialchars($row['logo']) ?>" alt="Logo attuale" class="form-control img-thumbnail myimg" width="100">
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Stato del campionato -->
                            <div class="col-md-4">
                            <label class="form-label"><?php echo STATO ?></label>
                            <input type="text" class="form-control" name="stato" value="<?= $params['stato'] ?>">
                            </div>

                            <!-- Livello del campionato -->
                            <div class="col-md-4">
                            <label class="form-label"><?php echo LIVELLO ?></label>
                            <input type="number" class="form-control" name="livello" value="<?= $params['livello'] ?>">
                            </div>

                            <!-- Tipo del campionato -->
                            <div class="col-md-4">
                            <label class="form-label"><?php echo TIPO ?></label>
                            <input type="text" class="form-control" name="tipo" value="<?= $params['tipo'] ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4" name="modifica_campionato"><?php echo MODIFICA_CAMPIONATO ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>