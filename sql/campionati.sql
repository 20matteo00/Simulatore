-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              8.0.30 - MySQL Community Server - GPL
-- S.O. server:                  Win64
-- HeidiSQL Versione:            12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dump dei dati della tabella sim.campionati: ~5 rows (circa)
INSERT INTO `campionati` (`id`, `nome`, `logo`, `params`, `data_creazione`) VALUES
	(1, 'Serie 1', 'images/Italia/Campionati/1.png', '{"tipo": "Campionato", "stato": "Italia", "livello": "1"}', '2025-03-11 08:57:36'),
	(2, 'Serie 2', 'images/Italia/Campionati/2.png', '{"tipo": "Campionato", "stato": "Italia", "livello": "2"}', '2025-03-11 09:17:57'),
	(3, 'Serie 3', 'images/Italia/Campionati/3.png', '{"tipo": "Campionato", "stato": "Italia", "livello": "3"}', '2025-03-11 09:18:13'),
	(4, 'Serie 4', 'images/Italia/Campionati/4.png', '{"tipo": "Campionato", "stato": "Italia", "livello": "4"}', '2025-03-11 09:18:39'),
	(5, 'Serie 5', 'images/Italia/Campionati/5.png', '{"tipo": "Campionato", "stato": "Italia", "livello": "5"}', '2025-03-11 09:18:58');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
