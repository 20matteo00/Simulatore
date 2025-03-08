-- Creazione della tabella utenti se non esiste già
CREATE TABLE IF NOT EXISTS `utenti` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,  -- ID autoincrementale
    `username` VARCHAR(50) NOT NULL,        -- Username
    `email` VARCHAR(100) NOT NULL,          -- Email
    `password` VARCHAR(255) NOT NULL,       -- Password
    `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Data
    PRIMARY KEY (`id`)                      -- Definisce la chiave primaria
);

-- Creazione della tabella competizioni con il campo 'data' per la data di creazione se non esiste già
CREATE TABLE IF NOT EXISTS `competizioni` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,            -- ID auto-incrementale per la competizione
    `user_id` INT(11) NOT NULL,                      -- ID dell'utente che crea la competizione (chiave esterna)
    `nome` VARCHAR(255) NOT NULL,                     -- Nome della competizione
    `squadre` JSON NOT NULL,                         -- JSON con i numeri delle squadre
    `params` JSON NOT NULL,                          -- JSON con parametri generali
    `statistiche` JSON NOT NULL,                     -- JSON con statistiche (vittorie, pareggi, sconfitte, ecc.)
    `partite` JSON NOT NULL,                         -- JSON con i dati delle partite
    `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Data di creazione della competizione
    PRIMARY KEY (`id`),                              -- La chiave primaria della tabella
    FOREIGN KEY (`user_id`) REFERENCES `utenti`(`id`) ON DELETE CASCADE -- Relazione con la tabella utenti
);

-- Creazione della tabella campionati
CREATE TABLE IF NOT EXISTS `campionati` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,         -- ID del campionato
    `user_id` INT(11) NOT NULL,                   -- ID dell'utente che crea il campionato (chiave esterna)
    `nome` VARCHAR(255) NOT NULL,                  -- Nome del campionato
    `logo` VARCHAR(255) NOT NULL,                  -- URL del logo del campionato
    `params` JSON NOT NULL,                        -- JSON con parametri generali del campionato
    PRIMARY KEY (`id`),                            -- La chiave primaria della tabella
    FOREIGN KEY (`user_id`) REFERENCES `utenti`(`id`) ON DELETE CASCADE -- Relazione con la tabella utenti
);

-- Creazione della tabella squadre
CREATE TABLE IF NOT EXISTS `squadre` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,         -- ID della squadra
    `user_id` INT(11) NOT NULL,                   -- ID dell'utente che crea la squadra (chiave esterna)
    `nome` VARCHAR(255) NOT NULL,                  -- Nome della squadra
    `logo` VARCHAR(255) NOT NULL,                  -- URL del logo della squadra
    `params` JSON NOT NULL,                        -- JSON con parametri generali della squadra
    `campionato_id` INT(11) NOT NULL,              -- ID del campionato a cui la squadra appartiene (chiave esterna)
    PRIMARY KEY (`id`),                            -- La chiave primaria della tabella
    FOREIGN KEY (`user_id`) REFERENCES `utenti`(`id`) ON DELETE CASCADE,  -- Relazione con la tabella utenti
    FOREIGN KEY (`campionato_id`) REFERENCES `campionati`(`id`) ON DELETE CASCADE  -- Relazione con la tabella campionati
);
