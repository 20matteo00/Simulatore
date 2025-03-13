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


/* COMPETIZIONI */

function generaHome()
{
    global $db;
    $query = "SELECT JSON_UNQUOTE(JSON_EXTRACT(params, '$.tipo')) as tipo, JSON_UNQUOTE(JSON_EXTRACT(params, '$.stato')) as stato FROM competizioni WHERE id = " . $_GET['id'];
    $result = $db->getQueryResult($query);
    $r = $result->fetch_assoc();
    $tipo = $r['tipo'];
    $stato = $r['stato'];
    // Esegui la query per ottenere campionati e squadre
    $query = "
    SELECT 
        c.id AS campionato_id, 
        c.nome AS campionato_nome,
        c.logo AS campionato_logo,
        s.id AS squadra_id,
        s.nome AS squadra_nome,
        s.logo AS squadra_logo
    FROM 
        campionati c
    JOIN 
        competizioni cp ON JSON_UNQUOTE(JSON_EXTRACT(cp.params, '$.tipo')) = '" . $tipo . "'
                      AND JSON_UNQUOTE(JSON_EXTRACT(cp.params, '$.stato')) = '" . $stato . "'
    JOIN 
        squadre s ON s.campionato_id = c.id;
";

    // Supponiamo che $db sia l'oggetto della connessione al database
    return $db->getQueryResult($query);
}

function checkPartiteStatistiche($string)
{
    global $db;
    $query = "SELECT $string from competizioni where id = " . $_GET['id'];
    $result = $db->getQueryResult($query);
    $r = $result->fetch_assoc();
    $var = $r["$string"];
    $var = json_decode($var, true);

    if (empty($var)) {

        $result = generaHome();
        $campionati = [];

        // Raggruppa le squadre per campionato usando direttamente l'id come chiave
        while ($row = $result->fetch_assoc()) {
            $campionato_id = $row['campionato_id'];
            $campionati[$campionato_id]['squadre'][] = $row['squadra_id'];
        }

        // Recupera il JSON esistente dal DB (usando l'id passato in GET)
        $querySelect = "SELECT $string FROM competizioni WHERE id = " . $_GET['id'];
        $resultSelect = $db->getQueryResult($querySelect);
        $rowSelect = $resultSelect->fetch_assoc();
        $existingvar = !empty($rowSelect["$string"]) ? json_decode($rowSelect["$string"], true) : [];

        // Per ogni campionato, genera il calendario e lo aggiunge all'array
        foreach ($campionati as $campionato_id => $campionato) {
            $newCalendar = json_decode(generaPartiteStatistiche($campionato['squadre'], $string), true);
            // Usa direttamente l'id del campionato come chiave (convertito in stringa se necessario)
            $existingvar[(string) $campionato_id] = $newCalendar;
        }

        // Aggiorna il record con il JSON aggiornato contenente tutti i calendari
        $mergedJSON = json_encode($existingvar);
        $queryUpdate = "UPDATE competizioni SET $string = '" . $mergedJSON . "' WHERE id = " . $_GET['id'];
        $db->executeQuery($queryUpdate);

        // Recupera il calendario aggiornato
        $query = "SELECT $string FROM competizioni WHERE id = " . $_GET['id'];
        $result = $db->getQueryResult($query);
        $r = $result->fetch_assoc();
        $var = json_decode($r["$string"], true);
    }

    return $var;
}

