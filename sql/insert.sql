-- Inserimento di dati di esempio nella tabella utenti
INSERT INTO `utenti` (`username`, `email`, `password`)
VALUES
('mario_rossi', 'mario.rossi@example.com', MD5('password123')),
('anna_bianchi', 'anna.bianchi@example.com', MD5('1234password')),
('luigi_verdi', 'luigi.verdi@example.com', MD5('luigi2025'));
