SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `localdb`.`tbl_cam`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `localdb`.`tbl_cam` ;

CREATE  TABLE IF NOT EXISTS `localdb`.`tbl_cam` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `Name` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`tbl_cam_calibration`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `localdb`.`tbl_cam_calibration` ;

CREATE  TABLE IF NOT EXISTS `localdb`.`tbl_cam_calibration` (
  `idCam` INT NOT NULL ,
  `intrinsic_file_location` VARCHAR(200) NOT NULL ,
  `distortion_file_location` VARCHAR(200) NOT NULL ,
  `frame_width` INT NOT NULL DEFAULT 640 ,
  `frame_height` INT NOT NULL DEFAULT 480 ,
  PRIMARY KEY (`idCam`) ,
  INDEX `id` (`idCam` ASC) ,
  CONSTRAINT `id`
    FOREIGN KEY (`idCam` )
    REFERENCES `localdb`.`tbl_cam` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`tbl_homographic_matrices`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `localdb`.`tbl_homographic_matrices` ;

CREATE  TABLE IF NOT EXISTS `localdb`.`tbl_homographic_matrices` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `homography_file_location` VARCHAR(200) NOT NULL ,
  `idCam` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tbl_homographic_matrices_1` (`idCam` ASC) ,
  CONSTRAINT `fk_tbl_homographic_matrices_1`
    FOREIGN KEY (`idCam` )
    REFERENCES `localdb`.`tbl_cam` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`tbl_customers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `localdb`.`tbl_customers` ;

CREATE  TABLE IF NOT EXISTS `localdb`.`tbl_customers` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `Todoidentifier` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`tbl_tracking_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `localdb`.`tbl_tracking_data` ;

CREATE  TABLE IF NOT EXISTS `localdb`.`tbl_tracking_data` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idCustomer` INT NOT NULL ,
  `idCam` INT NOT NULL ,
  `timestamp` DATETIME NOT NULL ,
  `x` DOUBLE NOT NULL ,
  `y` DOUBLE NOT NULL ,
  `transformed` VARCHAR(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tbl_tracking_data_1` (`idCustomer` ASC) ,
  INDEX `fk_tbl_tracking_data_2` (`idCam` ASC) ,
  CONSTRAINT `fk_tbl_tracking_data_1`
    FOREIGN KEY (`idCustomer` )
    REFERENCES `localdb`.`tbl_customers` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tbl_tracking_data_2`
    FOREIGN KEY (`idCam` )
    REFERENCES `localdb`.`tbl_cam` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `localdb`.`tbl_clean_data`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `localdb`.`tbl_clean_data` ;

CREATE  TABLE IF NOT EXISTS `localdb`.`tbl_clean_data` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idCustomer` INT NOT NULL ,
  `x` DOUBLE NOT NULL ,
  `y` DOUBLE NOT NULL ,
  `timestamp` DATETIME NOT NULL ,
  `synchronized` VARCHAR(1) NOT NULL DEFAULT '0' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_tbl_clean_data_1` (`idCustomer` ASC) ,
  CONSTRAINT `fk_tbl_clean_data_1`
    FOREIGN KEY (`idCustomer` )
    REFERENCES `localdb`.`tbl_customers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
