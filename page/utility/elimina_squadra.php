<?php
global $db;
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM squadre WHERE id = $id";
    $db->executeQuery($query);
    $success = SQUADRA_ELIMINATA;
    header("Location: index.php?group=comp&page=squadre");
    exit();
}
?>