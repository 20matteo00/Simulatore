<?php
global $db;
if (isset($_GET['id']) && $_SESSION['role'] === 1) {
    $id = $_GET['id'];
    $query = "DELETE FROM competizioni WHERE id = $id";
    $db->executeQuery($query);
    $success = COMPETIZIONE_ELIMINATA;
    header("Location: index.php?group=comp&page=competizioni");
    exit();
}
?>