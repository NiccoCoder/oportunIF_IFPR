-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema db_oportunif
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_oportunif`;
USE `db_oportunif`;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_CURSO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TB_CURSO` (
  `ID_CURSO` INT NOT NULL AUTO_INCREMENT,
  `NOME_CURSO` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID_CURSO`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_DISCENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TB_DISCENTE` (
  `ID_DISCENTE` INT NOT NULL AUTO_INCREMENT,
  `ID_CURSO` INT NOT NULL,
  `NOME` VARCHAR(100) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(255) NOT NULL,
  `CHAVE` VARCHAR(255) NULL,
  `SITUACAO` ENUM('pendente', 'confirmado') NOT NULL DEFAULT 'pendente',
  PRIMARY KEY (`ID_DISCENTE`),
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL`),
  INDEX `fk_TB_DISCENTE_TB_CURSO1_idx` (`ID_CURSO`),
  CONSTRAINT `fk_TB_DISCENTE_TB_CURSO1`
    FOREIGN KEY (`ID_CURSO`)
    REFERENCES `TB_CURSO` (`ID_CURSO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_DOCENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TB_DOCENTE` (
  `ID_DOCENTE` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(100) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(255) NOT NULL,
  `CHAVE` VARCHAR(255) NULL,
  `SITUACAO` ENUM('pendente', 'confirmado') NOT NULL DEFAULT 'pendente',
  `SUPER_USUARIO` TINYINT(1) NULL DEFAULT 0,
  PRIMARY KEY (`ID_DOCENTE`),
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_TIPO_PROJETO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TB_TIPO_PROJETO` (
  `ID_TIPO_PROJETO` INT NOT NULL AUTO_INCREMENT,
  `NOME_TIPO_PROJETO` VARCHAR(45) NOT NULL,
  `DESCRICAO` TEXT NOT NULL,
  PRIMARY KEY (`ID_TIPO_PROJETO`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_PROJETO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TB_PROJETO` (
  `ID_PROJETO` INT NOT NULL AUTO_INCREMENT,
  `ID_DOCENTE` INT NOT NULL,
  `ID_TIPO_PROJETO` INT NOT NULL,
  `TITULO` VARCHAR(255) NOT NULL,
  `CRITERIOS_SELECAO` TEXT NULL,
  `RESUMO` TEXT NOT NULL,
  `POSSUI_BOLSA` ENUM('0', '1') NOT NULL DEFAULT '0',
  `BOLSA_DESCRICAO` TEXT NULL,
  `BOLSA_REQUISITOS` TEXT NULL,
  PRIMARY KEY (`ID_PROJETO`),
  INDEX `fk_TB_PROJETO_TB_DOCENTE_idx` (`ID_DOCENTE`),
  INDEX `fk_TB_PROJETO_TB_TIPO_PROJETO1_idx` (`ID_TIPO_PROJETO`),
  CONSTRAINT `fk_TB_PROJETO_TB_DOCENTE`
    FOREIGN KEY (`ID_DOCENTE`)
    REFERENCES `TB_DOCENTE` (`ID_DOCENTE`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TB_PROJETO_TB_TIPO_PROJETO1`
    FOREIGN KEY (`ID_TIPO_PROJETO`)
    REFERENCES `TB_TIPO_PROJETO` (`ID_TIPO_PROJETO`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- Inserindo valores na tabela TB_CURSO
INSERT INTO `db_oportunif`.`TB_CURSO` (`NOME_CURSO`) VALUES
('Técnico em Informática'),
('Técnico em Administração'),
('Curso Superior em Gestão da Tecnologia da Informação'),
('Bacharelado em Administração'),
('Bacharelado em Ciência da Computação');

-- Inserindo valores na tabela TB_TIPO_PROJETO
INSERT INTO `db_oportunif`.`TB_TIPO_PROJETO` (`NOME_TIPO_PROJETO`, `DESCRICAO`) VALUES
('Extensão', 'Projeto de extensão'),
('Pesquisa', 'Projeto de pesquisa'),
('Inovação', 'Projeto de inovação'),
('Ensino', 'Projeto de ensino');

