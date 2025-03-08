<?php
global $db;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invia'])) {
    // Ottieni i dati dal form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica che i campi non siano vuoti
    if (empty($email) || empty($password)) {
        $error = TUTTI_I_CAMPI_OBBLIGATORI;
    } else {
        // Cerca l'utente nel database tramite email
        $query = "SELECT * FROM utenti WHERE email = ?";
        $params = ['s', $email];
        $result = $db->executePreparedStatement($query, $params);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verifica la password usando password_verify
            if (password_verify($password, $user['password'])) {
                // Imposta le variabili di sessione
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['id'] = $user['id'];
                // Se disponibile, puoi salvare anche l'ID dell'utente: $_SESSION['user_id'] = $user['id'];

                $success = LOGIN_AVVENUTO;
                header("Location: index.php?page=home");
                exit();
            } else {
                $error = PASSWORD_ERRATA;
            }
        } else {
            $error = UTENTE_NON_TROVATO;
        }
    }
}
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4><?php echo ACCEDI; ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <p class="alert alert-danger text-center"><?= $error ?></p>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <p class="alert alert-success text-center"><?= $success ?></p>
                    <?php endif; ?>
                    <!-- Inizio form di login -->
                    <form method="POST" action="">
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo EMAIL; ?></label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Inserisci la tua email">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label"><?php echo PASSWORD; ?></label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Inserisci la tua password">
                        </div>
                        <!-- Bottone di invio -->
                        <button type="submit" class="btn btn-primary w-100" name="invia"><?php echo ACCEDI; ?></button>
                    </form>
                    <!-- Fine form di login -->
                </div>
                <div class="card-footer text-center">
                    <p><?php echo NON_HAI_UN_ACCOUNT ?> <a href="index.php?page=registrazione"><?php echo REGISTRATI ?></a></p>
                    <p><?php echo PASSWORD_DIMENTICATA ?> <a href="index.php?page=recupero"><?php echo RECUPERA; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>