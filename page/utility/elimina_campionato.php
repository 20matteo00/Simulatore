<?php
global $db;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM campionati WHERE id = $id";
    $db->executeQuery($query);
    $success = CAMPIONATO_ELIMINATO;
    header("Location: index.php?group=comp&page=campionati");
    exit();
}
?>