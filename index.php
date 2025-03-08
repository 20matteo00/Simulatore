<?php
// Includi il file di connessione al database
include('config.php');
include('helper.php');
session_start();
global $db, $lang;
$db = new Database();
$conn = $db->getConnection();
checkCreateTable($conn);
$lang = "ita";
if (isset($_POST['lingua'])) {
    $lang = $_POST['lingua'];
}
include('language/' . $lang . '.php');  // Concatenazione della variabile con il nome del file
$page = "home";
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$pageFile = 'page/' . $page . '.php';
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo NOMESITO; ?></title>
    <!-- STILI -->
    <link rel="stylesheet" href="css/bootstrap.css">
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