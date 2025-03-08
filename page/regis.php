<?php
global $db;
// Funzione per hasheare la password
function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ottieni i dati dal form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Verifica che i campi non siano vuoti
    if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
        echo "Tutti i campi sono obbligatori.";
    } elseif ($password != $confirm) {
        echo "Le password non coincidono.";
    } else {
        // Verifica se l'email è già registrata
        $query = "SELECT * FROM utenti WHERE email = ?";
        $params = ['s', $email];  // 's' indica che stiamo passando una stringa
        $result = $db->executePreparedStatement($query, $params);

        if ($result->num_rows > 0) {
            echo "Email già registrata!";
        } else {
            // Hash della password
            $hashedPassword = hashPassword($password);

            // Salva l'utente nel database
            $query = "INSERT INTO utenti (username, email, password) VALUES (?, ?, ?)";
            $params = ['sss', $username, $email, $hashedPassword]; // 'sss' indica che stiamo passando 3 stringhe
            $db->executePreparedStatement($query, $params);

            echo "Registrazione avvenuta con successo!";
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
                    <h4><?php echo $REGISTRATI; ?></h4>
                </div>
                <div class="card-body">
                    <!-- Inizio form di registrazione -->
                    <form method="POST" action="">
                        <!-- Nome Utente -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required
                                placeholder="Inserisci il tuo username" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Inserisci la tua email" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Inserisci la tua password" required>
                        </div>

                        <!-- Conferma Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Conferma Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required
                                placeholder="Conferma la tua password" required>
                        </div>

                        <!-- Messaggio di errore (in caso di email già registrata o altro) -->
                        <div id="error-message" class="alert alert-danger d-none" role="alert">
                            <!-- Messaggio di errore verrà inserito qui -->
                        </div>

                        <!-- Bottone di invio -->
                        <button type="submit" class="btn btn-primary w-100">Registrati</button>
                    </form>
                    <!-- Fine form di registrazione -->
                </div>
                <div class="card-footer text-center">
                    <p>Hai già un account? <a href="login.php">Accedi</a></p>
                </div>
            </div>
        </div>
    </div>
</div>