-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 29/09/2016 às 11:36
-- Versão do servidor: 5.7.15-0ubuntu0.16.04.1
-- Versão do PHP: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gersocios`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `Id` int(11) NOT NULL,
  `NomeEmpresa` varchar(50) NOT NULL,
  `CNPJ` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `empresa`
--

INSERT INTO `empresa` (`Id`, `NomeEmpresa`, `CNPJ`) VALUES
(1, 'Odebrecht', '01234567899874'),
(2, 'OAS', '98765432100123'),
(3, 'Camargo corrêa', '98876554322110');

-- --------------------------------------------------------

--
-- Estrutura para tabela `socio`
--

CREATE TABLE `socio` (
  `Id` int(11) NOT NULL,
  `NomeSocio` varchar(50) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `socio`
--

INSERT INTO `socio` (`Id`, `NomeSocio`, `CPF`, `Email`) VALUES
(1, 'Paulo', '12345678901', 'paulo@gmail.com'),
(2, 'Tico', '01234567890', 'tico@gmail.com'),
(3, 'Ricardo', '98765432109', 'ricardo@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `socioempresa`
--

CREATE TABLE `socioempresa` (
  `Id` int(11) NOT NULL,
  `IdSocio` int(11) DEFAULT NULL,
  `IdEmpresa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `socioempresa`
--

INSERT INTO `socioempresa` (`Id`, `IdSocio`, `IdEmpresa`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 3, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(10) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Login` varchar(50) NOT NULL,
  `Senha` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nome`, `Login`, `Senha`) VALUES
(2, 'Fausto Alves', 'fausto@gmail.com', 'a84a996fbddd53f5fac65b17cc4eb77f'),
(7, 'Renan Marques', 'renan@gmail.com', '00559ea764f3549e2a9c714ecd8af73f');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`Id`);

--
-- Índices de tabela `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`Id`);

--
-- Índices de tabela `socioempresa`
--
ALTER TABLE `socioempresa`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdSocio` (`IdSocio`),
  ADD KEY `IdEmpresa` (`IdEmpresa`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de tabela `socio`
--
ALTER TABLE `socio`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de tabela `socioempresa`
--
ALTER TABLE `socioempresa`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `socioempresa`
--
ALTER TABLE `socioempresa`
  ADD CONSTRAINT `socioempresa_ibfk_1` FOREIGN KEY (`IdSocio`) REFERENCES `socio` (`Id`),
  ADD CONSTRAINT `socioempresa_ibfk_2` FOREIGN KEY (`IdEmpresa`) REFERENCES `empresa` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
