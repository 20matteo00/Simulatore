<?php
global $db;
if($_SESSION['role'] === 0){
    header("Location: index.php?group=comp&page=campionati");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM campionati WHERE id = $id";
    $result = $db->getQueryResult($query);
    $row = $result->fetch_assoc();
    $params = json_decode($row['params'], true);
}
// Array degli stati europei
$european_countries = ["Albania", "Andorra", "Armenia", "Austria", "Azerbaigian", "Bielorussia", "Belgio", "Bosnia ed Erzegovina", "Bulgaria", "Croazia", "Cipro", "Danimarca", "Estonia", "Finlandia", "Francia", "Georgia", "Germania", "Grecia", "Irlanda", "Islanda", "Italia", "Kazakhstan", "Kosovo", "Lettonia", "Liechtenstein", "Lituania", "Lussemburgo", "Malta", "Moldavia", "Monaco", "Montenegro", "Paesi Bassi", "Polonia", "Portogallo", "Regno Unito", "Repubblica Ceca", "Romania", "Russia", "San Marino", "Serbia", "Slovacchia", "Slovenia", "Spagna", "Svezia", "Svizzera", "Turchia", "Ucraina", "Ungheria"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifica_campionato'])) {
    $stato = $_POST['stato'] ?? '';
    $livello = $_POST['livello'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $nome = $_POST['nome'] ?? '';
    $logo = $_POST['logo'] ?? '';

    // Crea un array con i parametri JSON
    $params = json_encode([
        'stato' => $stato,
        'livello' => $livello,
        'tipo' => $tipo
    ]);

    $query = "UPDATE campionati SET nome = ?, logo = ?, params = ? WHERE id = ?";
    // Parametri per la query
    $params_db = ['sssi', $nome, $logo, $params, $id];

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
                                <input type="text" class="form-control" name="nome" value="<?= $row['nome'] ?>">
                            </div>

                            <!-- Logo del campionato -->
                            <div class="col-md-6">
                                <?php if (!empty($row['logo'])): ?>
                                    <div class="mb-2">
                                        <label class="form-label"><?php echo LOGO ?></label>
                                        <img src="<?= htmlspecialchars($row['logo']) ?>" alt="Logo attuale"
                                            class="form-control img-thumbnail myimg" width="100">
                                    </div>
                                <?php endif; ?>
                                <label class="form-label"><?php echo LOGO ?></label>
                                <input type="text" class="form-control" name="logo" value="<?= $row['logo'] ?>" required>

                            </div>

                            <!-- Stato del campionato -->
                            <div class="col-md-4">
                                <label class="form-label"><?php echo STATO ?></label>
                                <select class="form-control" name="stato">
                                    <?php
                                    // Impostiamo lo stato selezionato se esiste
                                    $selected_state = isset($params['stato']) ? $params['stato'] : '';

                                    // Ciclo per generare le opzioni
                                    foreach ($european_countries as $country) {
                                        // Imposta l'opzione come selezionata se corrisponde al valore attuale
                                        $selected = ($selected_state === $country) ? 'selected' : '';
                                        echo "<option value=\"$country\" $selected>$country</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Livello del campionato -->
                            <div class="col-md-4">
                                <label class="form-label"><?php echo LIVELLO ?></label>
                                <select class="form-control" name="livello" id="livello">
                                    <?php
                                    // Impostiamo il livello selezionato se esiste
                                    $selected_level = isset($params['livello']) ? $params['livello'] : '';

                                    // Generiamo le opzioni da 1 a 10
                                    for ($i = 1; $i <= 10; $i++) {
                                        $selected = ($selected_level == $i) ? 'selected' : ''; // Aggiungi selected se il valore è uguale
                                        echo "<option value=\"$i\" $selected>$i</option>";
                                    }
                                    ?>
                                </select>
                            </div>


                            <!-- Tipo del campionato -->
                            <div class="col-md-4">
                                <label class="form-label"><?php echo TIPO ?></label>
                                <select class="form-control" name="tipo" id="tipo">
                                    <option value="Campionato" <?php if ($params['tipo'] == "Campionato")
                                        echo "selected"; ?>>Campionato</option>
                                    <option value="Coppa" <?php if ($params['tipo'] == "Coppa")
                                        echo "selected"; ?>>Coppa
                                    </option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4"
                            name="modifica_campionato"><?php echo MODIFICA_CAMPIONATO ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>