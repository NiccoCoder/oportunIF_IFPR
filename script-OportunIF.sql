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
  `DESCRICAO` TEXT NOT NULL,
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
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`, `DESCRICAO`) VALUES (1, 'Extensão', 'Projeto de extensão');
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`, `DESCRICAO`) VALUES (2, 'Pesquisa', 'Projeto de pesquisa');
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`, `DESCRICAO`) VALUES (3, 'Inovação', 'Projeto de inovação');
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`, `NOME_TIPO_PROJETO`, `DESCRICAO`) VALUES (4, 'Ensino', 'Projeto de ensino');

COMMIT;
