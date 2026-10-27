-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 30, 2021 alle 14:21
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cadtimbratore`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `aziende`
--

CREATE TABLE `aziende` (
  `ID_AZIENDA` varchar(3) NOT NULL,
  `DESCRIZIONE` varchar(50) NOT NULL,
  `COD_AZIENDA_ESTERNO` varchar(15) NOT NULL,
  `SITO_WEB` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `aziende`
--

INSERT INTO `aziende` (`ID_AZIENDA`, `DESCRIZIONE`, `COD_AZIENDA_ESTERNO`, `SITO_WEB`) VALUES
('001', 'Caddit', '', 'https://www.caddit.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `descrittori_classe`
--

CREATE TABLE `descrittori_classe` (
  `ID_AZIENDA` varchar(3) NOT NULL,
  `ID_DESCRITTORE` varchar(25) NOT NULL,
  `BUSINESS_CLASS` varchar(100) DEFAULT NULL,
  `GRID_ACTION_ADAPTER` varchar(100) DEFAULT NULL,
  `TABLE_NAME` varchar(25) DEFAULT NULL,
  `FORM_NAME` varchar(100) DEFAULT NULL,
  `VISIBILITY_MULTI` varchar(1) NOT NULL DEFAULT 'N',
  `GRID_MODIFIER` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `descrittori_classe`
--

INSERT INTO `descrittori_classe` (`ID_AZIENDA`, `ID_DESCRITTORE`, `BUSINESS_CLASS`, `GRID_ACTION_ADAPTER`, `TABLE_NAME`, `FORM_NAME`, `VISIBILITY_MULTI`, `GRID_MODIFIER`) VALUES
('001', 'Aziende', 'src/it/caddit/base/azienda/Azienda.php', 'websrc/it/base/azienda/AziendaGridAA.php', 'aziende', 'websrc/it/base/azienda/Azienda.php', 'Y', NULL),
('001', 'DescrittoreCls', 'src/it/caddit/base/utility/DescrittoreClasse.php', 'websrc/it/base/utility/DescrittoreClasseGridAA.php', 'descrittori_classe', NULL, 'Y', NULL),
('001', 'Entita', 'src/it/caddit/base/utility/Entita.php', 'websrc/it/base/utility/EntitaGridAA.php', 'entita', NULL, 'Y', NULL),
('001', 'MenuUtente', NULL, NULL, 'menu_utenti', 'websrc/it/base/utente/MenuUtente.php', 'Y', NULL),
('001', 'Presenze', NULL, '', 'presenze_utenti', '', 'N', 'websrc/it/base/utente/PresenzeGridModifier.php'),
('001', 'Utente', 'src/it/caddit/base/utenti/Utente.php', 'websrc/it/base/utente/UtenteGridAA.php', 'utenti', 'websrc/it/base/utente/Utente.php', 'N', NULL),
('001', 'UtenteOre', NULL, 'websrc/it/base/utente/UtenteOreGridAA.php', 'utente_ore', 'websrc/it/base/utente/UtenteOre.php', 'N', 'websrc/it/base/utente/UtenteOreGridModifier.php');

-- --------------------------------------------------------

--
-- Struttura della tabella `descrittori_classe_att`
--

CREATE TABLE `descrittori_classe_att` (
  `ID_AZIENDA` varchar(3) NOT NULL,
  `ID_DESCRITTORE` varchar(25) NOT NULL,
  `ID_ATTRIBUTO` varchar(25) NOT NULL,
  `DESCRIZIONE` varchar(25) NOT NULL,
  `TIPO_ATTRIBUTO` varchar(25) NOT NULL,
  `COLUMN_NAME` varchar(25) NOT NULL,
  `IS_KEY` varchar(1) NOT NULL DEFAULT 'N',
  `POSIZIONE` int(11) DEFAULT NULL,
  `VISIBILE` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `descrittori_classe_att`
--

INSERT INTO `descrittori_classe_att` (`ID_AZIENDA`, `ID_DESCRITTORE`, `ID_ATTRIBUTO`, `DESCRIZIONE`, `TIPO_ATTRIBUTO`, `COLUMN_NAME`, `IS_KEY`, `POSIZIONE`, `VISIBILE`) VALUES
('001', 'Aziende', 'CodiceAziendaEsterno', 'Codice azienda esterno', '', 'COD_AZIENDA_ESTERNO', 'N', 2, 'Y'),
('001', 'Aziende', 'Descrizione', 'Descrizione azienda', '', 'DESCRIZIONE', 'N', 1, 'Y'),
('001', 'Aziende', 'IdAzienda', 'Codice azienda', '', 'ID_AZIENDA', 'Y', 0, 'Y'),
('001', 'Aziende', 'SitoWeb', 'Sito web', '', 'SITO_WEB', 'N', 3, 'Y'),
('001', 'DescrittoreCls', 'BusinessClass', 'Business class', '', 'BUSINESS_CLASS', 'N', 4, 'Y'),
('001', 'DescrittoreCls', 'FormName', 'Nome della form', '', 'FORM_NAME', 'N', 3, 'Y'),
('001', 'DescrittoreCls', 'IdAzienda', 'Codice azienda', '', 'ID_AZIENDA', 'Y', 0, 'Y'),
('001', 'DescrittoreCls', 'IdDescrittore', 'Codice descrittore', '', 'ID_DESCRITTORE', 'Y', 1, 'Y'),
('001', 'DescrittoreCls', 'TableName', 'Nome della tabella', '', 'TABLE_NAME', 'N', 2, 'Y'),
('001', 'Entita', 'BusinessClass', 'Business class', '', 'BUSINESS_CLASS', 'N', 4, 'Y'),
('001', 'Entita', 'FormName', 'Nome della form', '', 'FORM_NAME', 'N', 3, 'Y'),
('001', 'Entita', 'IdEntita', 'Codice entita', '', 'ID_ENTITA', 'Y', 0, 'Y'),
('001', 'Entita', 'NomeEntita', 'Nome entita', '', 'NOME_ENTITA', 'N', 1, 'Y'),
('001', 'Entita', 'NomeIcona', 'Nome icona', '', 'NOME_ICONA', 'N', 2, 'Y'),
('001', 'Entita', 'RDescrittoreClasse', 'Descrittore classe', '', 'R_DESCRITTORE_CLASSE', 'N', 2, 'Y'),
('001', 'Entita', 'TipoPannello', 'Tipo pannello', '', 'TIPO_PANNELLO', 'N', 3, 'Y'),
('001', 'MenuUtente', 'IdUtente', 'IdUtente', '', 'ID_UTENTE', 'N', 2, 'Y'),
('001', 'Presenze', 'Cognome', 'Cognome', '', 'COGNOME', 'N', 2, 'Y'),
('001', 'Presenze', 'IdUtente', 'Codice utente', '', 'ID_UTENTE', 'Y', 0, 'Y'),
('001', 'Presenze', 'Nome', 'Nome', '', 'NOME', 'N', 1, 'Y'),
('001', 'Presenze', 'Presente', 'Presente', '', 'PRESENTE', 'N', 3, 'Y'),
('001', 'Utente', 'Cognome', 'Cognome', '', 'COGNOME', 'N', 3, 'Y'),
('001', 'Utente', 'DtaNascita', 'Data di nascita', '', 'DTA_NASCITA', 'N', 4, 'Y'),
('001', 'Utente', 'IdAzienda', 'Codice azienda', '', 'ID_AZIENDA', 'Y', 0, 'Y'),
('001', 'Utente', 'IdUtente', 'Codice utente', '', 'ID_UTENTE', 'Y', 1, 'Y'),
('001', 'Utente', 'Matricola', 'Matricola', '', 'MATRICOLA', 'N', 6, 'Y'),
('001', 'Utente', 'Nome', 'Nome', '', 'NOME', 'N', 2, 'Y'),
('001', 'Utente', 'UidTag', 'Tag uid', '', 'UID_TAG', 'N', 5, 'Y'),
('001', 'UtenteOre', 'Cognome', 'Cognome', '', 'COGNOME', 'N', 3, 'Y'),
('001', 'UtenteOre', 'IdAzienda', 'Codice azienda', '', 'ID_AZIENDA', 'Y', 0, 'Y'),
('001', 'UtenteOre', 'IdUtente', 'Codice Utente', '', 'ID_UTENTE', 'Y', 1, 'Y'),
('001', 'UtenteOre', 'Nome', 'Nome', '', 'NOME', 'N', 2, 'Y');

-- --------------------------------------------------------

--
-- Struttura della tabella `entita`
--

CREATE TABLE `entita` (
  `ID_ENTITA` varchar(15) NOT NULL,
  `NOME_ENTITA` varchar(25) NOT NULL,
  `R_DESCRITTORE_CLASSE` varchar(25) NOT NULL,
  `BUSINESS_CLASS` varchar(50) DEFAULT NULL,
  `FORM_NAME` varchar(50) DEFAULT NULL,
  `TIPO_PANNELLO` varchar(1) NOT NULL DEFAULT '0',
  `NOME_ICONA` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `entita`
--

INSERT INTO `entita` (`ID_ENTITA`, `NOME_ENTITA`, `R_DESCRITTORE_CLASSE`, `BUSINESS_CLASS`, `FORM_NAME`, `TIPO_PANNELLO`, `NOME_ICONA`) VALUES
('Azienda', 'Aziende', 'Aziende', '', NULL, '0', '/assets/img/icon/aziende.png'),
('DescrittoreCls', 'Descrittori di classe', 'DescrittoreCls', '', NULL, '0', NULL),
('Entita', 'Entita', 'Entita', NULL, NULL, '0', '/assets/img/icon/entita.png'),
('MenuUtente', 'Menu utenti', 'MenuUtente', NULL, NULL, '0', '/assets/img/icon/menuUtenti.png'),
('Presenze', 'Presenze', 'Presenze', NULL, NULL, '0', '/assets/img/icon/utenti.png'),
('Utente', 'Utenti', 'Utente', NULL, NULL, '0', '/assets/img/icon/utenti.png'),
('UtenteOre', 'Ore utenti', 'UtenteOre', NULL, NULL, '0', '/assets/img/icon/utenti.png');

-- --------------------------------------------------------

--
-- Struttura della tabella `menu_utenti`
--

CREATE TABLE `menu_utenti` (
  `ID_UTENTE` varchar(6) NOT NULL,
  `ID_ENTITA` varchar(15) NOT NULL,
  `POSIZIONE` int(11) DEFAULT NULL,
  `POSIZIONE_PADRE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `menu_utenti`
