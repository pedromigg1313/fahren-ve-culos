-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Out-2025 às 18:52
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fahren`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios_carros`
--

CREATE TABLE `anuncios_carros` (
  `id` int(12) NOT NULL,
  `estado_local` char(2) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL,
  `marca` varchar(25) DEFAULT NULL,
  `modelo` varchar(75) DEFAULT NULL,
  `versao` varchar(40) DEFAULT NULL,
  `carroceria` varchar(15) DEFAULT NULL,
  `preco` decimal(11,2) DEFAULT NULL,
  `quilometragem` int(10) DEFAULT NULL,
  `ano_fabricacao` int(4) DEFAULT NULL,
  `ano_modelo` int(4) DEFAULT NULL,
  `propulsao` varchar(10) DEFAULT NULL,
  `combustivel` varchar(20) DEFAULT NULL,
  `blindagem` char(1) DEFAULT '0',
  `id_vendedor` int(10) DEFAULT NULL,
  `imagens` varchar(255) DEFAULT NULL,
  `leilao` char(1) DEFAULT NULL,
  `portas_qtd` smallint(1) DEFAULT 4,
  `acentos_qtd` smallint(1) DEFAULT 5,
  `placa` char(7) DEFAULT NULL,
  `data_criacao` datetime NOT NULL DEFAULT current_timestamp(),
  `cor` varchar(10) NOT NULL,
  `quant_proprietario` char(1) NOT NULL,
  `revisao` char(1) NOT NULL,
  `vistoria` char(1) NOT NULL,
  `sinistro` char(1) NOT NULL,
  `ipva` char(1) NOT NULL,
  `licenciamento` char(1) NOT NULL,
  `estado_conservacao` char(1) NOT NULL,
  `uso_anterior` char(1) NOT NULL,
  `aceita_troca` char(1) NOT NULL,
  `email` varchar(256) NOT NULL,
  `telefone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `anuncios_carros`
--

INSERT INTO `anuncios_carros` (`id`, `estado_local`, `cidade`, `marca`, `modelo`, `versao`, `carroceria`, `preco`, `quilometragem`, `ano_fabricacao`, `ano_modelo`, `propulsao`, `combustivel`, `blindagem`, `id_vendedor`, `imagens`, `leilao`, `portas_qtd`, `acentos_qtd`, `placa`, `data_criacao`, `cor`, `quant_proprietario`, `revisao`, `vistoria`, `sinistro`, `ipva`, `licenciamento`, `estado_conservacao`, `uso_anterior`, `aceita_troca`, `email`, `telefone`) VALUES
(19, NULL, NULL, 'porsche', '911', 'PDK TURBO', NULL, '1190000.00', 0, 2021, 2022, NULL, NULL, '0', 6, NULL, NULL, 4, 5, 'ESA0F08', '2025-09-26 14:30:29', 'dourado', '2', '1', 'V', 'L', 'A', 'V', '3', '', '1', 'kelwin@gmail.com', '(11) 11111-1111'),
(20, NULL, NULL, 'bmw', 'm3', 'V8 BI TURBO', NULL, '100000.00', 2, 2018, 2018, NULL, NULL, '0', 6, NULL, NULL, 4, 5, 'DSA7A98', '2025-09-26 15:44:17', 'bege', '5', '5', 'F', '0', 'D', 'D', '4', 'P', '0', 'kelwin@gmail.com', '(11) 11111-1111'),
(21, NULL, NULL, 'chevrolet', 'camaro', 'ZL1', NULL, '100000.00', 10, 2016, 2017, NULL, NULL, '0', 6, NULL, NULL, 4, 5, 'ADY9Y98', '2025-10-01 13:36:48', 'vinho', '4', '3', 'F', 'L', 'D', 'D', '4', 'P', '0', 'teste@gmail.com', '(11) 11111-1111');

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`id`, `nome`, `value`) VALUES
(1, 'Abarth', 'abarth'),
(2, 'Alfa Romeo', 'alfa'),
(3, 'Aston Martin', 'aston'),
(4, 'Audi', 'audi'),
(5, 'Bentley', 'bentley'),
(6, 'BMW', 'bmw'),
(7, 'Bugatti', 'bugatti'),
(8, 'BYD', 'byd'),
(9, 'Cadillac', 'cadillac'),
(10, 'Chevrolet', 'chevrolet'),
(11, 'Chrysler', 'chrysler'),
(12, 'Citroën', 'citroen'),
(13, 'Corvette', 'corvette'),
(14, 'Dacia', 'dacia'),
(15, 'Dodge', 'dodge'),
(16, 'Ferrari', 'ferrari'),
(17, 'Fiat', 'fiat'),
(18, 'Ford', 'ford'),
(19, 'Genesis', 'genesis'),
(20, 'GMC', 'gmc'),
(21, 'GWM', 'gwm'),
(22, 'Honda', 'honda'),
(23, 'Hummer', 'hummer'),
(24, 'Hyundai', 'hyundai'),
(25, 'Infiniti', 'infiniti'),
(26, 'JAECOO', 'jaecoo'),
(27, 'Jaguar', 'jaguar'),
(28, 'Jeep', 'jeep'),
(29, 'Kia', 'kia'),
(30, 'Koenigsegg', 'koenigsegg'),
(31, 'Lamborghini', 'lamborghini'),
(32, 'Lancia', 'lancia'),
(33, 'Land Rover', 'land'),
(34, 'Lexus', 'lexus'),
(35, 'Lincoln', 'lincoln'),
(36, 'Lotus', 'lotus'),
(37, 'Maserati', 'maserati'),
(38, 'Mazda', 'mazda'),
(39, 'McLaren', 'mclaren'),
(40, 'Mercedes-Benz', 'mercedes'),
(41, 'MINI', 'mini'),
(42, 'Mitsubishi', 'mitsubishi'),
(43, 'Nissan', 'nissan'),
(44, 'Omoda', 'omoda'),
(45, 'Opel', 'opel'),
(46, 'Peugeot', 'peugeot'),
(47, 'Porsche', 'porsche'),
(48, 'Ram', 'ram'),
(49, 'Renault', 'renault'),
(50, 'Rolls-Royce', 'rolls'),
(51, 'Skoda', 'skoda'),
(52, 'Smart', 'smart'),
(53, 'Subaru', 'subaru'),
(54, 'Suzuki', 'suzuki'),
(55, 'Tesla', 'tesla'),
(56, 'Toyota', 'toyota'),
(57, 'Volkswagen', 'volkswagen'),
(58, 'Volvo', 'volvo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(6) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `sobrenome` varchar(30) NOT NULL,
  `telefone` bigint(15) DEFAULT NULL,
  `cpf` char(11) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `data_criacao_conta` datetime NOT NULL DEFAULT current_timestamp(),
  `data_nascimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `sobrenome`, `telefone`, `cpf`, `email`, `senha`, `data_criacao_conta`, `data_nascimento`) VALUES
(6, 'Kelwin', 'Silva', NULL, NULL, 'kelwin@gmail.com', '1111AAAA', '2025-09-20 20:44:02', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `anuncios_carros`
--
ALTER TABLE `anuncios_carros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `carro_link_vendedor_id` (`id_vendedor`);

--
-- Índices para tabela `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anuncios_carros`
--
ALTER TABLE `anuncios_carros`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `anuncios_carros`
--
ALTER TABLE `anuncios_carros`
  ADD CONSTRAINT `carro_link_vendedor_id` FOREIGN KEY (`id_vendedor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
