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
        echo "<p class='text-center alert alert-danger my-3'>".TUTTI_I_CAMPI_OBBLIGATORI."</p>";
    } elseif ($password != $confirm) {
        echo "<p class='text-center alert alert-danger my-3'>".PASSWORD_NON_UGUALI."</p>";
    } else {
        // Verifica se l'email è già registrata
        $query = "SELECT * FROM utenti WHERE email = ?";
        $params = ['s', $email];  // 's' indica che stiamo passando una stringa
        $result = $db->executePreparedStatement($query, $params);

        if ($result->num_rows > 0) {
            echo "<p class='text-center alert alert-danger my-3'>".EMAIL_GIA_REGISTRATA."</p>";
        } else {
            // Hash della password
            $hashedPassword = hashPassword($password);

            // Salva l'utente nel database
            $query = "INSERT INTO utenti (username, email, password, params) VALUES (?, ?, ?, ?)";
            $params = ['ssss', $username, $email, $hashedPassword, 0]; // 'sss' indica che stiamo passando 3 stringhe
            $db->executePreparedStatement($query, $params);

            echo "<p class='text-center alert alert-success my-3'>".REGISTRAZIONE_AVVENUTA."</p>";
            $_SESSION['username'] = $username;
            // Reindirizza alla pagina di login
            header("Location: index.php?page=home");
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

                        <!-- Messaggio di errore (in caso di email già registrata o altro) -->
                        <div id="error-message" class="alert alert-danger d-none" role="alert">
                            <!-- Messaggio di errore verrà inserito qui -->
                        </div>

                        <!-- Bottone di invio -->
                        <button type="submit" class="btn btn-primary w-100" name="invia"><?php echo REGISTRATI ?></button>
                    </form>
                    <!-- Fine form di registrazione -->
                </div>
                <div class="card-footer text-center">
                    <p><?php echo HAI_GIA_UN_ACCOUNT ?> <a href="index.php?page=login"><?php echo ACCEDI ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>