--

INSERT INTO `menu_utenti` (`ID_UTENTE`, `ID_ENTITA`, `POSIZIONE`, `POSIZIONE_PADRE`) VALUES
('ADMIN', 'Azienda', 0, 0),
('ADMIN', 'DescrittoreCls', 4, 1),
('ADMIN', 'Entita', 2, 0),
('ADMIN', 'MenuUtente', 3, 1),
('ADMIN', 'Presenze', 5, 0),
('ADMIN', 'Utente', 1, 1),
('ADMIN', 'UtenteOre', 4, 1);

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `presenze_utenti`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `presenze_utenti` (
`ID_AZIENDA` varchar(3)
,`ID_UTENTE` varchar(6)
,`NOME` varchar(25)
,`COGNOME` varchar(25)
,`PRESENTE` varchar(1)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `timbrature`
--

CREATE TABLE `timbrature` (
  `ID_AZIENDA` varchar(3) NOT NULL,
  `ID_UTENTE` varchar(6) NOT NULL,
  `DTA_TIMBRATURA` date NOT NULL,
  `ORA_ARRIVO` time NOT NULL,
  `ORA_ARRIVO_FMT` time NOT NULL,
  `ORA_USCITA` time DEFAULT NULL,
  `ORA_USCITA_FMT` time DEFAULT NULL,
  `ORE_TOTALI` decimal(9,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `timbrature`
--

INSERT INTO `timbrature` (`ID_AZIENDA`, `ID_UTENTE`, `DTA_TIMBRATURA`, `ORA_ARRIVO`, `ORA_ARRIVO_FMT`, `ORA_USCITA`, `ORA_USCITA_FMT`, `ORE_TOTALI`) VALUES
('001', 'ADMIN', '2021-11-24', '08:00:00', '08:00:00', NULL, NULL, NULL),
('001', 'ADMIN', '2021-11-30', '08:00:00', '08:00:00', '12:00:00', '12:00:00', NULL),
('001', 'ADMIN', '2021-11-30', '13:00:00', '13:00:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `uid_sconosciuti`
--

CREATE TABLE `uid_sconosciuti` (
  `ID_AZIENDA` varchar(3) NOT NULL,
  `PROGRESSIVO` int(11) NOT NULL,
  `UID` varchar(50) NOT NULL,
  `TIMESTAMP_CRZ` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura stand-in per le viste `utente_ore`
-- (Vedi sotto per la vista effettiva)
--
CREATE TABLE `utente_ore` (
`ID_AZIENDA` varchar(3)
,`ID_UTENTE` varchar(6)
,`NOME` varchar(25)
,`COGNOME` varchar(25)
);

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `ID_AZIENDA` varchar(3) NOT NULL,
  `ID_UTENTE` varchar(6) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `NOME` varchar(25) NOT NULL,
  `COGNOME` varchar(25) NOT NULL,
  `DTA_NASCITA` date NOT NULL,
  `UID_TAG` varchar(50) NOT NULL,
  `MATRICOLA` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`ID_AZIENDA`, `ID_UTENTE`, `PASSWORD`, `NOME`, `COGNOME`, `DTA_NASCITA`, `UID_TAG`, `MATRICOLA`) VALUES
('001', 'ADMIN', 'ADMIN1', 'Admin', 'Admin', '9999-01-01', '', 'XX55'),
('001', 'FONMAT', '?', 'Matteo', 'Fontana', '1987-07-29', '', '');

-- --------------------------------------------------------

--
-- Struttura per vista `presenze_utenti`
--
DROP TABLE IF EXISTS `presenze_utenti`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `presenze_utenti`  AS  select `u`.`ID_AZIENDA` AS `ID_AZIENDA`,`u`.`ID_UTENTE` AS `ID_UTENTE`,`u`.`NOME` AS `NOME`,`u`.`COGNOME` AS `COGNOME`,case when `u`.`ID_UTENTE` in (select `t`.`ID_UTENTE` from `timbrature` `t` where `t`.`DTA_TIMBRATURA` = curdate() and `t`.`ORA_USCITA` is null) then 'Y' else 'N' end AS `PRESENTE` from `utenti` `u` ;

-- --------------------------------------------------------

--
-- Struttura per vista `utente_ore`
--
DROP TABLE IF EXISTS `utente_ore`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `utente_ore`  AS  select distinct `u`.`ID_AZIENDA` AS `ID_AZIENDA`,`t`.`ID_UTENTE` AS `ID_UTENTE`,`u`.`NOME` AS `NOME`,`u`.`COGNOME` AS `COGNOME` from (`utenti` `u` join `timbrature` `t` on(`u`.`ID_AZIENDA` = `t`.`ID_AZIENDA` and `u`.`ID_UTENTE` = `t`.`ID_UTENTE`)) ;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `aziende`
--
ALTER TABLE `aziende`
  ADD PRIMARY KEY (`ID_AZIENDA`);

--
-- Indici per le tabelle `descrittori_classe`
--
ALTER TABLE `descrittori_classe`
  ADD PRIMARY KEY (`ID_AZIENDA`,`ID_DESCRITTORE`);

--
-- Indici per le tabelle `descrittori_classe_att`
--
ALTER TABLE `descrittori_classe_att`
  ADD PRIMARY KEY (`ID_AZIENDA`,`ID_DESCRITTORE`,`ID_ATTRIBUTO`,`DESCRIZIONE`);

--
-- Indici per le tabelle `entita`
--
ALTER TABLE `entita`
  ADD PRIMARY KEY (`ID_ENTITA`);

--
-- Indici per le tabelle `menu_utenti`
--
ALTER TABLE `menu_utenti`
  ADD PRIMARY KEY (`ID_UTENTE`,`ID_ENTITA`);

--
-- Indici per le tabelle `timbrature`
--
ALTER TABLE `timbrature`
  ADD PRIMARY KEY (`ID_AZIENDA`,`ID_UTENTE`,`DTA_TIMBRATURA`,`ORA_ARRIVO`);

--
-- Indici per le tabelle `uid_sconosciuti`
--
ALTER TABLE `uid_sconosciuti`
  ADD PRIMARY KEY (`ID_AZIENDA`,`PROGRESSIVO`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`ID_AZIENDA`,`ID_UTENTE`);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `descrittori_classe`
--
ALTER TABLE `descrittori_classe`
  ADD CONSTRAINT `azFk` FOREIGN KEY (`ID_AZIENDA`) REFERENCES `aziende` (`ID_AZIENDA`);

--
-- Limiti per la tabella `descrittori_classe_att`
--
ALTER TABLE `descrittori_classe_att`
  ADD CONSTRAINT `descAttAzFk` FOREIGN KEY (`ID_AZIENDA`) REFERENCES `aziende` (`ID_AZIENDA`);

--
-- Limiti per la tabella `timbrature`
--
ALTER TABLE `timbrature`
  ADD CONSTRAINT `timbratureAzFk` FOREIGN KEY (`ID_AZIENDA`) REFERENCES `aziende` (`ID_AZIENDA`);

--
-- Limiti per la tabella `uid_sconosciuti`
--
ALTER TABLE `uid_sconosciuti`
  ADD CONSTRAINT `uidSconosciutiAzFk` FOREIGN KEY (`ID_AZIENDA`) REFERENCES `aziende` (`ID_AZIENDA`);

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `utentiAzFk` FOREIGN KEY (`ID_AZIENDA`) REFERENCES `aziende` (`ID_AZIENDA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
