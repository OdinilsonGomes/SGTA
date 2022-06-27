-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2022 at 01:05 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sgta`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Alterar_aluno` (`nome` VARCHAR(150), `email` VARCHAR(150), `data_nasc` DATE, `id_utilizador` INT, `id_aluno` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 BEGIN
-- Verifica se ja existe um aluno com mesmo email na base de dados
 DECLARE exist_id int DEFAULT (SELECT id from aluno a where a.email = email  and a.id<>id_aluno);
 -- verifica se o Id enviado existe na base de dados
 DECLARE exist_id2 int DEFAULT (SELECT COUNT(id) from aluno a where a.id=id_aluno);
 IF(exist_id2<>1) THEN 
 RETURN "Aluno não encontrado";
 	ELSEIF(exist_id>0) THEN
    	RETURN "Não é permitido existir dois alunos com o mesmo email.";
        -- Nao permite regista data nascimento superior ao dia de hoje
    ELSEIF(data_nasc>NOW()) THEN
    	RETURN "Data de nascimento não permitida";
    ELSEIF(email="") THEN
    	RETURN "Não é permitido registar email vazio";
    ELSE
		UPDATE aluno a
        SET a.nome=nome, a.email=email,a.data_nasc=data_nasc,a.id_utilizador=id_utilizador
        WHERE a.id=id_aluno;    
       	RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Alterar_transferencia` (`data` DATE, `motivo` VARCHAR(75), `id_turma_destino` INT, `id_utilizador` INT, `id_transferencia` INT) RETURNS VARCHAR(100) CHARSET utf8mb4 BEGIN
 DECLARE exist_id int DEFAULT (SELECT tr.id_aluno from transferencia tr where tr.id=id_transferencia and tr.id_aluno IN (select tr1.id_aluno from transferencia tr1 where tr1.id>id_transferencia));
IF (exist_id>0) then 
RETURN "Não é possivel alterar. Esta transferência deu lugar a uma ou mais transferências";
ELSE
		UPDATE transferencia tr SET tr.data=data, tr.motivo=motivo, tr.id_turma_destino=id_turma_destino, tr.id_utilizador=id_utilizador 		
		WHERE id=id_transferencia;   
       	RETURN "1";
   END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Alterar_turma` (`nome` VARCHAR(150), `id_utilizador` INT, `id_turma` INT) RETURNS VARCHAR(75) CHARSET utf8mb4 BEGIN
-- verifica se ja existe esse nome na base de dados
 DECLARE exist_id int DEFAULT (SELECT id from turma t where t.nome = nome and t.id <> id_turma);
 -- verifica se o ID enviado é valido
 DECLARE exist_id2 int DEFAULT (SELECT COUNT(id) from turma t where t.id =id_turma);
 
 IF (exist_id2<>1) THEN 
 RETURN "Turma não encontrada";
 ELSEIF(exist_id>0) THEN
    	RETURN "Não é permitido existir duas turmas com o mesmo nome.";
    ELSE
		UPDATE turma t
		SET t.nome=nome, 		  
        t.id_utilizador=id_utilizador
        WHERE t.id=id_turma;   
       	RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Alterar_utilizador` (`usuario` VARCHAR(15), `senha` VARCHAR(150), `id_utilizador` INT) RETURNS VARCHAR(50) CHARSET utf8mb4 BEGIN
 DECLARE exist_id int DEFAULT (SELECT id from utilizador u where u.usuario = usuario and u.id<>id_utilizador);
 	IF(exist_id>0) THEN
    	RETURN "Ja existe um utilizador com este nome";
    ELSE
    	UPDATE utilizador u set u.usuario=usuario, u.senha=senha
        where id=id_utilizador;
       	RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Eliminar_aluno` (`id_aluno` INT) RETURNS VARCHAR(150) CHARSET utf8mb4 BEGIN
 	DECLARE total_transferencia int DEFAULT (SELECT COUNT(id) from transferencia tr where tr.id_aluno=id_aluno);
    IF(total_transferencia>0) THEN 
    RETURN "Não é possivel eliminar esse aluno porque existem registos de transferencia associados a ele";
    ELSE
		DELETE FROM aluno WHERE id=id_aluno; 
    RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Eliminar_transferencia` (`id_transferencia` INT) RETURNS VARCHAR(150) CHARSET utf8mb4 BEGIN
-- Verifica se exite uma transeferencia posterior do mesmo aluno
 DECLARE exist_id int DEFAULT (SELECT tr.id_aluno from transferencia tr where tr.id=id_transferencia and tr.id_aluno IN (select tr1.id_aluno from transferencia tr1 where tr1.id>id_transferencia));
 -- Se existe uma transferencia posterior do mesmo aluno
 -- Ssitema não permite anular uma transferencia quando ja existe varias outras posteriores 
 IF(exist_id>0) THEN
 
 
 	RETURN "Não é possivel eliminar. Essa transferência deu lugar a uma ou mais transferências";
 ELSE
 -- se não existir transferencias posteriores, elimina e retorna o aluno a sua antiga turma
DELETE FROM transferencia WHERE id=id_transferencia;
 RETURN "1";
 END IF;
   
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Eliminar_turma` (`id_turma` INT) RETURNS VARCHAR(150) CHARSET utf8mb4 BEGIN
 DECLARE total_aluno int DEFAULT (SELECT COUNT(id) from aluno a where a.id_turma = id_turma);
  DECLARE total_transferencia int DEFAULT (SELECT COUNT(id) from transferencia tr where tr.id_turma_anterior=id_turma OR tr.id_turma_destino= id_turma);
 	
    IF(total_aluno>0) THEN
    	RETURN "Não é possivel Eliminar essa turma porque existem aluno(s) nela registados";
    ELSEIF(total_transferencia>0) THEN 
      RETURN "Não é possivel Eliminar essa turma porque existem transferencias associadas a ela";
    ELSE
		DELETE FROM turma WHERE id=id_turma; 
    RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Eliminar_utilizador` (`id_utilizador` INT) RETURNS VARCHAR(10) CHARSET utf8mb4 BEGIN
    	DELETE FROM utilizador WHERE id=id_utilizador;
       	RETURN "1";
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Inserir_aluno` (`nome` VARCHAR(150), `email` VARCHAR(150), `data_nasc` DATE, `id_turma` INT, `id_utilizador` INT) RETURNS VARCHAR(100) CHARSET utf8mb4 BEGIN
 DECLARE exist_id int DEFAULT (SELECT id from aluno a where a.email = email);
 	IF(exist_id>0) THEN
    	RETURN "Não é permitido existir dois alunos com o mesmo email.";
    ELSEIF(data_nasc>NOW()) THEN
    	RETURN "Data de nascimento não permitida";
    ELSEIF(email="") THEN
    	RETURN "Não é permitido registar email vazio";
    ELSE
		INSERT INTO aluno(`nome`, 		  `email`,`data_nasc`,id_turma,`id_utilizador`)
		VALUES (nome, email,data_nasc,id_turma,id_utilizador);   
       	RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Inserir_transferencia` (`data` DATE, `motivo` VARCHAR(25), `id_aluno` INT, `id_turma_destino` INT, `id_utilizador` INT) RETURNS VARCHAR(75) CHARSET utf8mb4 BEGIN
 DECLARE id_turma_actual int DEFAULT (SELECT a.id_turma from aluno a where a.id = id_aluno);
 	IF(id_turma_actual=id_turma_destino) THEN
    	RETURN "Não é possivel transferir o aluno para a mesma turma";
    ELSE
		INSERT INTO transferencia(`data`, 			`motivo`,`id_aluno`,`id_turma_anterior`,`id_turma_destino`,`id_utilizador`)
		VALUES (data, motivo,id_aluno,id_turma_actual,id_turma_destino,id_utilizador);   
       	RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Inserir_turma` (`nome` VARCHAR(150), `serie` VARCHAR(15), `id_utilizador` INT) RETURNS VARCHAR(75) CHARSET utf8mb4 BEGIN
 DECLARE exist_id int DEFAULT (SELECT id from turma t where t.nome = nome);
 	IF(exist_id>0) THEN
    	RETURN "Não é permitido existir duas turmas com o mesmo nome.";
    ELSE
    	
		INSERT INTO turma(`nome`, `serie`,`id_utilizador`)
		VALUES (nome, serie,id_utilizador);   
       	RETURN "1";
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `FUNC_Inserir_utilizador` (`usuario` VARCHAR(15), `senha` VARCHAR(150)) RETURNS VARCHAR(50) CHARSET utf8mb4 BEGIN
 DECLARE exist_id int DEFAULT (SELECT id from utilizador u where u.usuario = usuario);
 	IF(exist_id>0) THEN
    	RETURN "Ja existe um utilizador com este nome";
    ELSE
    	
		INSERT INTO utilizador(`usuario`, `senha`)
		VALUES (usuario,senha);   
       	RETURN "1";
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `aluno`
--

CREATE TABLE `aluno` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `data_nasc` date NOT NULL,
  `id_turma` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL,
  `data_reg` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `aluno`
--

INSERT INTO `aluno` (`id`, `nome`, `email`, `data_nasc`, `id_turma`, `id_utilizador`, `data_reg`) VALUES
(5, 'Odinilson', 'odinilson@gmail', '1994-09-20', 5, 1, '2022-06-22 15:49:40'),
(7, 'Vania', 'vania@gmail.com', '1999-02-02', 7, 1, '2022-06-23 15:28:05'),
(9, 'Vedilson', 'vedilson@', '1998-12-10', 3, 1, '2022-06-24 13:26:54'),
(10, 'teste1', 'asdasd', '2022-06-09', 11, 1, '2022-06-25 19:08:54'),
(11, 'Teste2', 'sdfd', '2022-06-23', 7, 1, '2022-06-25 19:09:06'),
(12, 'teste5', 'erer', '2022-06-08', 3, 1, '2022-06-25 19:09:22'),
(13, 'Teste6', 'fsdsd', '2022-06-01', 3, 1, '2022-06-25 19:09:34'),
(14, 'Teste7', 'edwasedf', '2022-06-17', 3, 1, '2022-06-25 19:10:02'),
(15, 'Teste9', 'qda', '2022-06-25', 9, 1, '2022-06-25 19:10:30'),
(16, 'Teste 10', 'sdsad', '2022-06-23', 3, 1, '2022-06-25 19:11:06'),
(17, 'Teste3', 'dfsdxa', '2022-06-10', 5, 1, '2022-06-25 19:11:34'),
(18, 'Teste4', 'dcs', '2022-06-10', 11, 1, '2022-06-25 19:11:47'),
(19, 'sdc', 'sdc', '2022-06-09', 11, 1, '2022-06-26 10:24:08'),
(22, 'TESRRRTTTT GGG', 'eeww@ddd', '2022-06-13', 9, 1, '2022-06-26 13:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `transferencia`
--

CREATE TABLE `transferencia` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `id_aluno` int(11) NOT NULL,
  `id_turma_anterior` int(11) NOT NULL,
  `id_turma_destino` int(11) NOT NULL,
  `data_reg` datetime NOT NULL DEFAULT current_timestamp(),
  `id_utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transferencia`
--

INSERT INTO `transferencia` (`id`, `data`, `motivo`, `id_aluno`, `id_turma_anterior`, `id_turma_destino`, `data_reg`, `id_utilizador`) VALUES
(7, '2022-06-23', 'teste ', 5, 5, 5, '2022-06-23 11:38:47', 1),
(9, '2022-06-24', 'teste', 5, 3, 3, '2022-06-24 15:57:21', 1),
(10, '2022-06-25', 'teste', 9, 7, 9, '2022-06-24 15:59:10', 1),
(11, '2022-06-24', 'teste', 7, 3, 7, '2022-06-24 16:00:38', 1),
(12, '2022-06-24', 'dsdas', 5, 5, 3, '2022-06-24 16:02:06', 1),
(14, '0000-00-00', '', 5, 5, 3, '2022-06-25 19:12:36', 1),
(15, '0000-00-00', '', 12, 7, 3, '2022-06-25 19:12:41', 1),
(16, '0000-00-00', '', 14, 7, 3, '2022-06-25 19:12:44', 1),
(18, '0000-00-00', '', 18, 9, 3, '2022-06-25 19:12:50', 1),
(20, '0000-00-00', '', 9, 9, 3, '2022-06-25 19:13:06', 1),
(21, '0000-00-00', '', 5, 3, 5, '2022-06-25 19:16:10', 1),
(23, '0000-00-00', '', 10, 3, 7, '2022-06-25 19:16:20', 1),
(26, '0000-00-00', '', 18, 3, 5, '2022-06-25 19:16:38', 1),
(27, '0000-00-00', '', 5, 5, 3, '2022-06-25 19:16:55', 1),
(29, '2022-06-28', 'werd', 10, 7, 11, '2022-06-25 19:17:01', 1),
(32, '2022-06-07', 'wqedwa', 18, 5, 11, '2022-06-25 19:17:10', 1),
(35, '2022-06-09', 'wef', 5, 3, 5, '2022-06-26 15:08:14', 1);

--
-- Triggers `transferencia`
--
DELIMITER $$
CREATE TRIGGER `Alterar_transferencia_aluno` AFTER UPDATE ON `transferencia` FOR EACH ROW update aluno set id_turma=NEW.id_turma_destino where id=NEW.id_aluno
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Eliminar_transferencia_aluno` AFTER DELETE ON `transferencia` FOR EACH ROW update aluno set id_turma=OLD.id_turma_anterior where id=OLD.id_aluno
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Inserir_transferir_aluno` AFTER INSERT ON `transferencia` FOR EACH ROW update aluno set id_turma=NEW.id_turma_destino where id=NEW.id_aluno
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `turma`
--

CREATE TABLE `turma` (
  `id` int(11) NOT NULL,
  `nome` varchar(15) NOT NULL,
  `serie` varchar(15) NOT NULL,
  `data_reg` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `turma`
--

INSERT INTO `turma` (`id`, `nome`, `serie`, `data_reg`, `id_utilizador`) VALUES
(3, 'B', '001D', '2022-06-22 11:03:57', 1),
(5, 'D', '452DDD', '2022-06-22 23:12:18', 1),
(7, 'E1', '8E', '2022-06-22 23:31:01', 1),
(9, 'F', 'F11', '2022-06-24 00:59:48', 1),
(11, 'A1', '0A0', '2022-06-25 22:05:59', 1),
(18, 'A11', 'E', '2022-06-26 13:42:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `utilizador`
--

CREATE TABLE `utilizador` (
  `id` int(11) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `senha` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilizador`
--

INSERT INTO `utilizador` (`id`, `usuario`, `senha`) VALUES
(1, 'odinilson', '123'),
(5, 'Vania2', 'adcd7048512e64b48da55b027577886ee5a36350');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vista_aluno`
-- (See below for the actual view)
--
CREATE TABLE `vista_aluno` (
`nome` varchar(150)
,`id` int(11)
,`id_turma` int(11)
,`email` varchar(150)
,`data_nasc` date
,`nome_turma` varchar(15)
,`id_utilizador` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vista_transferencia`
-- (See below for the actual view)
--
CREATE TABLE `vista_transferencia` (
`data` date
,`motivo` varchar(150)
,`id` int(11)
,`id_aluno` int(11)
,`id_turma_anterior` int(11)
,`id_turma_destino` int(11)
,`id_utilizador` int(11)
,`aluno` varchar(150)
,`turma_anterior` varchar(15)
,`turma_destino` varchar(15)
);

-- --------------------------------------------------------

--
-- Structure for view `vista_aluno`
--
DROP TABLE IF EXISTS `vista_aluno`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_aluno`  AS  (select `a`.`nome` AS `nome`,`a`.`id` AS `id`,`a`.`id_turma` AS `id_turma`,`a`.`email` AS `email`,`a`.`data_nasc` AS `data_nasc`,`t`.`nome` AS `nome_turma`,`a`.`id_utilizador` AS `id_utilizador` from (`aluno` `a` join `turma` `t`) where `t`.`id` = `a`.`id_turma`) ;

-- --------------------------------------------------------

--
-- Structure for view `vista_transferencia`
--
DROP TABLE IF EXISTS `vista_transferencia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_transferencia`  AS  (select `tr`.`data` AS `data`,`tr`.`motivo` AS `motivo`,`tr`.`id` AS `id`,`tr`.`id_aluno` AS `id_aluno`,`tr`.`id_turma_anterior` AS `id_turma_anterior`,`tr`.`id_turma_destino` AS `id_turma_destino`,`tr`.`id_utilizador` AS `id_utilizador`,`a`.`nome` AS `aluno`,`t1`.`nome` AS `turma_anterior`,`t2`.`nome` AS `turma_destino` from (((`transferencia` `tr` join `turma` `t1`) join `turma` `t2`) join `aluno` `a`) where `tr`.`id_turma_anterior` = `t1`.`id` and `tr`.`id_turma_destino` = `t2`.`id` and `tr`.`id_aluno` = `a`.`id`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aluno_email` (`email`),
  ADD KEY `turma_aluno` (`id_turma`),
  ADD KEY `utilizador_aluno` (`id_utilizador`);

--
-- Indexes for table `transferencia`
--
ALTER TABLE `transferencia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluno_transferencia` (`id_aluno`),
  ADD KEY `turma_origem_tranferencia` (`id_turma_anterior`),
  ADD KEY `utilizador_tranferencia` (`id_utilizador`),
  ADD KEY `turma_destino_tranferencia` (`id_turma_destino`);

--
-- Indexes for table `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `turma_nome` (`nome`),
  ADD KEY `utilizador_turma` (`id_utilizador`);

--
-- Indexes for table `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `utilizador_usuario` (`usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transferencia`
--
ALTER TABLE `transferencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `turma`
--
ALTER TABLE `turma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `turma_aluno` FOREIGN KEY (`id_turma`) REFERENCES `turma` (`id`),
  ADD CONSTRAINT `utilizador_aluno` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id`);

--
-- Constraints for table `transferencia`
--
ALTER TABLE `transferencia`
  ADD CONSTRAINT `aluno_transferencia` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `turma_destino_tranferencia` FOREIGN KEY (`id_turma_destino`) REFERENCES `turma` (`id`),
  ADD CONSTRAINT `turma_origem_tranferencia` FOREIGN KEY (`id_turma_anterior`) REFERENCES `turma` (`id`),
  ADD CONSTRAINT `utilizador_tranferencia` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id`);

--
-- Constraints for table `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `utilizador_turma` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
