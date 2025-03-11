<?php
// Includi il file di connessione al database
include('config.php');
include('helper.php');
session_start();
global $db, $lang;
$db = new Database();
$conn = $db->getConnection();
checkCreateTable($conn);
/* checkImages(); */
// Imposta la lingua scelta dall'utente o usa quella di default
if (isset($_POST['lingua'])) {
    $_SESSION['lang'] = $_POST['lingua'];
}
$lang = $_SESSION['lang'] ?? 'ita';
// Includi il file della lingua
if (!file_exists("language/$lang.php")) {
    $lang = 'ita'; // Se il file non esiste, usa la lingua di default
}
include "language/$lang.php";
$page = "home";
if (!isset($_SESSION['username'])) {
    $group = "login";
} else {
    if (isset($_GET['group'])) {
        $group = $_GET['group'];
    }
}
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$pageFile = 'page/' . $group . "/" . $page . '.php';
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NOMESITO; ?></title>
    <!-- STILI -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/icone/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- SCRIPT -->
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/script.js"></script>
</head>

<body>
    <?php include('block/navbar.php'); ?>
    <div class="container">
        <?php checkPage($page, $pageFile); ?>
    </div>
</body>

</html>