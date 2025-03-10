<?php
global $db;
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verifica se il campionato ha delle squadre associate
    $query_check = "SELECT COUNT(*) as count FROM squadre WHERE campionato_id = $id";
    $stmt_check = $db->getQueryResult($query_check)->fetch_assoc();

    if ($stmt_check['count'] > 0) {
        // Se ci sono squadre associate al campionato, impedisci l'eliminazione
        $error = CAMPIONATO_NON_ELIMINABILE;
    } else {
        // Se non ci sono squadre associate, procedi con l'eliminazione del campionato
        $query = "DELETE FROM campionati WHERE id = $id";
        $db->executeQuery($query);
        $success = CAMPIONATO_ELIMINATO;
    }
    header("Location: index.php?group=comp&page=campionati");
    exit();
}
?>