function generaPartiteStatistiche($squadre, $var)
{
    if ($var == "partite") {
        shuffle($squadre); // Mescola le squadre
        $n = count($squadre);
        // Se il numero di squadre è dispari, aggiungi un dummy (bye) per facilitare l'abbinamento
        if ($n % 2 != 0) {
            $squadre[] = null;
            $n = count($squadre);
        }

        $giornate = array();
        $rounds = $n - 1; // numero di giornate per il primo turno (andata)
        $teams = $squadre; // copia dell'array

        // Genera il calendario per l'andata
        for ($round = 0; $round < $rounds; $round++) {
            $matches = array();
            $matchNumber = 1;
            // Abbina la prima metà contro la seconda metà
            for ($i = 0; $i < $n / 2; $i++) {
                $home = $teams[$i];
                $away = $teams[$n - 1 - $i];
                // Se una delle due è "bye" (null) salta la partita
                if ($home === null || $away === null) {
                    continue;
                }
                $matches["partita" . $matchNumber] = array(
                    "squadra1" => $home,
                    "squadra2" => $away,
                    "gol1" => "",
                    "gol2" => ""
                );
                $matchNumber++;
            }
            $giornate["giornata" . ($round + 1)] = $matches;

            // Ruota l'array mantenendo fisso il primo elemento
            $temp = $teams[1];
            for ($j = 1; $j < $n - 1; $j++) {
                $teams[$j] = $teams[$j + 1];
            }
            $teams[$n - 1] = $temp;
        }

        // Genera il ritorno invertendo casa e trasferta per ogni partita
        $secondHalf = array();
        $i = 0;
        foreach ($giornate as $roundName => $matches) {
            $matchesReverse = array();
            $matchNumber = 1;
            foreach ($matches as $match) {
                $matchesReverse["partita" . $matchNumber] = array(
                    "squadra1" => $match["squadra2"],
                    "squadra2" => $match["squadra1"],
                    "gol1" => "",
                    "gol2" => ""
                );
                $matchNumber++;
            }
            $secondHalf["giornata" . ($rounds + $i + 1)] = $matchesReverse;
            $i++;
        }

        // Unisci andata e ritorno
        $calendario = array_merge($giornate, $secondHalf);

        return json_encode($calendario);
    } else {
        $n = count($squadre);
        $statistiche = [];
        for ($i = 0; $i < $n; $i++) {
            $statistiche[$squadre[$i]] = array(
                "squadra" => $squadre[$i],
                "VC" => 0,
                "NC" => 0,
                "PC" => 0,
                "GFC" => 0,
                "GSC" => 0,
                "VT" => 0,
                "NT" => 0,
                "PT" => 0,
                "GFT" => 0,
                "GST" => 0
            );
        }
        return json_encode($statistiche);
    }

}

/* DB */

function getCampionatoNameById($id)
{
    global $db;
    $query = "SELECT nome FROM campionati WHERE id = $id";
    $result = $db->getQueryResult($query);
    $r = $result->fetch_assoc();
    return $r['nome'];
}

function getSquadraNameById($id)
{
    global $db;
    $query = "SELECT nome FROM squadre WHERE id = $id";
    $result = $db->getQueryResult($query);
    $r = $result->fetch_assoc();
    return $r['nome'];
}

// FUNZIONE AUSILIARIA: Carica il JSON delle partite dal DB
function getPartiteJSON($compId) {
    global $db;
    $query = "SELECT partite FROM competizioni WHERE id = " . $compId;
    $result = $db->getQueryResult($query);
    $row = $result->fetch_assoc();
    return json_decode($row['partite'], true);
}

// FUNZIONE AUSILIARIA: Salva il JSON aggiornato nel DB
function updatePartiteJSON($compId, $jsonArray) {
    global $db;
    $mergedJSON = json_encode($jsonArray);
    $updateQuery = "UPDATE competizioni SET partite = '" . $mergedJSON . "' WHERE id = " . $compId;
    $db->executeQuery($updateQuery);
}


/* UTILITY */
function abbreviaStringa($stringa)
{
    // Rimuove eventuali spazi in eccesso all'inizio e alla fine
    $stringa = trim($stringa);

    // Se la stringa è vuota, restituisce una stringa vuota
    if (empty($stringa)) {
        return "";
    }

    // Divide la stringa in parole (basato su spazi)
    $parole = preg_split('/\s+/', $stringa);

    if (count($parole) === 1) {
        // Se c'è una sola parola, prendi le prime 3 lettere
        return substr($parole[0], 0, 3);
    } else {
        // Se ci sono almeno due parole, prendi le prime 2 lettere della prima e la prima lettera della seconda
        return substr($parole[0], 0, 2) . substr($parole[1], 0, 1);
    }
}

?>