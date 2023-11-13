-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Nov 13, 2023 alle 09:52
-- Versione del server: 10.4.21-MariaDB
-- Versione PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_iscrizionigiovanissimi`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bimbi`
--

CREATE TABLE `bimbi` (
  `IdBimbo` int(11) NOT NULL,
  `nome` text NOT NULL,
  `cognome` text NOT NULL,
  `dataNascita` date DEFAULT NULL,
  `idCatFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `categorie`
--

CREATE TABLE `categorie` (
  `idCat` int(11) NOT NULL,
  `Descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`idCat`, `Descrizione`) VALUES
(1, 'G0'),
(2, 'G1'),
(3, 'G2'),
(4, 'G3'),
(5, 'G4'),
(6, 'G5'),
(7, 'G6');

-- --------------------------------------------------------

--
-- Struttura della tabella `corse`
--

CREATE TABLE `corse` (
  `idCorsa` int(11) NOT NULL,
  `luogo` text NOT NULL,
  `ora` time NOT NULL,
  `dataEvento` date NOT NULL,
  `dataChiusuraIscrizioni` date NOT NULL,
  `posizione` text NOT NULL,
  `linkMaps` text DEFAULT NULL,
  `notePosizione` text DEFAULT NULL,
  `noteGara` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `genitore_di`
--

CREATE TABLE `genitore_di` (
  `IdUserFK` int(11) NOT NULL,
  `idBimboFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `genitori`
--

CREATE TABLE `genitori` (
  `IdUserFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipa`
--

CREATE TABLE `partecipa` (
  `IdBimboFK` int(11) NOT NULL,
  `IdCorsaFK` int(11) NOT NULL,
  `iscritto` tinyint(1) NOT NULL,
  `escluso` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `rigaruoli`
--

CREATE TABLE `rigaruoli` (
  `IdUserFK` int(11) NOT NULL,
  `IdRuoloFK` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `rouli`
--

CREATE TABLE `rouli` (
  `IdRuolo` int(11) NOT NULL,
  `Descrizione` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `rouli`
--

INSERT INTO `rouli` (`IdRuolo`, `Descrizione`) VALUES
(0, 'amministratore'),
(1, 'allenatore'),
(2, 'genitore');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `IdUser` int(11) NOT NULL,
  `Nome` text NOT NULL,
  `Cognome` text NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `bimbi`
--
ALTER TABLE `bimbi`
  ADD PRIMARY KEY (`IdBimbo`),
  ADD KEY `idCategoria` (`idCatFK`);

--
-- Indici per le tabelle `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idCat`);

--
-- Indici per le tabelle `corse`
--
ALTER TABLE `corse`
  ADD PRIMARY KEY (`idCorsa`);

--
-- Indici per le tabelle `genitore_di`
--
ALTER TABLE `genitore_di`
  ADD PRIMARY KEY (`IdUserFK`,`idBimboFK`),
  ADD KEY `IdUserFK` (`IdUserFK`,`idBimboFK`),
  ADD KEY `idBimboFK` (`idBimboFK`);

--
-- Indici per le tabelle `genitori`
--
ALTER TABLE `genitori`
  ADD PRIMARY KEY (`IdUserFK`),
  ADD KEY `IdUserFK` (`IdUserFK`);

--
-- Indici per le tabelle `partecipa`
--
ALTER TABLE `partecipa`
  ADD PRIMARY KEY (`IdBimboFK`,`IdCorsaFK`),
  ADD KEY `IdBimboFK` (`IdBimboFK`,`IdCorsaFK`),
  ADD KEY `IdCorsaFK` (`IdCorsaFK`);

--
-- Indici per le tabelle `rigaruoli`
--
ALTER TABLE `rigaruoli`
  ADD PRIMARY KEY (`IdUserFK`,`IdRuoloFK`),
  ADD KEY `IdUserFK` (`IdUserFK`,`IdRuoloFK`),
  ADD KEY `IdRouloFK` (`IdRuoloFK`);

--
-- Indici per le tabelle `rouli`
--
ALTER TABLE `rouli`
  ADD PRIMARY KEY (`IdRuolo`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`IdUser`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Username_2` (`Username`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `bimbi`
--
ALTER TABLE `bimbi`
  MODIFY `IdBimbo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `corse`
--
ALTER TABLE `corse`
  MODIFY `idCorsa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `rouli`
--
ALTER TABLE `rouli`
  MODIFY `IdRuolo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `IdUser` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bimbi`
--
ALTER TABLE `bimbi`
  ADD CONSTRAINT `bimbi_ibfk_1` FOREIGN KEY (`idCatFK`) REFERENCES `categorie` (`idCat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `genitore_di`
--
ALTER TABLE `genitore_di`
  ADD CONSTRAINT `genitore_di_ibfk_1` FOREIGN KEY (`idBimboFK`) REFERENCES `bimbi` (`IdBimbo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `genitore_di_ibfk_2` FOREIGN KEY (`IdUserFK`) REFERENCES `genitori` (`IdUserFK`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `genitori`
--
ALTER TABLE `genitori`
  ADD CONSTRAINT `genitori_ibfk_1` FOREIGN KEY (`IdUserFK`) REFERENCES `utenti` (`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `partecipa`
--
ALTER TABLE `partecipa`
  ADD CONSTRAINT `partecipa_ibfk_1` FOREIGN KEY (`IdBimboFK`) REFERENCES `bimbi` (`IdBimbo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `partecipa_ibfk_2` FOREIGN KEY (`IdCorsaFK`) REFERENCES `corse` (`idCorsa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `rigaruoli`
--
ALTER TABLE `rigaruoli`
  ADD CONSTRAINT `rigaruoli_ibfk_1` FOREIGN KEY (`IdRuoloFK`) REFERENCES `rouli` (`IdRuolo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rigaruoli_ibfk_2` FOREIGN KEY (`IdUserFK`) REFERENCES `utenti` (`IdUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
