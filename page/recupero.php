<?php
global $db;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['verifica'])) {
        // Step 1: Verifica username ed email
        $username = $_POST['username'];
        $email = $_POST['email'];

        if (empty($username) || empty($email)) {
            $error = TUTTI_I_CAMPI_OBBLIGATORI;
        } else {
            $query = "SELECT * FROM utenti WHERE username = ? AND email = ?";
            $params = ['ss', $username, $email];
            $result = $db->executePreparedStatement($query, $params);

            if ($result->num_rows > 0) {
                $_SESSION['reset_user'] = $username;
                $_SESSION['reset_email'] = $email;
                $showPasswordForm = true; // Mostra il form per la nuova password
            } else {
                $error = UTENTE_NON_TROVATO;
            }
        }
    } elseif (isset($_POST['reset'])) {
        // Step 2: Aggiornamento password
        if (!isset($_SESSION['reset_user']) || !isset($_SESSION['reset_email'])) {
            header("Location: recupero_password.php");
            exit();
        }

        $new_password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if (empty($new_password) || empty($confirm_password)) {
            $error = TUTTI_I_CAMPI_OBBLIGATORI;
        } elseif ($new_password !== $confirm_password) {
            $error = PASSWORD_NON_UGUALI;
        } else {
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE utenti SET password = ? WHERE username = ? AND email = ?";
            $params = ['sss', $hashedPassword, $_SESSION['reset_user'], $_SESSION['reset_email']];
            $db->executePreparedStatement($query, $params);

            unset($_SESSION['reset_user'], $_SESSION['reset_email']);

            $success = PASSWORD_AGGIORNATA_SUCCESSO;
            header("Refresh: 2; URL=index.php?page=login");
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
                    <h4><?php echo RECUPERA_PASSWORD ?></h4>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <p class="alert alert-danger text-center"><?= $error ?></p>
                    <?php endif; ?>

                    <?php if (isset($success)): ?>
                        <p class="alert alert-success text-center"><?= $success ?></p>
                    <?php endif; ?>

                    <?php if (!isset($showPasswordForm)): ?>
                        <!-- Form verifica username ed email -->
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label"><?php echo NOME_UTENTE ?></label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo EMAIL ?></label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" name="verifica"><?php echo VERIFICA ?></button>
                        </form>
                    <?php else: ?>
                        <!-- Form inserimento nuova password -->
                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label"><?php echo NUOVA_PASSWORD ?></label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><?php echo CONFERMA_PASSWORD ?></label>
                                <input type="password" class="form-control" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100" name="reset"><?php echo AGGIORNA_PASSWORD ?></button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
