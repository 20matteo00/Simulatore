<?php
global $db;
if ($_SESSION['role'] === 1) {
    $colspan = 6;

    // Array degli stati europei
    $european_countries = ["Albania", "Andorra", "Armenia", "Austria", "Azerbaigian", "Bielorussia", "Belgio", "Bosnia ed Erzegovina", "Bulgaria", "Croazia", "Cipro", "Danimarca", "Estonia", "Finlandia", "Francia", "Georgia", "Germania", "Grecia", "Irlanda", "Islanda", "Italia", "Kazakhstan", "Kosovo", "Lettonia", "Liechtenstein", "Lituania", "Lussemburgo", "Malta", "Moldavia", "Monaco", "Montenegro", "Paesi Bassi", "Polonia", "Portogallo", "Regno Unito", "Repubblica Ceca", "Romania", "Russia", "San Marino", "Serbia", "Slovacchia", "Slovenia", "Spagna", "Svezia", "Svizzera", "Turchia", "Ucraina", "Ungheria"];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crea_campionato'])) {
        $nome = $_POST['nome'] ?? '';
        $logo = $_POST['logo'] ?? '';
        $stato = $_POST['stato'] ?? '';
        $livello = $_POST['livello'] ?? '';
        $tipo = $_POST['tipo'] ?? '';

        // Spostiamo il file nella cartella dell'utente con il nome scelto
        if (!empty($logo) && !empty($nome) && !empty($stato) && !empty($livello) && !empty($tipo)) {
            // Crea un array con i parametri JSON
            $params = json_encode([
                'stato' => $stato,
                'livello' => $livello,
                'tipo' => $tipo
            ]);

            // Query di inserimento dei dati
            $query = "INSERT INTO campionati (nome, logo, params) VALUES (?, ?, ?)";

            // Parametri per la query
            $params_db = ['sss', $nome, $logo, $params];

            // Esegui la query preparata
            $db->executePreparedStatement($query, $params_db);

            $success = CAMPIONATO_CREATO;
            header("Location: index.php?group=comp&page=campionati");
            exit();
        }
    }
    ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><?php echo CREAZIONE_CAMPIONATO ?></h4>
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
                                    <input type="text" class="form-control" name="nome" required>
                                </div>

                                <!-- Logo del campionato -->
                                <div class="col-md-6">
                                    <label class="form-label"><?php echo LOGO ?></label>
                                    <input type="text" class="form-control" name="logo" required>
                                </div>

                                <!-- Stato del campionato -->
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo STATO ?></label>
                                    <select class="form-control" name="stato" required>
                                        <?php
                                        // Ciclo per generare le opzioni
                                        foreach ($european_countries as $country) {
                                            // Imposta l'opzione come selezionata se corrisponde al valore attuale
                                            $selected = ($selected_state === $country) ? 'selected' : '';
                                            echo "<option value=\"$country\">$country</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Livello del campionato -->
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo LIVELLO ?></label>
                                    <select class="form-control" name="livello" id="livello" required>
                                        <?php for ($i = 1; $i <= 10; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>

                                <!-- Tipo del campionato -->
                                <div class="col-md-4">
                                    <label class="form-label"><?php echo TIPO ?></label>
                                    <select class="form-control" name="tipo" id="tipo" required>
                                        <option value="Campionato">Campionato</option>
                                        <option value="Coppa">Coppa</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-4"
                                name="crea_campionato"><?php echo CREA_CAMPIONATO ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php
} else {
    $colspan = 5;
}
$query = "SELECT id, nome, logo, params FROM campionati ORDER BY JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')) ASC, JSON_UNQUOTE(JSON_EXTRACT(params, '$.livello')) ASC, id ASC";
$campionati = $db->getQueryResult($query);
?>
<h2 class="mt-5 mb-3 text-center"><?php echo LISTA_CAMPIONATI ?></h2>
<div class="table-responsive">
    <table class="table table-bordered table-striped text-center" id="ordered-table">
        <thead class="table-dark">
            <tr>
                <th class="col-1"><?php echo LOGO ?></th>
                <th class="col-auto"><?php echo NOME ?></th>
                <th class="col-1"><?php echo TIPO ?></th>
                <th class="col-1"><?php echo STATO ?></th>
                <th class="col-1"><?php echo LIVELLO ?></th>
                <th class="col-1"><?php echo PARTECIPANTI ?></th>
                <?php if ($_SESSION['role'] === 1): ?>
                    <th class="col-2"><?php echo AZIONI ?></th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($campionati)): ?>
                <?php foreach ($campionati as $campionato): ?>
                    <?php
                    $params = json_decode($campionato['params'], true);
                    $query2 = "SELECT COUNT(*) AS partecipanti FROM squadre WHERE campionato_id = " . $campionato['id'];
                    $partecipanti = $db->getQueryResult($query2)->fetch_assoc();
                    ?>
                    <tr id="row-<?= $campionato['id'] ?>">
                        <!-- Colonna Logo -->
                        <td class="text-center align-middle">
                            <img src="<?= htmlspecialchars($campionato['logo']) ?>" alt="Logo" class="rounded-circle myimg">
                        </td>

                        <!-- Colonna Nome -->
                        <td class="fw-bold align-middle"><?= htmlspecialchars($campionato['nome']) ?></td>

                        <!-- Colonna Tipo -->
                        <td class="text-center align-middle"><?= $params['tipo'] ?></td>

                        <!-- Colonna Stato -->
                        <td class="text-center align-middle"><?= $params['stato'] ?></td>

                        <!-- Colonna Livello -->
                        <td class="text-center align-middle"><?= $params['livello'] ?></td>
                        <td class="text-center align-middle"><?= $partecipanti['partecipanti'] ?></td>
                        <?php if ($_SESSION['role'] === 1): ?>
                            <!-- Colonna Azione -->
                            <td class="text-center align-middle">
                                <div class="d-flex flex-column">
                                    <a href="index.php?group=utility&page=modifica_campionato&id=<?= $campionato['id'] ?>"
                                        class="btn btn-warning btn-sm mb-2">
                                        <span class="bi-pencil me-1"></span> <?php echo MODIFICA ?>
                                    </a>
                                    <a href="index.php?group=utility&page=elimina_campionato&id=<?= $campionato['id'] ?>"
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
                    <td colspan="<?php echo $colspan ?>" class="text-center text-muted"><?php echo NESSUN_CAMPIONATO ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>