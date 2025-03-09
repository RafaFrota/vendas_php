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
  `nome` varchar(250) NOT NULL,
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
  `nome` varchar(250) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`ID`, `nome`, `telefone`, `email`, `endereco`, `data_cadastro`) VALUES
(15, 'Rafael frota', '2147483647', 'rafael.frota.oliveira@gmail.com', '35', '2022-09-20 12:51:24'),
(16, 'jonas', '2147483647', 'rafael.frota.oliveira@gmail.com', '22', '2022-09-20 12:51:48'),
(17, 'joacinto', '2147483647', 'rafael.frota.oliveira@gmail.com', '123', '2022-09-20 12:52:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle_estoque`
--

CREATE TABLE `controle_estoque` (
  `ID` int(11) NOT NULL,
  `id_estoque` int(11) NOT NULL,
  `valor_compra` decimal(10,2) NOT NULL,
  `estoque_metros_quadrados` decimal(10,2) NOT NULL,
  `ID_user` int(11) NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `controle_estoque`
--

INSERT INTO `controle_estoque` (`ID`, `id_estoque`, `valor_compra`, `estoque_metros_quadrados`, `ID_user`, `data_registro`) VALUES
(46, 23, 1231.00, 2323.00, 1, '2022-09-19 22:39:12'),
(49, 22, 323232.00, 12312300.00, 1, '2022-09-19 22:41:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(250) NOT NULL,
  `valor_venda` decimal(10,2) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `descricao` text DEFAULT NULL,
  `user` int(11) NOT NULL,
  `deletado` tinyint(1) NOT NULL DEFAULT 0,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`ID`, `Nome`, `valor_venda`, `categoria_id`, `descricao`, `user`, `deletado`, `data_cadastro`) VALUES
(22, 'Brita ', 1000.00, 1, 'pedra lascada', 1, 0, '2022-09-19 22:38:26'),
(23, 'Carreiras S/A', 123.00, 4, 'qweqeqweq', 1, 0, '2022-09-19 22:39:12');

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
-- Estrutura da tabela `statusservico`
--

CREATE TABLE `statusservico` (
  `ID` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `statusservico`
--

INSERT INTO `statusservico` (`ID`, `nome`, `data`) VALUES
(1, 'Pendente', '2022-09-28 02:33:16'),
(2, 'Em andamento', '2022-09-28 02:33:16'),
(3, 'Concluído', '2022-09-28 02:33:16'),
(4, 'Cancelado', '2022-09-28 02:33:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `nome` varchar(148) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `ADM` int(11) NOT NULL DEFAULT 2,
  `email` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `data_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`ID`, `nome`, `senha`, `ADM`, `email`, `ativo`, `data_time`) VALUES
(1, 'joaquim', '123', 1, 'admin@sistema.com', 1, '2022-08-24 14:17:38');

-- --------------------------------------------------------

--
-- Estrutura da tabela `venda`
--

CREATE TABLE `venda` (
  `ID` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `valormetro` decimal(10,2) NOT NULL,
  `quantidadeMetros` decimal(10,2) NOT NULL,
  `formaDePagamento` int(11) NOT NULL,
  `statusPagamento` int(11) NOT NULL DEFAULT 2,
  `desconto` decimal(10,2) DEFAULT 0.00,
  `pagamento` decimal(10,2) DEFAULT 0.00,
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
  ADD KEY `id_estoque` (`id_estoque`),
  ADD KEY `ID_user` (`ID_user`);

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `user` (`user`);

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
-- Índices para tabela `statusservico`
--
ALTER TABLE `statusservico`
  ADD PRIMARY KEY (`ID`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `venda`
--
ALTER TABLE `venda`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `cliente` (`cliente`),
  ADD KEY `produto` (`produto`),
  ADD KEY `formaDePagamento` (`formaDePagamento`),
  ADD KEY `statusPagamento` (`statusPagamento`),
  ADD KEY `user_ID` (`user_ID`);

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
-- AUTO_INCREMENT de tabela `statusservico`
--
ALTER TABLE `statusservico`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  ADD CONSTRAINT `id_estoque` FOREIGN KEY (`id_estoque`) REFERENCES `estoque` (`ID`),
  ADD CONSTRAINT `ID_user` FOREIGN KEY (`ID_user`) REFERENCES `user` (`ID`);

--
-- Limitadores para a tabela `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `categoria_id` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`ID`),
  ADD CONSTRAINT `user` FOREIGN KEY (`user`) REFERENCES `user` (`ID`);

--
-- Limitadores para a tabela `venda`
--
ALTER TABLE `venda`
  ADD CONSTRAINT `cliente` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`ID`),
  ADD CONSTRAINT `produto` FOREIGN KEY (`produto`) REFERENCES `estoque` (`ID`),
  ADD CONSTRAINT `formaDePagamento` FOREIGN KEY (`formaDePagamento`) REFERENCES `formadepagamento` (`ID`),
  ADD CONSTRAINT `statusPagamento` FOREIGN KEY (`statusPagamento`) REFERENCES `statuspagamento` (`ID`),
  ADD CONSTRAINT `user_ID` FOREIGN KEY (`user_ID`) REFERENCES `user` (`ID`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
