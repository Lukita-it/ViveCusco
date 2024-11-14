-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Nov 14, 2024 alle 18:45
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bdlocal`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `administrador`
--

CREATE TABLE `administrador` (
  `idAdministrador` int(11) NOT NULL,
  `nombreAdministrador` varchar(100) NOT NULL,
  `apellidoAdministrador` varchar(100) NOT NULL,
  `dniAdministrador` char(8) NOT NULL,
  `correoAdministrador` varchar(100) NOT NULL,
  `contrasenaAdministrador` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `administrador`
--

INSERT INTO `administrador` (`idAdministrador`, `nombreAdministrador`, `apellidoAdministrador`, `dniAdministrador`, `correoAdministrador`, `contrasenaAdministrador`) VALUES
(1, 'Carlos', 'Ramirez', '11223344', 'carlos.ramirez@example.com', 'admin123'),
(2, 'Ana', 'Martinez', '55667788', 'ana.martinez@example.com', 'admin456');

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `nombreCliente` varchar(100) NOT NULL,
  `apellidoCliente` varchar(100) NOT NULL,
  `dniCliente` char(8) NOT NULL,
  `correoCliente` varchar(100) NOT NULL,
  `contrasenaCliente` varchar(100) NOT NULL,
  `imagenCliente` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`idCliente`, `nombreCliente`, `apellidoCliente`, `dniCliente`, `correoCliente`, `contrasenaCliente`, `imagenCliente`) VALUES
(6, 'Marino', 'Villa', '69305968', 'marino@gmail.com', '$2y$10$CKmVzOAt7eXdukuE6H/bauq7XSWBrkcEIHi6eEC3o9ekxGwzEULiK', ''),
(7, 'Miriam', 'Villa', '59396039', 'villa@gmail.com', '$2y$10$IWKKsSvTWNMip8OUCT1oyu0CI5xVqhvBdL9pmuHt1JC/6LJKBM9eS', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `entrada`
--

CREATE TABLE `entrada` (
  `idEntrada` int(11) NOT NULL,
  `idEvento` int(11) NOT NULL,
  `tipoEntrada` varchar(50) NOT NULL,
  `costoEntrada` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `entrada`
--

INSERT INTO `entrada` (`idEntrada`, `idEvento`, `tipoEntrada`, `costoEntrada`) VALUES
(1, 1, 'General', 50.00),
(2, 1, 'VIP', 100.00),
(3, 2, 'General', 30.00),
(4, 2, 'VIP', 70.00),
(5, 3, 'General', 40.00),
(6, 3, 'VIP', 80.00);

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
  `idEvento` int(11) NOT NULL,
  `nombreEvento` varchar(150) NOT NULL,
  `descripcionEvento` text DEFAULT NULL,
  `fechahoraEvento` datetime NOT NULL,
  `categoriaEvento` varchar(50) DEFAULT NULL,
  `capacidadEvento` int(11) NOT NULL,
  `entradasGeneralEvento` int(11) NOT NULL,
  `entradasVipEvento` int(11) NOT NULL,
  `imagenEvento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`idEvento`, `nombreEvento`, `descripcionEvento`, `fechahoraEvento`, `categoriaEvento`, `capacidadEvento`, `entradasGeneralEvento`, `entradasVipEvento`, `imagenEvento`) VALUES
(1, 'Concierto Rock', 'Celebra el rock peruano con bandas emblemáticas y nuevas promesas. ¡Una noche de energía y legado!', '2024-10-15 20:00:00', 'Concierto', 173, 94, 15, 'img/rock.jpeg'),
(2, 'Concierto Javier Solis', 'Disfruta de una velada mágica con Javier Solis, quien presentará su nuevo álbum \"Ecos del Corazón\".', '2024-12-20 22:00:00', 'Presentacion', 50, 25, 14, 'img/javier.jpg'),
(3, 'Noche Electronica', 'Disfruta de una noche llena de energía con los mejores DJs de música electrónica.', '2024-12-15 20:00:00', 'Concierto', 156, 71, 32, 'img/noche.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `reserva`
--

CREATE TABLE `reserva` (
  `idReserva` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `idEntrada` int(11) NOT NULL,
  `fechahoraReserva` datetime NOT NULL,
  `cantidadEntradaReserva` int(11) NOT NULL,
  `tipoEntradaReserva` varchar(50) NOT NULL,
  `estadoReserva` enum('PENDIENTE','CONFIRMADA','CANCELADA') NOT NULL,
  `idTransaccion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `transaccion`
--

CREATE TABLE `transaccion` (
  `idTransaccion` int(11) NOT NULL,
  `montoTransaccion` decimal(10,2) NOT NULL,
  `fechahoraTransaccion` datetime NOT NULL,
  `estadoTransaccion` enum('PENDIENTE','COMPLETADA','CANCELADA') NOT NULL,
  `tipopagoTransaccion` varchar(50) NOT NULL,
  `idReserva` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `transaccion`
--

INSERT INTO `transaccion` (`idTransaccion`, `montoTransaccion`, `fechahoraTransaccion`, `estadoTransaccion`, `tipopagoTransaccion`, `idReserva`) VALUES
(1, 100.00, '2024-12-01 12:35:00', 'COMPLETADA', 'Yape', NULL),
(2, 100.00, '2024-12-01 14:05:00', 'COMPLETADA', 'PagoEfectivo', NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdministrador`),
  ADD UNIQUE KEY `dniAdministrador` (`dniAdministrador`),
  ADD UNIQUE KEY `correoAdministrador` (`correoAdministrador`);

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD UNIQUE KEY `dniCliente` (`dniCliente`),
  ADD UNIQUE KEY `correoCliente` (`correoCliente`);

--
-- Indici per le tabelle `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`idEntrada`),
  ADD KEY `idEvento` (`idEvento`);

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idEvento`);

--
-- Indici per le tabelle `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `idCliente` (`idCliente`),
  ADD KEY `idEntrada` (`idEntrada`),
  ADD KEY `idTransaccion` (`idTransaccion`);

--
-- Indici per le tabelle `transaccion`
--
ALTER TABLE `transaccion`
  ADD PRIMARY KEY (`idTransaccion`),
  ADD KEY `idReserva` (`idReserva`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdministrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `entrada`
--
ALTER TABLE `entrada`
  MODIFY `idEntrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `evento`
--
ALTER TABLE `evento`
  MODIFY `idEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `reserva`
--
ALTER TABLE `reserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `transaccion`
--
ALTER TABLE `transaccion`
  MODIFY `idTransaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`) ON DELETE CASCADE;

--
-- Limiti per la tabella `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`idEntrada`) REFERENCES `entrada` (`idEntrada`) ON DELETE CASCADE,
  ADD CONSTRAINT `reserva_ibfk_3` FOREIGN KEY (`idTransaccion`) REFERENCES `transaccion` (`idTransaccion`) ON DELETE SET NULL;

--
-- Limiti per la tabella `transaccion`
--
ALTER TABLE `transaccion`
  ADD CONSTRAINT `transaccion_ibfk_1` FOREIGN KEY (`idReserva`) REFERENCES `reserva` (`idReserva`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
