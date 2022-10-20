-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28-Set-2022 às 04:35
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `joaquim`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `ID` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`ID`, `nome`, `data`) VALUES
(1, 'Brita', '2022-09-03 15:31:08'),
(2, 'Areia', '2022-09-03 15:31:08'),
(3, 'Barro', '2022-09-03 15:31:08'),
(4, 'Tijolo', '2022-09-03 15:31:08');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE `cliente` (
  `ID` int(11) NOT NULL,
  `nome` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `celular` int(11) NOT NULL,
  `cep` int(11) NOT NULL,
  `endereco` varchar(120) NOT NULL,
  `criado_por` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`ID`, `nome`, `email`, `celular`, `cep`, `endereco`, `criado_por`, `data`) VALUES
(15, 'Rafael frota', 'rafael.frota.oliveira@gmail.com', 2147483647, 71657, '35', 1, '2022-09-20 12:51:24'),
(16, 'jonas', 'rafael.frota.oliveira@gmail.com', 2147483647, 71657, '22', 1, '2022-09-20 12:51:48'),
(17, 'joacinto', 'rafael.frota.oliveira@gmail.com', 2147483647, 71657, '123', 1, '2022-09-20 12:52:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle_estoque`
--

CREATE TABLE `controle_estoque` (
  `ID` int(11) NOT NULL,
  `id_estoque` int(11) NOT NULL,
  `valor_compra` float NOT NULL,
  `estoque_metros_quadrados` float NOT NULL,
  `ID_user` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `controle_estoque`
--

INSERT INTO `controle_estoque` (`ID`, `id_estoque`, `valor_compra`, `estoque_metros_quadrados`, `ID_user`, `data`) VALUES
(46, 23, 1231, 2323, 1, '2022-09-19 22:39:12'),
(49, 22, 323232, 12312300, 1, '2022-09-19 22:41:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `valor_venda` float NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`ID`, `Nome`, `valor_venda`, `categoria_id`, `descricao`, `data`, `user`) VALUES
(22, 'Brita ', 1000, 1, 'pedra lascada', '2022-09-19 22:38:26', 1),
(23, 'Carreiras S/A', 123, 4, 'qweqeqweq', '2022-09-19 22:39:12', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `formadepagamento`
--

CREATE TABLE `formadepagamento` (
  `ID` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `formadepagamento`
--

INSERT INTO `formadepagamento` (`ID`, `nome`, `data`) VALUES
(1, 'A vista', '2022-09-28 02:25:47'),
(2, 'Cartão de crédito', '2022-09-28 02:25:47'),
(3, 'Cartão de debito', '2022-09-28 02:25:47'),
(4, 'PIX', '2022-09-28 02:25:47');

-- --------------------------------------------------------

--
-- Estrutura da tabela `statuspagamento`
--

CREATE TABLE `statuspagamento` (
  `ID` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `statuspagamento`
--

INSERT INTO `statuspagamento` (`ID`, `nome`, `data`) VALUES
(1, 'Pagamento efetuado', '2022-09-28 02:33:16'),
(2, 'Pagamento parcial', '2022-09-28 02:33:16'),
(3, 'Pagamento pendente', '2022-09-28 02:33:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `nome` varchar(148) DEFAULT NULL,
  `senha` varchar(16) DEFAULT NULL,
  `ADM` int(11) NOT NULL,
  `data_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`ID`, `nome`, `senha`, `ADM`, `data_time`) VALUES
(1, 'joaquim', '123', 1, '2022-08-24 14:17:38');

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `ID` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `valormetro` float NOT NULL,
  `quantidadeMetros` float NOT NULL,
  `formaDePagamento` int(11) NOT NULL,
  `statusPagamento` int(11) NOT NULL,
  `pagamento` float NOT NULL,
  `user_ID` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `controle_estoque`
--
ALTER TABLE `controle_estoque`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_estoque_fk` (`id_estoque`) USING BTREE;

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id_fk` (`user`),
  ADD KEY `categoria_id_fk` (`categoria_id`);

--
-- Índices para tabela `formadepagamento`
--
ALTER TABLE `formadepagamento`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `statuspagamento`
--
ALTER TABLE `statuspagamento`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `statusPagamento` (`statusPagamento`),
  ADD KEY `user_id_fk` (`user_ID`),
  ADD KEY `formaDePagamento` (`formaDePagamento`),
  ADD KEY `cliente` (`cliente`),
  ADD KEY `produto` (`produto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de tabela `controle_estoque`
--
ALTER TABLE `controle_estoque`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `formadepagamento`
--
ALTER TABLE `formadepagamento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `statuspagamento`
--
ALTER TABLE `statuspagamento`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `venda`
--
ALTER TABLE `venda`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `controle_estoque`
--
ALTER TABLE `controle_estoque`
  ADD CONSTRAINT `id_estoque_fk` FOREIGN KEY (`id_estoque`) REFERENCES `estoque` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `categoria_id_fk` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user`) REFERENCES `user` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `cliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `formaDePagamento` FOREIGN KEY (`formaDePagamento`) REFERENCES `formadepagamento` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `produto` FOREIGN KEY (`produto`) REFERENCES `estoque` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `statusPagamento` FOREIGN KEY (`statusPagamento`) REFERENCES `statuspagamento` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_ID` FOREIGN KEY (`user_ID`) REFERENCES `user` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
