<?php
global $db;

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

$user_id = $_SESSION['user_id'];

// Recupero dati utente
$query = "SELECT username, email, params FROM utenti WHERE id = ?";
$params = ['i', $user_id];
$result = $db->executePreparedStatement($query, $params);
$user = $result->fetch_assoc();

// Decodifica JSON params
$anagrafica = json_decode($user['params'], true) ?: [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invia'])) {
    // Ottieni i dati inviati dal form
    $nome = $_POST['nome'] ?? '';
    $cognome = $_POST['cognome'] ?? '';
    $data_nascita = $_POST['data_nascita'] ?? '';
    $luogo_nascita = $_POST['luogo_nascita'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';

    // Verifica se l'email è già in uso
    $query = "SELECT id FROM utenti WHERE email = ? AND id != ?";
    $params = ['si', $email, $user_id];
    $result = $db->executePreparedStatement($query, $params);

    if ($result->num_rows > 0) {
        // L'email è già in uso
        $error = EMAIL_GIA_REGISTRATA;
    } else {
        // Aggiorna i dati nel database
        $anagrafica = [
            'nome' => $nome,
            'cognome' => $cognome,
            'data_nascita' => $data_nascita,
            'luogo_nascita' => $luogo_nascita,
            'telefono' => $telefono
        ];

        $json_params = json_encode($anagrafica);

        // Aggiorna username ed email
        $query = "UPDATE utenti SET username = ?, email = ?, params = ? WHERE id = ?";
        $params = ['sssi', $username, $email, $json_params, $user_id];
        $db->executePreparedStatement($query, $params);
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $success = DATI_AGGIORNATI;
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4><?php echo PROFILO ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <p class="alert alert-danger text-center"><?= $error ?></p>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <p class="alert alert-success text-center"><?= $success ?></p>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="row g-3">
                            <!-- Username -->
                            <div class="col-md-6">
                                <label class="form-label"><?php echo NOME_UTENTE ?></label>
                                <input type="text" class="form-control" name="username"
                                    value="<?= $_SESSION['username'] ?? '' ?>" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label"><?php echo EMAIL ?></label>
                                <input type="email" class="form-control" name="email"
                                    value="<?= $_SESSION['email'] ?? '' ?>" required>
                            </div>

                            <!-- Nome -->
                            <div class="col-md-6">
                                <label class="form-label"><?php echo NOME ?></label>
                                <input type="text" class="form-control" name="nome"
                                    value="<?= $anagrafica['nome'] ?? '' ?>">
                            </div>

                            <!-- Cognome -->
                            <div class="col-md-6">
                                <label class="form-label"><?php echo COGNOME ?></label>
                                <input type="text" class="form-control" name="cognome"
                                    value="<?= $anagrafica['cognome'] ?? '' ?>">
                            </div>

                            <!-- Data di Nascita -->
                            <div class="col-md-6">
                                <label class="form-label"><?php echo DATA_NASCITA ?></label>
                                <input type="date" class="form-control" name="data_nascita"
                                    value="<?= $anagrafica['data_nascita'] ?? '' ?>">
                            </div>

                            <!-- Luogo di Nascita -->
                            <div class="col-md-6">
                                <label class="form-label"><?php echo LUOGO_NASCITA ?></label>
                                <input type="text" class="form-control" name="luogo_nascita"
                                    value="<?= $anagrafica['luogo_nascita'] ?? '' ?>">
                            </div>

                            <!-- Telefono -->
                            <div class="col-md-6">
                                <label class="form-label"><?php echo TELEFONO ?></label>
                                <input type="tel" class="form-control" name="telefono"
                                    value="<?= $anagrafica['telefono'] ?? '' ?>"
                                    pattern="^\+?[0-9]{1,4}?[ ]?([0-9]{1,4}[ ]?){2,4}$" placeholder="+39 123 4567890">
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4"
                            name="invia"><?php echo AGGIORNA_PROFILO ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>