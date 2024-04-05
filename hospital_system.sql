-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05/04/2024 às 18:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hospital_system`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `atendimentos`
--

CREATE TABLE `atendimentos` (
  `id` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `id_medico` int(11) NOT NULL,
  `data_atendimento` datetime NOT NULL,
  `observacoes` text DEFAULT NULL,
  `data_retorno` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `atendimentos`
--

INSERT INTO `atendimentos` (`id`, `id_paciente`, `id_medico`, `data_atendimento`, `observacoes`, `data_retorno`) VALUES
(3, 5, 7, '2024-04-26 12:33:00', 'Atendimento 01\r\nbatata', '2024-05-10 08:42:16'),
(4, 5, 7, '2024-04-07 08:52:00', 'aaaaaa', '2024-05-02 12:13:00'),
(5, 8, 10, '2024-04-06 10:15:00', 'Atendimento do paciente B', '2024-04-13 10:15:00'),
(6, 8, 10, '2024-04-10 14:30:00', 'Atendimento do paciente B', '2024-04-17 14:30:00'),
(7, 11, 13, '2024-04-15 09:30:00', 'Atendimento do paciente C', '2024-04-22 09:30:00'),
(8, 11, 13, '2024-04-20 11:45:00', 'Atendimento do paciente C', '2024-04-27 11:45:00'),
(9, 16, 18, '2024-04-25 14:00:00', 'Atendimento do paciente D', '2024-05-02 14:00:00'),
(10, 16, 18, '2024-04-30 16:30:00', 'Atendimento do paciente D', '2024-05-07 16:30:00');

--
-- Acionadores `atendimentos`
--
DELIMITER $$
CREATE TRIGGER `valida_medico_before_insert` BEFORE INSERT ON `atendimentos` FOR EACH ROW BEGIN
    DECLARE tipo_usuario VARCHAR(10);
    SELECT tipo INTO tipo_usuario FROM usuarios WHERE id = NEW.id_medico;
    IF tipo_usuario != 'medico' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Somente médicos podem ser associados aos atendimentos.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `altura` decimal(5,2) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `tipo_sanguineo` varchar(5) NOT NULL,
  `tipo` enum('paciente','atendente','medico') NOT NULL,
  `senha` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `endereco`, `cpf`, `celular`, `altura`, `peso`, `tipo_sanguineo`, `tipo`, `senha`, `email`) VALUES
(5, 'eduardo augusto gomes', 'rua porto alegre, 600, 600', '701.047.281-59', '64992948687', 2.00, 122.00, 'A+', 'paciente', 'paciente', 'paciente@paciente.com'),
(6, 'Atendente A', 'Casa Atendente', '22222222222', '64999999999', 1.85, 85.00, 'AB+', 'atendente', 'atendente', 'atendente@atendente.com'),
(7, 'Medico M', 'Casa do Medico', '33333333333', '64333333333', 1.93, 89.00, 'O+', 'medico', 'medico', 'medico@medico.com'),
(8, 'Paciente B', 'Rua Paciente B', '44444444444', '64999999999', 1.70, 70.00, 'B+', 'paciente', 'paciente', 'pacienteB@example.com'),
(9, 'Atendente B', 'Rua Atendente B', '55555555555', '64999999999', 1.75, 75.00, 'O-', 'atendente', 'atendente', 'atendenteB@example.com'),
(10, 'Medico B', 'Rua Medico B', '66666666666', '64999999999', 1.80, 80.00, 'A-', 'medico', 'medico', 'medicoB@example.com'),
(11, 'Paciente C', 'Rua Paciente C', '77777777777', '64999999999', 1.65, 65.00, 'AB-', 'paciente', 'paciente', 'pacienteC@example.com'),
(12, 'Atendente C', 'Rua Atendente C', '88888888888', '64999999999', 1.70, 70.00, 'A+', 'atendente', 'atendente', 'atendenteC@example.com'),
(13, 'Medico C', 'Rua Medico C', '99999999999', '64999999999', 1.75, 75.00, 'B-', 'medico', 'medico', 'medicoC@example.com'),
(15, 'asdasd', '22', '123123', '22', 123.00, 22.00, 'A+', 'paciente', 'asdasd', '22@22.com'),
(16, 'Paciente D', 'Rua Paciente D', '10101010101', '64999999999', 1.60, 60.00, 'O-', 'paciente', 'paciente', 'pacienteD@example.com'),
(17, 'Atendente D', 'Rua Atendente D', '11111111111', '64999999999', 1.75, 70.00, 'B+', 'atendente', 'atendente', 'atendenteD@example.com'),
(18, 'Medico D', 'Rua Medico D', '12121212121', '64999999999', 1.80, 80.00, 'AB-', 'medico', 'medico', 'medicoD@example.com');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paciente` (`id_paciente`),
  ADD KEY `id_medico` (`id_medico`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `atendimentos`
--
ALTER TABLE `atendimentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atendimentos`
--
ALTER TABLE `atendimentos`
  ADD CONSTRAINT `atendimentos_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `atendimentos_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
