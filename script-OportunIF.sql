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
CREATE SCHEMA IF NOT EXISTS `db_oportunif` DEFAULT CHARACTER SET utf8mb3 ;
USE `db_oportunif` ;

-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_DISCENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_DISCENTE` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(100) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(100) NOT NULL,
  `TURMA` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_oportunif`.`TB_DOCENTE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_DOCENTE` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `NOME` VARCHAR(100) NOT NULL,
  `EMAIL` VARCHAR(100) NOT NULL,
  `SENHA` VARCHAR(100) NOT NULL,
  `MASTER` ENUM('SIM', 'NÃO') NOT NULL DEFAULT 'NÃO',
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `EMAIL_UNIQUE` (`EMAIL` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `DB_OPORTUNIF`.`TB_PROJETO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_oportunif`.`TB_PROJETO` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ID_DOCENTE` INT NOT NULL,
  `TITULO` VARCHAR(100) NOT NULL,
  `DESCRICAO` VARCHAR(500) NULL,
  `TIPO` VARCHAR(45) NULL,
  `RESUMO` VARCHAR(500) NULL,
  `BOLSA_DESCRICAO` VARCHAR(500) NULL,
  `BOLSA_VALOR` VARCHAR(45) NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_TB_PROJETO_TB_DOCENTE_idx` (`ID_DOCENTE` ASC) VISIBLE,
  CONSTRAINT `fk_TB_PROJETO_TB_DOCENTE`
    FOREIGN KEY (`ID_DOCENTE`)
    REFERENCES `db_oportunif`.`TB_DOCENTE` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

