<?php
global $db;
if($_SESSION['role'] === 0){
    header("Location: index.php?group=comp&page=squadre");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM squadre WHERE id = $id";
    $result = $db->getQueryResult($query);
    $row = $result->fetch_assoc();
    $params = json_decode($row['params'], true);
    $campionato_selezionato = $row['campionato_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifica_squadra'])) {
    $colore1 = $_POST['colore1'] ?? '#000000';
    $colore2 = $_POST['colore2'] ?? '#ffffff';
    $colore3 = $_POST['colore3'] ?? '#000000';
    $valore = $_POST['valore'] ?? 0;
    $nome = $_POST['nome'] ?? '';
    $logo = $_POST['logo'] ?? '';

    $campionato = $_POST['campionato'] ?? '';
    // Crea un array con i parametri JSON
    $params = json_encode([
        'colore1' => $colore1,
        'colore2' => $colore2,
        'colore3' => $colore3,
        'valore' => $valore
    ]);

    $query = "UPDATE squadre SET nome = ?, logo = ?, params = ?, campionato_id = ? WHERE id = ?";
    // Parametri per la query
    $params_db = ['sssii', $nome, $logo, $params, $campionato, $id];

    // Esegui la query preparata
    $db->executePreparedStatement($query, $params_db);

    $success = SQUADRA_MODIFICATA;
    header("Location: index.php?group=comp&page=squadre");
    exit();
}

$query = "SELECT id, nome, logo, params FROM campionati ORDER BY id ASC";
$campionati = $db->getQueryResult($query);
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4><?php echo MODIFICA_SQUADRA ?></h4>
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
                                <input type="text" class="form-control" name="nome" value="<?= $row['nome'] ?>">
                            </div>

                            <!-- Campionato -->
                            <div class="col-md-4">
                                <label class="form-label"><?php echo CAMPIONATO ?></label>
                                <select class="form-select" name="campionato" required>
                                    <?php
                                    foreach ($campionati as $campionato) {
                                        if ($campionato['id'] == $campionato_selezionato) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                        echo "<option value='{$campionato['id']}' $selected>{$campionato['nome']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Logo della squadra -->
                            <div class="col-md-4">
                                <?php if (!empty($row['logo'])): ?>
                                    <div class="mb-2">
                                        <label class="form-label"><?php echo LOGO ?></label>
                                        <img src="<?= htmlspecialchars($row['logo']) ?>" alt="Logo attuale"
                                            class="form-control img-thumbnail myimg" width="100">
                                    </div>
                                <?php endif; ?>
                                <label class="form-label"><?php echo LOGO ?></label>
                                <input type="text" class="form-control" name="logo" value="<?= $row['logo'] ?>"
                                    required>
                            </div>

                            <!-- Colore 1 della squadra -->
                            <div class="col-md-3">
                                <label class="form-label"><?php echo COLORE1 ?></label>
                                <input type="color" class="form-control" name="colore1"
                                    value="<?= $params['colore1'] ?>">
                            </div>

                            <!-- Colore 2 della squadra -->
                            <div class="col-md-3">
                                <label class="form-label"><?php echo COLORE2 ?></label>
                                <input type="color" class="form-control" name="colore2"
                                    value="<?= $params['colore2'] ?>">
                            </div>

                            <!-- Colore 3 della squadra -->
                            <div class="col-md-3">
                                <label class="form-label"><?php echo COLORE3 ?></label>
                                <input type="color" class="form-control" name="colore3"
                                    value="<?= $params['colore3'] ?>">
                            </div>

                            <!-- Valore della squadra -->
                            <div class="col-md-3">
                                <label class="form-label"><?php echo VALORE ?></label>
                                <input type="number" class="form-control" name="valore"
                                    value="<?= $params['valore'] ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4"
                            name="modifica_squadra"><?php echo MODIFICA_SQUADRA ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>