<?php // helper.php
// Definisci le variabili globali per il file di creazione tabelle, log, e cache
global $sql_create, $cache_checkcreate, $log_create, $log_error, $log_images;

// Imposta i valori delle variabili
$sql_create = "sql/create.sql"; // File di creazione tabelle
$cache_checkcreate = 'cache/checkcreate.txt'; // File di cache per controllare la creazione delle tabelle
$log_create = 'log/create.txt'; // File di log per la creazione delle tabelle
$log_error = 'log/error.txt'; //File di log di errori generico
$log_images = 'log/images.txt'; //File di log per la gestione delle immagini

// Funzione per controllare e creare la tabella, e registrare la creazione nel file di cache e nel log
function checkCreateTable($conn)
{
    global $sql_create, $cache_checkcreate, $log_create; // Accedi alle variabili globali

    // Controlla se il file di cache esiste
    if (file_exists($cache_checkcreate)) {
        // Se il file di cache esiste, significa che le tabelle sono già state create
        //logMessage($log_create, "Le tabelle sono già state create. Niente da fare.");
        return;
    }

    // Leggi il contenuto del file SQL
    $sql = file_get_contents($sql_create);

    // Esegui il contenuto come query SQL
    if ($conn->multi_query($sql)) {
        // Se la query è stata eseguita correttamente, crea il file di cache
        logMessage($log_create, "File SQL eseguito correttamente. Le tabelle sono state create.");

        // Crea il file di cache e scrivi un messaggio di conferma
        file_put_contents($cache_checkcreate, "Le tabelle sono state create con successo.");
    } else {
        // In caso di errore, scrivi nel log
        logMessage($log_create, "Errore nell'esecuzione del file SQL: " . $conn->error);
    }
}

function checkImages()
{
    global $db, $log_images;

    // Query unica per recuperare i loghi sia dalla tabella squadre che dalla tabella campionati
    $query = "
        SELECT user_id, logo, 'squadra' AS tipo FROM squadre
        UNION ALL
        SELECT user_id, logo, 'campionato' AS tipo FROM campionati
    ";
    $loghi = $db->getQueryResult($query);

    // Array per memorizzare i loghi in uso
    $loghi_in_uso = [];

    // Aggiungi tutti i loghi in uso all'array (correggi il percorso)
    foreach ($loghi as $logo) {
        $user_id = $logo['user_id'];
        $tipo = $logo['tipo'];
        $logo_file = $logo['logo'];

        // Crea il percorso corretto, senza duplicazioni
        $loghi_in_uso[] = "$logo_file";
    }

    // Recupera tutti i file immagine dal filesystem (sia da "squadre" che da "campionati")
    $percorso_base = "images";  // Base per i percorsi

    // Recupera i file immagine dal filesystem (sia da "squadre" che da "campionati")
    foreach (['squadre', 'campionati'] as $tipo) {
        // Cerca in tutte le cartelle degli utenti
        $percorso_loghi = $percorso_base . "/*/$tipo";

        // Recupera tutti i file immagine dal filesystem
        $immagini_files = glob($percorso_loghi . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        foreach ($immagini_files as $immagine) {
            // Verifica se il file immagine è in uso (deve essere presente nell'array $loghi_in_uso)
            if (!in_array($immagine, $loghi_in_uso)) {
                // Se non è in uso, elimina il file
                if (file_exists($immagine)) {
                    unlink($immagine);  // Elimina il file
                    logMessage($log_images, "File immagine eliminato: $immagine");
                }
            }
        }
    }
}

// Funzione per scrivere nel file di log
function logMessage($log_file, $message)
{
    // Ottieni la data e ora correnti
    $dateTime = date('Y-m-d H:i:s');

    // Scrivi il messaggio nel file di log con la data e ora
    file_put_contents($log_file, "[$dateTime] - $message\n", FILE_APPEND);
}

function checkPage($page, $pageFile)
{
    global $log_error;
    if ($page != "home") {
        if (file_exists($pageFile)) {
            include($pageFile);
        } else {
            logMessage($log_error, "Errore: Il file '$pageFile' non esiste.");
        }
    }
}

?>