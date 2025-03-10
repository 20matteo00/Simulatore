<?php
global $db;
// Array degli stati europei
$european_countries = ["Albania", "Andorra", "Armenia", "Austria", "Azerbaigian", "Bielorussia", "Belgio", "Bosnia ed Erzegovina", "Bulgaria", "Croazia", "Cipro", "Danimarca", "Estonia", "Finlandia", "Francia", "Georgia", "Germania", "Grecia", "Irlanda", "Islanda", "Italia", "Kazakhstan", "Kosovo", "Lettonia", "Liechtenstein", "Lituania", "Lussemburgo", "Malta", "Moldavia", "Monaco", "Montenegro", "Paesi Bassi", "Polonia", "Portogallo", "Regno Unito", "Repubblica Ceca", "Romania", "Russia", "San Marino", "Serbia", "Slovacchia", "Slovenia", "Spagna", "Svezia", "Svizzera", "Turchia", "Ucraina", "Ungheria"];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crea_campionato'])) {
    $nome = $_POST['nome'] ?? '';
    $stato = $_POST['stato'] ?? '';
    $livello = $_POST['livello'] ?? '';
    $tipo = $_POST['tipo'] ?? '';
    $user_id = $_SESSION['user_id']; // L'ID dell'utente loggato

    // Gestione upload del logo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logo_tmp_name = $_FILES['logo']['tmp_name'];
        $logo_name = $_FILES['logo']['name'];

        // Prendi l'estensione del file
        $file_info = pathinfo($logo_name);
        $extension = strtolower($file_info['extension']); // Ottieni l'estensione in minuscolo

        // Assicurati che l'estensione sia valida
        $valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($extension, $valid_extensions)) {
            $error = FORMATO_LOGO_NON_CONSENTITO;
        }

        // Definire la cartella dell'utente
        $user_folder = 'images/' . $user_id;

        // Se la cartella non esiste, la creiamo
        if (!file_exists($user_folder)) {
            mkdir($user_folder, 0777, true); // Creiamo la cartella con permessi di scrittura
        }

        $user_folder = 'images/' . $user_id . '/campionati';

        // Se la cartella non esiste, la creiamo
        if (!file_exists($user_folder)) {
            mkdir($user_folder, 0777, true); // Creiamo la cartella con permessi di scrittura
        }

        // Creare il percorso del logo con il nome del campionato e l'estensione corretta
        $logo_path = $user_folder . '/' . preg_replace('/[^a-zA-Z0-9-_\.]/', '', $nome) . '.' . $extension;

        // Spostiamo il file nella cartella dell'utente con il nome scelto
        if (move_uploaded_file($logo_tmp_name, $logo_path)) {
            $query = "SELECT COUNT(*) as count
                    FROM campionati 
                    WHERE JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')) = '$stato' 
                    AND JSON_UNQUOTE(JSON_EXTRACT(params, '$.livello')) = '$livello';
                    ";
            $result = $db->getQueryResult($query)->fetch_assoc();
            if ($result['count'] > 0) {
                $error = CAMPIONATO_GIA_CREATO;
            } else {

                // Crea un array con i parametri JSON
                $params = json_encode([
                    'stato' => $stato,
                    'livello' => $livello,
                    'tipo' => $tipo
                ]);

                // Query di inserimento dei dati
                $query = "INSERT INTO campionati (user_id, nome, logo, params) VALUES (?, ?, ?, ?)";

                // Parametri per la query
                $params_db = ['isss', $user_id, $nome, $logo_path, $params];

                // Esegui la query preparata
                $db->executePreparedStatement($query, $params_db);

                $success = CAMPIONATO_CREATO;
                header("Location: index.php?group=comp&page=campionati");
                exit();
            }

        } else {
            $error = ERRORE_UPLOAD;
        }
    } else {
        $error = LOGO_NON_VALIDO;
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
                                <input type="file" class="form-control" name="logo" accept="image/*" required>
                            </div>

                            <!-- Stato del campionato -->
                            <div class="col-md-4">
                                <label class="form-label"><?php echo STATO ?></label>
                                <select class="form-control" name="stato">
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
                                <select class="form-control" name="livello" id="livello">
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <!-- Tipo del campionato -->
                            <div class="col-md-4">
                                <label class="form-label"><?php echo TIPO ?></label>
                                <select class="form-control" name="tipo" id="tipo">
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
$query = "SELECT id, nome, logo, params FROM campionati WHERE user_id = " . $_SESSION['user_id'] . " ORDER BY JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')) ASC, JSON_UNQUOTE(JSON_EXTRACT(params, '$.livello')) ASC, id ASC";
$campionati = $db->getQueryResult($query);
?>
<h2 class="mt-5 mb-3 text-center"><?php echo LISTA_CAMPIONATI ?></h2>
<div class="table-responsive">
    <table class="table table-bordered table-striped text-center" id="ordered-table">
        <thead class="table-dark">
            <tr>
                <th class="col-1"><?php echo LOGO ?></th>
                <th class="col-2"><?php echo NOME ?></th>
                <th class="col-2"><?php echo TIPO ?></th>
                <th class="col-2"><?php echo STATO ?></th>
                <th class="col-2"><?php echo LIVELLO ?></th>
                <th class="col-3"><?php echo AZIONI ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($campionati)): ?>
                <?php foreach ($campionati as $campionato): ?>
                    <?php
                    $params = json_decode($campionato['params'], true);
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

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted"><?php echo NESSUN_CAMPIONATO ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>