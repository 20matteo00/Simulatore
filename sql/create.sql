-- Tabella utenti con data ultimo accesso
CREATE TABLE IF NOT EXISTS `utenti` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,        -- ID autoincrementale
    `username` VARCHAR(50) NOT NULL,             -- Username
    `email` VARCHAR(100) NOT NULL,               -- Email
    `password` VARCHAR(255) NOT NULL,            -- Password
    `params` JSON NOT NULL,                      -- JSON con parametri generali
    `role` INT NOT NULL DEFAULT 0,               -- INT con il ruolo (0 = utente, 1 = admin)
    `data_creazione` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Data creazione
    `data_ultimo_accesso` DATETIME DEFAULT NULL, -- Data ultimo accesso
    PRIMARY KEY (`id`)                           -- La chiave primaria
);

-- Tabella competizioni con data creazione e data ultimo update
CREATE TABLE IF NOT EXISTS `competizioni` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,            -- ID auto-incrementale
    `user_id` INT(11) NOT NULL,                      -- ID dell'utente che crea la competizione (chiave esterna)
    `nome` VARCHAR(255) NOT NULL,                     -- Nome della competizione
    `squadre` JSON NOT NULL,                         -- JSON con i numeri delle squadre
    `params` JSON NOT NULL,                          -- JSON con parametri generali
    `statistiche` JSON NOT NULL,                     -- JSON con statistiche (vittorie, pareggi, sconfitte, ecc.)
    `partite` JSON NOT NULL,                         -- JSON con i dati delle partite
    `data_creazione` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Data creazione
    PRIMARY KEY (`id`),                              -- La chiave primaria
    FOREIGN KEY (`user_id`) REFERENCES `utenti`(`id`) ON DELETE CASCADE -- Relazione con la tabella utenti
);

-- Tabella campionati con data creazione e data ultimo update
CREATE TABLE IF NOT EXISTS `campionati` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,         -- ID del campionato
    `nome` VARCHAR(255) NOT NULL,                  -- Nome del campionato
    `logo` VARCHAR(255) NOT NULL,                  -- URL del logo del campionato
    `params` JSON NOT NULL,                        -- JSON con parametri generali del campionato
    `data_creazione` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Data creazione
    PRIMARY KEY (`id`)                             -- La chiave primaria
);

-- Tabella squadre con data creazione e data ultimo update
CREATE TABLE IF NOT EXISTS `squadre` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,         -- ID della squadra
    `nome` VARCHAR(255) NOT NULL,                  -- Nome della squadra
    `logo` VARCHAR(255) NOT NULL,                  -- URL del logo della squadra
    `params` JSON NOT NULL,                        -- JSON con parametri generali della squadra
    `campionato_id` INT(11) NOT NULL,              -- ID del campionato a cui la squadra appartiene (chiave esterna)
    `data_creazione` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- Data creazione
    PRIMARY KEY (`id`),                            -- La chiave primaria
    FOREIGN KEY (`campionato_id`) REFERENCES `campionati`(`id`) ON DELETE CASCADE  -- Relazione con la tabella campionati
);
