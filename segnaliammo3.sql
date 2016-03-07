SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `segnaliammo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `segnaliammo` ;

-- -----------------------------------------------------
-- Table `segnaliammo`.`categorie`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `segnaliammo`.`categorie` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `segnaliammo`.`operatori`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `segnaliammo`.`operatori` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(64) NULL ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(40) NULL ,
  `scadenza_password` DATETIME NULL ,
  `ultimo_login` DATETIME NULL ,
  `attivo` TINYINT(1) NULL ,
  `cognome` VARCHAR(45) NULL ,
  `nome` VARCHAR(45) NULL ,
  `telefono` VARCHAR(20) NULL ,
  `cellulare` VARCHAR(20) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `segnaliammo`.`servizi`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `segnaliammo`.`servizi` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `segnaliammo`.`utilizzatori`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `segnaliammo`.`utilizzatori` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(64) NULL ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(40) NULL ,
  `scadenza_password` DATETIME NULL ,
  `ultimo_login` DATETIME NULL ,
  `attivo` TINYINT(1) NULL ,
  `cognome` VARCHAR(45) NULL ,
  `nome` VARCHAR(45) NULL ,
  `telefono` VARCHAR(20) NULL ,
  `cellulare` VARCHAR(20) NULL ,
  `servizi_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_utilizzatori_servizi1_idx` (`servizi_id` ASC) ,
  CONSTRAINT `fk_utilizzatori_servizi1`
    FOREIGN KEY (`servizi_id` )
    REFERENCES `segnaliammo`.`servizi` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `segnaliammo`.`segnalazioni`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `segnaliammo`.`segnalazioni` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `numero` VARCHAR(45) NULL ,
  `priorita` VARCHAR(10) NULL ,
  `status` VARCHAR(45) NULL ,
  `data_creazione` DATETIME NULL ,
  `data_status` DATETIME NULL ,
  `oggetto` VARCHAR(256) NULL ,
  `descrizione` TEXT NULL ,
  `note` TEXT NULL ,
  `categorie_id` INT NOT NULL ,
  `operatori_id` INT NULL ,
  `utilizzatori_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_segnalazioni_categorie1_idx` (`categorie_id` ASC) ,
  INDEX `fk_segnalazioni_operatori1_idx` (`operatori_id` ASC) ,
  INDEX `fk_segnalazioni_utilizzatori1_idx` (`utilizzatori_id` ASC) ,
  CONSTRAINT `fk_segnalazioni_categorie1`
    FOREIGN KEY (`categorie_id` )
    REFERENCES `segnaliammo`.`categorie` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_segnalazioni_operatori1`
    FOREIGN KEY (`operatori_id` )
    REFERENCES `segnaliammo`.`operatori` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_segnalazioni_utilizzatori1`
    FOREIGN KEY (`utilizzatori_id` )
    REFERENCES `segnaliammo`.`utilizzatori` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `segnaliammo`.`amministratori`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `segnaliammo`.`amministratori` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(64) NULL ,
  `username` VARCHAR(45) NULL ,
  `password` VARCHAR(40) NULL ,
  `scadenza_password` DATETIME NULL ,
  `ultimo_login` DATETIME NULL ,
  `attivo` TINYINT(1) NULL ,
  `cognome` VARCHAR(45) NULL ,
  `nome` VARCHAR(45) NULL ,
  `telefono` VARCHAR(20) NULL ,
  `cellulare` VARCHAR(20) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

USE `segnaliammo` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
