-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema db_oportunif
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_oportunif
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_oportunif` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `db_oportunif` ;

-- Definindo a codificação de caracteres
SET character_set_client = utf8mb4;
SET character_set_connection = utf8mb4;
SET character_set_results = utf8mb4;
SET collation_connection = utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_CURSO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_CURSO` (
  `ID_CURSO` INT NOT NULL AUTO_INCREMENT,
  `NOME_CURSO` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID_CURSO`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_DISCENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_DISCENTE` (
  `ID_DISCENTE` INT NOT NULL AUTO_INCREMENT,
  `ID_CURSO` INT NOT NULL,
  `NOME` VARCHAR(100) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(255) NOT NULL,
  `CHAVE` VARCHAR(255) NULL DEFAULT NULL,
  `SITUACAO` ENUM('pendente', 'confirmado') NOT NULL DEFAULT 'pendente',
  PRIMARY KEY (`ID_DISCENTE`),
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL` ASC) VISIBLE,
  INDEX `fk_TB_DISCENTE_TB_CURSO1_idx` (`ID_CURSO` ASC) VISIBLE,
  CONSTRAINT `fk_TB_DISCENTE_TB_CURSO1`
    FOREIGN KEY (`ID_CURSO`)
    REFERENCES `db_oportunif`.`TB_CURSO` (`ID_CURSO`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_DOCENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_DOCENTE` (
  `ID_DOCENTE` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(100) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(255) NOT NULL,
  `CHAVE` VARCHAR(255) NULL DEFAULT NULL,
  `SITUACAO` ENUM('pendente', 'confirmado') NOT NULL DEFAULT 'pendente',
  `SUPER_USUARIO` TINYINT(1) NULL DEFAULT '0',
  PRIMARY KEY (`ID_DOCENTE`),
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_TIPO_PROJETO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_TIPO_PROJETO` (
  `ID_TIPO_PROJETO` INT NOT NULL AUTO_INCREMENT,
  `NOME_TIPO_PROJETO` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ID_TIPO_PROJETO`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_PROJETO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_PROJETO` (
  `ID_PROJETO` INT NOT NULL AUTO_INCREMENT,
  `ID_DOCENTE` INT NOT NULL,
  `ID_TIPO_PROJETO` INT NOT NULL,
  `TITULO` VARCHAR(255) NOT NULL,
  `CRITERIOS_SELECAO` TEXT NULL DEFAULT NULL,
  `RESUMO` TEXT NOT NULL,
  `POSSUI_BOLSA` ENUM('0', '1') NOT NULL DEFAULT '0',
  `BOLSA_DESCRICAO` TEXT NULL DEFAULT NULL,
  `BOLSA_REQUISITOS` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`ID_PROJETO`),
  INDEX `fk_TB_PROJETO_TB_DOCENTE_idx` (`ID_DOCENTE` ASC) VISIBLE,
  INDEX `fk_TB_PROJETO_TB_TIPO_PROJETO1_idx` (`ID_TIPO_PROJETO` ASC) VISIBLE,
  CONSTRAINT `fk_TB_PROJETO_TB_DOCENTE`
    FOREIGN KEY (`ID_DOCENTE`)
    REFERENCES `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`)
    ON DELETE CASCADE,
  CONSTRAINT `fk_TB_PROJETO_TB_TIPO_PROJETO1`
    FOREIGN KEY (`ID_TIPO_PROJETO`)
    REFERENCES `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`))
ENGINE = InnoDB
AUTO_INCREMENT = 20
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- -----------------------------------------------------
-- Data for table `db_oportunif`.`TB_CURSO`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_oportunif`;
INSERT INTO `db_oportunif`.`TB_CURSO` (`ID_CURSO`, `NOME_CURSO`) VALUES (DEFAULT, 'Técnico em Informática');
INSERT INTO `db_oportunif`.`TB_CURSO` (`ID_CURSO`, `NOME_CURSO`) VALUES (DEFAULT, 'Técnico em Administração');
INSERT INTO `db_oportunif`.`TB_CURSO` (`ID_CURSO`, `NOME_CURSO`) VALUES (DEFAULT, 'Curso Superior em Gestão da Tecnologia da Informação');
INSERT INTO `db_oportunif`.`TB_CURSO` (`ID_CURSO`, `NOME_CURSO`) VALUES (DEFAULT, 'Bacharelado em Administração');
INSERT INTO `db_oportunif`.`TB_CURSO` (`ID_CURSO`, `NOME_CURSO`) VALUES (DEFAULT, 'Bacharelado em Ciência da Computação');

COMMIT;

-- -----------------------------------------------------
-- Data for table `db_oportunif`.`TB_TIPO_PROJETO`
-- -----------------------------------------------------
START TRANSACTION;
USE `db_oportunif`;
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`) VALUES (1, 'Extensão');
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`) VALUES (2, 'Pesquisa');
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`) VALUES (3, 'Inovação');
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`) VALUES (4, 'Ensino');

COMMIT;
-- -----------------------------------------------------
-- Inserindo dados na tabela `TB_DOCENTE` 
-- -----------------------------------------------------
START TRANSACTION;
USE 'db_oportunif';
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (5, 'Cleverton Juliano Alves Vesentini', ' cleverton.vesentini@ifpr.edu.br', 'abc123!@', 'CHAVE123', 'confirmado', 1);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (6, 'Marlon de Oliveira Vaz', 'marlon.vaz@ifpr.edu.br', 'def456#$', 'CHAVE456', 'confirmado', 1);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (7, 'Ana Maria de Fátima Leme Tarini', 'ana.tarini@ifpr.edu.br', 'ghi789&*', 'CHAVE789', 'confirmado', 1);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (8, 'Aleffer Rocha', 'aleffer.rocha@ifpr.edu.br', 'jkl012@$!', 'CHAVE012', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (9, 'Alessandra Beatriz Pachas Zavala', 'alessandra.zavala@ifpr.edu.br', 'mno345%^', 'CHAVE345', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (10, 'Alexandre Peres Arias', 'alexandre.arias@ifpr.edu.br', 'pqr678**', 'CHAVE678', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (11, 'Allan Niels de Oliveira', 'allan.oliveira@ifpr.edu.br', 'stu901!@#', 'CHAVE901', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (12, 'Álvaro Rogério Cantieri', 'alvaro.cantieri@ifpr.edu.br', 'vwx234$%', 'CHAVE234', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (13, 'Ana Carolina Vilela de Carvalho', 'carolina.carvalho@ifpr.edu.br', 'yz567#@!', 'CHAVE567', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (14, 'Ana Maria de Fátima Leme Tarini', 'ana.tarini@ifpr.edu.br', 'abc890!$', 'CHAVE890', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (15, 'Anderson Ribeiro de Almeida', 'anderson.almeida@ifpr.edu.br', 'def123#&', 'CHAVE123A', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (16, 'Anieli de Fátima Miguel', 'anieli.miguel@ifpr.edu.br', 'ghi456*@', 'CHAVE456A', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (17, 'Anny Mirleni Almeida Silva', 'anny.silva@ifpr.edu.br', 'jkl789$%', 'CHAVE789A', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (18, 'Aryel Marlus Repula de Oliveira', 'aryel.oliveira@ifpr.edu.br', 'mno012&!', 'CHAVE012A', 'pendente', 0);
INSERT INTO `db_oportunif`.`TB_DOCENTE` (`ID_DOCENTE`, `NOME`, `EMAIL`, `SENHA`, `CHAVE`, `SITUACAO`, `SUPER_USUARIO`) VALUES (19, 'Atila de Paiva Teles', 'atila.teles@ifpr.edu.br', 'pqr345!#', 'CHAVE345A', 'pendente', 0);

COMMIT;
