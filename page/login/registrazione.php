<?php
global $db;
// Funzione per hasheare la password
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invia'])) {
    // Ottieni i dati dal form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Verifica che i campi non siano vuoti
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        $error = TUTTI_I_CAMPI_OBBLIGATORI;
    } elseif ($password != $confirm) {
        $error = PASSWORD_NON_UGUALI;
    } else {
        // Verifica se l'email è già registrata
        $query = "SELECT * FROM utenti WHERE email = ?";
        $params = ['s', $email];  // 's' indica che stiamo passando una stringa
        $result = $db->executePreparedStatement($query, $params);

        if ($result->num_rows > 0) {
            $error = EMAIL_GIA_REGISTRATA;
        } else {
            // Hash della password
            $hashedPassword = hashPassword($password);

            // Salva l'utente nel database
            $query = "INSERT INTO utenti (username, email, password, params) VALUES (?, ?, ?, ?)";
            $params = ['ssss', $username, $email, $hashedPassword, json_encode([
                'nome' => '',
                'cognome' => '',
                'data_nascita' => '',
                'luogo_nascita' => '',
                'telefono' => ''
            ])];
            $db->executePreparedStatement($query, $params);

            $success = REGISTRAZIONE_AVVENUTA;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 0;
            $_SESSION['user_id'] = $db->getQueryResult("SELECT id FROM utenti WHERE email = '" . $_SESSION['email'] . "'")->fetch_assoc()['id'];
            // Reindirizza alla pagina di login
            header("Location: index.php?group=login&page=profile");
            exit();
        }
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4><?php echo REGISTRATI ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <p class="alert alert-danger text-center"><?= $error ?></p>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <p class="alert alert-success text-center"><?= $success ?></p>
                    <?php endif; ?>
                    <!-- Inizio form di registrazione -->
                    <form method="POST" action="">
                        <!-- Nome Utente -->
                        <div class="mb-3">
                            <label for="username" class="form-label"><?php echo NOME_UTENTE ?></label>
                            <input type="text" class="form-control" id="username" name="username" required
                                placeholder="Inserisci il tuo username" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo EMAIL ?></label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Inserisci la tua email" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo PASSWORD ?></label>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Inserisci la tua password" required>
                        </div>

                        <!-- Conferma Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label"><?php echo CONFERMA_PASSWORD ?></label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
                                placeholder="Conferma la tua password" required>
                        </div>

                        <!-- Bottone di invio -->
                        <button type="submit" class="btn btn-primary w-100" name="invia"><?php echo REGISTRATI ?></button>
                    </form>
                    <!-- Fine form di registrazione -->
                </div>
                <div class="card-footer text-center">
                    <p><?php echo HAI_GIA_UN_ACCOUNT ?> <a href="index.php?group=login&page=login"><?php echo ACCEDI ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>