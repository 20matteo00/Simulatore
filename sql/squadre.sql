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

-- Dump dei dati della tabella sim.squadre: ~100 rows (circa)
INSERT INTO `squadre` (`id`, `nome`, `logo`, `params`, `campionato_id`, `data_creazione`) VALUES
	(1, 'Inter', 'images/Italia/Squadre/inter.png', '{"valore": "681", "colore1": "#0000ff", "colore2": "#000000", "colore3": "#ffffff"}', 1, '2025-03-11 09:10:39'),
	(2, 'Juventus', 'images/Italia/Squadre/juventus.png', '{"valore": "645", "colore1": "#000000", "colore2": "#ffffff", "colore3": "#ffcc00"}', 1, '2025-03-11 09:10:39'),
	(3, 'Milan', 'images/Italia/Squadre/milan.png', '{"valore": "570", "colore1": "#ff0000", "colore2": "#000000", "colore3": "#ffffff"}', 1, '2025-03-11 09:10:39'),
	(4, 'Atalanta', 'images/Italia/Squadre/atalanta.png', '{"valore": "475", "colore1": "#003a72", "colore2": "#ffffff", "colore3": "#ffff00"}', 1, '2025-03-11 09:10:39'),
	(5, 'Napoli', 'images/Italia/Squadre/napoli.png', '{"valore": "361", "colore1": "#00a1e5", "colore2": "#ffffff", "colore3": "#ff0000"}', 1, '2025-03-11 09:10:39'),
	(6, 'Roma', 'images/Italia/Squadre/roma.png', '{"valore": "284", "colore1": "#f1b300", "colore2": "#ffffff", "colore3": "#ff0000"}', 1, '2025-03-11 09:10:39'),
	(7, 'Lazio', 'images/Italia/Squadre/lazio.png', '{"valore": "282", "colore1": "#0000ff", "colore2": "#ffffff", "colore3": "#f1c40f"}', 1, '2025-03-11 09:10:39'),
	(8, 'Fiorentina', 'images/Italia/Squadre/fiorentina.png', '{"valore": "280", "colore1": "#5d2f8e", "colore2": "#ffffff", "colore3": "#ffcc00"}', 1, '2025-03-11 09:10:39'),
	(9, 'Bologna', 'images/Italia/Squadre/bologna.png', '{"valore": "251", "colore1": "#f3a8b7", "colore2": "#ffffff", "colore3": "#ff0000"}', 1, '2025-03-11 09:10:39'),
	(10, 'Torino', 'images/Italia/Squadre/torino.png', '{"valore": "185", "colore1": "#b73528", "colore2": "#ffffff", "colore3": "#ffcc00"}', 1, '2025-03-11 09:10:39'),
	(11, 'Parma', 'images/Italia/Squadre/parma.png', '{"valore": "150", "colore1": "#3e0a45", "colore2": "#ffffff", "colore3": "#ffcc00"}', 1, '2025-03-11 09:10:39'),
	(12, 'Genoa', 'images/Italia/Squadre/genoa.png', '{"valore": "144", "colore1": "#ff0000", "colore2": "#0000ff", "colore3": "#ffff00"}', 1, '2025-03-11 09:10:39'),
	(13, 'Udinese', 'images/Italia/Squadre/udinese.png', '{"valore": "141", "colore1": "#000000", "colore2": "#ffcc00", "colore3": "#ffffff"}', 1, '2025-03-11 09:10:39'),
	(14, 'Como', 'images/Italia/Squadre/como.png', '{"valore": "137", "colore1": "#003b64", "colore2": "#ffffff", "colore3": "#ffcc00"}', 1, '2025-03-11 09:10:39'),
	(15, 'Monza', 'images/Italia/Squadre/monza.png', '{"valore": "91", "colore1": "#e60000", "colore2": "#ffffff", "colore3": "#ffcc00"}', 1, '2025-03-11 09:10:39'),
	(16, 'Empoli', 'images/Italia/Squadre/empoli.png', '{"valore": "88", "colore1": "#0068a5", "colore2": "#ffffff", "colore3": "#ffcc00"}', 1, '2025-03-11 09:10:39'),
	(17, 'Hellas Verona', 'images/Italia/Squadre/hellas verona.png', '{"valore": "84", "colore1": "#f6a800", "colore2": "#ffffff", "colore3": "#000000"}', 1, '2025-03-11 09:10:39'),
	(18, 'Cagliari', 'images/Italia/Squadre/cagliari.png', '{"valore": "74", "colore1": "#e60000", "colore2": "#ffffff", "colore3": "#004a6d"}', 1, '2025-03-11 09:10:39'),
	(19, 'Lecce', 'images/Italia/Squadre/lecce.png', '{"valore": "73", "colore1": "#d90727", "colore2": "#ffffff", "colore3": "#f1c40f"}', 1, '2025-03-11 09:10:39'),
	(20, 'Venezia', 'images/Italia/Squadre/venezia.png', '{"valore": "66", "colore1": "#004a28", "colore2": "#ffffff", "colore3": "#ffcb45"}', 1, '2025-03-11 09:10:39'),
	(21, 'Sassuolo', 'images/Italia/Squadre/sassuolo.png', '{"valore": "83", "colore1": "#004d00", "colore2": "#ffffff", "colore3": "#ff0000"}', 2, '2025-03-11 09:10:39'),
	(22, 'Palermo', 'images/Italia/Squadre/palermo.png', '{"valore": "53", "colore1": "#9e2a2f", "colore2": "#ffffff", "colore3": "#f5a800"}', 2, '2025-03-11 09:10:39'),
	(23, 'Pisa', 'images/Italia/Squadre/pisa.png', '{"valore": "53", "colore1": "#003b5c", "colore2": "#ffffff", "colore3": "#f5a800"}', 2, '2025-03-11 09:10:39'),
	(24, 'Spezia', 'images/Italia/Squadre/spezia.png', '{"valore": "43", "colore1": "#f1c40f", "colore2": "#000000", "colore3": "#ffffff"}', 2, '2025-03-11 09:10:39'),
	(25, 'Sampdoria', 'images/Italia/Squadre/sampdoria.png', '{"valore": "35", "colore1": "#0066cc", "colore2": "#ffffff", "colore3": "#ffcc00"}', 2, '2025-03-11 09:10:39'),
	(26, 'Cremonese', 'images/Italia/Squadre/cremonese.png', '{"valore": "31", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#c2c2c2"}', 2, '2025-03-11 09:10:39'),
	(27, 'Salernitana', 'images/Italia/Squadre/salernitana.png', '{"valore": "29", "colore1": "#8d1b3d", "colore2": "#ffffff", "colore3": "#000000"}', 2, '2025-03-11 09:10:39'),
	(28, 'Frosinone', 'images/Italia/Squadre/frosinone.png', '{"valore": "25", "colore1": "#e6b800", "colore2": "#003b1e", "colore3": "#ffffff"}', 2, '2025-03-11 09:10:39'),
	(29, 'Cesena', 'images/Italia/Squadre/cesena.png', '{"valore": "23", "colore1": "#d70000", "colore2": "#ffffff", "colore3": "#000000"}', 2, '2025-03-11 09:10:39'),
	(30, 'Brescia', 'images/Italia/Squadre/brescia.png', '{"valore": "20", "colore1": "#0066cc", "colore2": "#ffffff", "colore3": "#f1c40f"}', 2, '2025-03-11 09:10:39'),
	(31, 'Bari', 'images/Italia/Squadre/bari.png', '{"valore": "18", "colore1": "#d90727", "colore2": "#ffffff", "colore3": "#f1c40f"}', 2, '2025-03-11 09:10:39'),
	(32, 'Modena', 'images/Italia/Squadre/modena.png', '{"valore": "18", "colore1": "#ffcc00", "colore2": "#003b6d", "colore3": "#ffffff"}', 2, '2025-03-11 09:10:39'),
	(33, 'Catanzaro', 'images/Italia/Squadre/catanzaro.png', '{"valore": "17", "colore1": "#f5a800", "colore2": "#ffffff", "colore3": "#e60000"}', 2, '2025-03-11 09:10:39'),
	(34, 'Carrarese', 'images/Italia/Squadre/carrarese.png', '{"valore": "15", "colore1": "#005689", "colore2": "#ffffff", "colore3": "#f5a800"}', 2, '2025-03-11 09:10:39'),
	(35, 'Reggiana', 'images/Italia/Squadre/reggiana.png', '{"valore": "14", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f1c40f"}', 2, '2025-03-11 09:10:39'),
	(36, 'Südtirol', 'images/Italia/Squadre/sudtirol.png', '{"valore": "13", "colore1": "#007a3d", "colore2": "#ffffff", "colore3": "#e60000"}', 2, '2025-03-11 09:10:39'),
	(37, 'Cosenza', 'images/Italia/Squadre/cosenza.png', '{"valore": "12", "colore1": "#e60000", "colore2": "#ffffff", "colore3": "#003b1e"}', 2, '2025-03-11 09:10:39'),
	(38, 'Mantova', 'images/Italia/Squadre/mantova.png', '{"valore": "11", "colore1": "#f5a800", "colore2": "#003b6d", "colore3": "#ffffff"}', 2, '2025-03-11 09:10:39'),
	(39, 'Juve Stabia', 'images/Italia/Squadre/juve stabia.png', '{"valore": "11", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 2, '2025-03-11 09:10:39'),
	(40, 'Cittadella', 'images/Italia/Squadre/cittadella.png', '{"valore": "8", "colore1": "#5e4b3c", "colore2": "#ffffff", "colore3": "#ffcc00"}', 2, '2025-03-11 09:10:39'),
	(41, 'Benevento', 'images/Italia/Squadre/benevento.png', '{"valore": "9", "colore1": "#f8c700", "colore2": "#000000", "colore3": "#ffffff"}', 3, '2025-03-11 09:10:39'),
	(42, 'Ternana', 'images/Italia/Squadre/ternana.png', '{"valore": "8", "colore1": "#ce2127", "colore2": "#ffffff", "colore3": "#003f87"}', 3, '2025-03-11 09:10:39'),
	(43, 'Avellino', 'images/Italia/Squadre/avellino.png', '{"valore": "7", "colore1": "#006747", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(44, 'Vicenza', 'images/Italia/Squadre/vicenza.png', '{"valore": "7", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(45, 'Latina', 'images/Italia/Squadre/latina.png', '{"valore": "6", "colore1": "#003f87", "colore2": "#ffffff", "colore3": "#ce2127"}', 3, '2025-03-11 09:10:39'),
	(46, 'Monopoli', 'images/Italia/Squadre/monopoli.png', '{"valore": "6", "colore1": "#005a48", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(47, 'Padova', 'images/Italia/Squadre/padova.png', '{"valore": "6", "colore1": "#ff0000", "colore2": "#ffffff", "colore3": "#0066cc"}', 3, '2025-03-11 09:10:39'),
	(48, 'Trapani', 'images/Italia/Squadre/trapani.png', '{"valore": "6", "colore1": "#d90727", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(49, 'Triestina', 'images/Italia/Squadre/triestina.png', '{"valore": "6", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(50, 'Arezzo', 'images/Italia/Squadre/arezzo.png', '{"valore": "5", "colore1": "#f6a800", "colore2": "#ffffff", "colore3": "#000000"}', 3, '2025-03-11 09:10:39'),
	(51, 'Ascoli', 'images/Italia/Squadre/ascoli.png', '{"valore": "5", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(52, 'Catania', 'images/Italia/Squadre/catania.png', '{"valore": "5", "colore1": "#1f468a", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(53, 'Feralpisalò', 'images/Italia/Squadre/feralpisalo.png', '{"valore": "5", "colore1": "#007a3d", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(54, 'Perugia', 'images/Italia/Squadre/perugia.png', '{"valore": "5", "colore1": "#c00e2e", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(55, 'Pescara', 'images/Italia/Squadre/pescara.png', '{"valore": "5", "colore1": "#0068a5", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(56, 'Rimini', 'images/Italia/Squadre/rimini.png', '{"valore": "5", "colore1": "#ff0000", "colore2": "#ffffff", "colore3": "#0068a5"}', 3, '2025-03-11 09:10:39'),
	(57, 'Virtus Entella', 'images/Italia/Squadre/virtus entella.png', '{"valore": "5", "colore1": "#007a3d", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(58, 'Audace Cerignola', 'images/Italia/Squadre/audace cerignola.png', '{"valore": "4", "colore1": "#007a3d", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(59, 'Campobasso', 'images/Italia/Squadre/campobasso.png', '{"valore": "4", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(60, 'Casertana', 'images/Italia/Squadre/casertana.png', '{"valore": "4", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(61, 'Crotone', 'images/Italia/Squadre/crotone.png', '{"valore": "4", "colore1": "#0e4d92", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(62, 'Foggia', 'images/Italia/Squadre/foggia.png', '{"valore": "4", "colore1": "#e60000", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(63, 'Giugliano', 'images/Italia/Squadre/giugliano.png', '{"valore": "4", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(64, 'Gubbio', 'images/Italia/Squadre/gubbio.png', '{"valore": "4", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(65, 'Novara', 'images/Italia/Squadre/novara.png', '{"valore": "4", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(66, 'SPAL', 'images/Italia/Squadre/spal.png', '{"valore": "4", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(67, 'Torres', 'images/Italia/Squadre/torres.png', '{"valore": "4", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(68, 'Trento', 'images/Italia/Squadre/trento.png', '{"valore": "4", "colore1": "#ffcc00", "colore2": "#0066cc", "colore3": "#ffffff"}', 3, '2025-03-11 09:10:39'),
	(69, 'AlbinoLeffe', 'images/Italia/Squadre/albinoleffe.png', '{"valore": "3", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(70, 'Alcione Milano', 'images/Italia/Squadre/alcione milano.png', '{"valore": "3", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(71, 'Altamura', 'images/Italia/Squadre/altamura.png', '{"valore": "3", "colore1": "#e60000", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(72, 'Arzignano', 'images/Italia/Squadre/arzignano.png', '{"valore": "3", "colore1": "#005689", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(73, 'Caldiero Terme', 'images/Italia/Squadre/caldiero terme.png', '{"valore": "3", "colore1": "#f5a800", "colore2": "#ffffff", "colore3": "#000000"}', 3, '2025-03-11 09:10:39'),
	(74, 'Carpi', 'images/Italia/Squadre/carpi.png', '{"valore": "3", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(75, 'Cavese', 'images/Italia/Squadre/cavese.png', '{"valore": "3", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(76, 'Clodiense', 'images/Italia/Squadre/clodiense.png', '{"valore": "3", "colore1": "#0066cc", "colore2": "#ffffff", "colore3": "#f5a800"}', 3, '2025-03-11 09:10:39'),
	(77, 'Giana Erminio', 'images/Italia/Squadre/giana erminio.png', '{"valore": "3", "colore1": "#00a859", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(78, 'Lecco', 'images/Italia/Squadre/lecco.png', '{"valore": "3", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(79, 'Lucchese', 'images/Italia/Squadre/lucchese.png', '{"valore": "3", "colore1": "#b50000", "colore2": "#ffffff", "colore3": "#f1c40f"}', 3, '2025-03-11 09:10:39'),
	(80, 'Lumezzane', 'images/Italia/Squadre/lumezzane.png', '{"valore": "3", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#ffcc00"}', 3, '2025-03-11 09:10:39'),
	(81, 'Messina', 'images/Italia/Squadre/messina.png', '{"valore": "3", "colore1": "#f2a900", "colore2": "#00549d", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(82, 'Pergolettese', 'images/Italia/Squadre/pergolettese.png', '{"valore": "3", "colore1": "#2a60b7", "colore2": "#ffd200", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(83, 'Pesaro', 'images/Italia/Squadre/pesaro.png', '{"valore": "3", "colore1": "#00549d", "colore2": "#ffffff", "colore3": "#ffd200"}', 5, '2025-03-11 09:10:39'),
	(84, 'Picerno', 'images/Italia/Squadre/picerno.png', '{"valore": "3", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#ffd200"}', 5, '2025-03-11 09:10:39'),
	(85, 'Pineto', 'images/Italia/Squadre/pineto.png', '{"valore": "3", "colore1": "#4d4d4d", "colore2": "#00a859", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(86, 'Pontedera', 'images/Italia/Squadre/pontedera.png', '{"valore": "3", "colore1": "#f2a900", "colore2": "#003b6d", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(87, 'Potenza', 'images/Italia/Squadre/potenza.png', '{"valore": "3", "colore1": "#f2a900", "colore2": "#9e1b32", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(88, 'Pro Patria', 'images/Italia/Squadre/pro patria.png', '{"valore": "3", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(89, 'Pro Vercelli', 'images/Italia/Squadre/pro vercelli.png', '{"valore": "3", "colore1": "#ffffff", "colore2": "#9e1b32", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(90, 'Renate', 'images/Italia/Squadre/renate.png', '{"valore": "3", "colore1": "#0066cc", "colore2": "#ffffff", "colore3": "#ffcc00"}', 5, '2025-03-11 09:10:39'),
	(91, 'Sorrento', 'images/Italia/Squadre/sorrento.png', '{"valore": "3", "colore1": "#e60000", "colore2": "#ffffff", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(92, 'Virtus Verona', 'images/Italia/Squadre/virtus verona.png', '{"valore": "3", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(93, 'Forlì', 'images/Italia/Squadre/forli.png', '{"valore": "2", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(94, 'Legnago', 'images/Italia/Squadre/legnago.png', '{"valore": "2", "colore1": "#ffcc00", "colore2": "#003b6d", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(95, 'Livorno', 'images/Italia/Squadre/livorno.png', '{"valore": "2", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(96, 'Pianese', 'images/Italia/Squadre/pianese.png', '{"valore": "2", "colore1": "#f5a800", "colore2": "#003b6d", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(97, 'Ravenna', 'images/Italia/Squadre/ravenna.png', '{"valore": "2", "colore1": "#9e1b32", "colore2": "#ffffff", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(98, 'Sestri Levante', 'images/Italia/Squadre/sestri levante.png', '{"valore": "2", "colore1": "#ffcc00", "colore2": "#0066cc", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39'),
	(99, 'Siracusa', 'images/Italia/Squadre/siracusa.png', '{"valore": "2", "colore1": "#003b6d", "colore2": "#ffffff", "colore3": "#f5a800"}', 5, '2025-03-11 09:10:39'),
	(100, 'Turris', 'images/Italia/Squadre/turris.png', '{"valore": "1", "colore1": "#ffcc00", "colore2": "#0066cc", "colore3": "#ffffff"}', 5, '2025-03-11 09:10:39');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
