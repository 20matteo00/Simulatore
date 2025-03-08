<?php
session_destroy(); // Elimina la sessione
header("Location: index.php?page=home"); // Reindirizza alla home o alla pagina di login
exit();
?>