-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema sns_bdd
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sns_bdd
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sns_bdd` DEFAULT CHARACTER SET utf8 ;
USE `sns_bdd` ;

-- -----------------------------------------------------
-- Table `sns_bdd`.`installation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sns_bdd`.`installation` (
  `id` INT NOT NULL,
  `nom` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sns_bdd`.`son`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sns_bdd`.`son` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `niveau` INT NOT NULL,
  `date` VARCHAR(45) NULL,
  `temps` VARCHAR(45) NULL,
  `installation_id` INT NOT NULL,
  PRIMARY KEY (`id`, `installation_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_son_installation1_idx` (`installation_id` ASC) ,
  CONSTRAINT `fk_son_installation1`
    FOREIGN KEY (`installation_id`)
    REFERENCES `sns_bdd`.`installation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sns_bdd`.`utilisateur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sns_bdd`.`utilisateur` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `prenom` VARCHAR(45) NOT NULL,
  `nom` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `auth` ENUM("admin", "user") NOT NULL,
  `identifiant` VARCHAR(45) NOT NULL,
  `image` VARCHAR(8000) NOT NULL,
  `installation_id` INT NOT NULL,
  PRIMARY KEY (`id`, `installation_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `mail_UNIQUE` (`identifiant` ASC) ,
  INDEX `fk_utilisateur_installation1_idx` (`installation_id` ASC) ,
  CONSTRAINT `fk_utilisateur_installation1`
    FOREIGN KEY (`installation_id`)
    REFERENCES `sns_bdd`.`installation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sns_bdd`.`message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sns_bdd`.`message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `alerte` VARCHAR(45) NULL,
  `type` VARCHAR(45) NULL,
  `couleur` VARCHAR(45) NULL,
  `installation_id` INT NOT NULL,
  PRIMARY KEY (`id`, `installation_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_message_installation1_idx` (`installation_id` ASC) ,
  CONSTRAINT `fk_message_installation1`
    FOREIGN KEY (`installation_id`)
    REFERENCES `sns_bdd`.`installation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sns_bdd`.`curseur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sns_bdd`.`curseur` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(45) NULL,
  `valeur` INT NULL,
  `installation_id` INT NOT NULL,
  PRIMARY KEY (`id`, `installation_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_curseur_installation1_idx` (`installation_id` ASC) ,
  CONSTRAINT `fk_curseur_installation1`
    FOREIGN KEY (`installation_id`)
    REFERENCES `sns_bdd`.`installation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sns_bdd`.`frequence`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sns_bdd`.`frequence` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `valeur` INT NULL,
  `installation_id` INT NOT NULL,
  PRIMARY KEY (`id`, `installation_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_frequence_installation1_idx` (`installation_id` ASC) ,
  CONSTRAINT `fk_frequence_installation1`
    FOREIGN KEY (`installation_id`)
    REFERENCES `sns_bdd`.`installation` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sns_bdd`.`installation`
-- -----------------------------------------------------
START TRANSACTION;
USE `sns_bdd`;
INSERT INTO `sns_bdd`.`installation` (`id`, `nom`) VALUES (1, 'SN');
INSERT INTO `sns_bdd`.`installation` (`id`, `nom`) VALUES (2, 'SIO');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sns_bdd`.`son`
-- -----------------------------------------------------
START TRANSACTION;
USE `sns_bdd`;
INSERT INTO `sns_bdd`.`son` (`id`, `niveau`, `date`, `temps`, `installation_id`) VALUES (1, 28, '20/01/2022', '10:00:00', 1);
INSERT INTO `sns_bdd`.`son` (`id`, `niveau`, `date`, `temps`, `installation_id`) VALUES (2, 32, '20/01/2022', '10:01:00', 1);
INSERT INTO `sns_bdd`.`son` (`id`, `niveau`, `date`, `temps`, `installation_id`) VALUES (3, 44, '20/01/2022', '10:02:00', 1);
INSERT INTO `sns_bdd`.`son` (`id`, `niveau`, `date`, `temps`, `installation_id`) VALUES (4, 36, '20/01/2022', '10:03:00', 1);
INSERT INTO `sns_bdd`.`son` (`id`, `niveau`, `date`, `temps`, `installation_id`) VALUES (5, 45, '20/01/2022', '10:04:00', 1);
INSERT INTO `sns_bdd`.`son` (`id`, `niveau`, `date`, `temps`, `installation_id`) VALUES (6, 57, '20/01/2022', '10:05:00', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sns_bdd`.`utilisateur`
-- -----------------------------------------------------
START TRANSACTION;
USE `sns_bdd`;
INSERT INTO `sns_bdd`.`utilisateur` (`id`, `prenom`, `nom`, `password`, `auth`, `identifiant`, `image`, `installation_id`) VALUES (1, 'Jean', 'Martin', '', 'user', 'jeanmartin', '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', 1);
INSERT INTO `sns_bdd`.`utilisateur` (`id`, `prenom`, `nom`, `password`, `auth`, `identifiant`, `image`, `installation_id`) VALUES (2, 'Aline', 'Dubois', '', 'admin', 'alinedubois', '/9j/4AAQSkZJRgABAQEBLAEsAAD/4QC8RXhpZgAASUkqAAgAAAAGABIBAwABAAAAAQAAABoBBQABAAAAVgAAABsBBQABAAAAXgAAACgBAwABAAAAAgAAABMCAwABAAAAAQAAAGmHBAABAAAAZgAAAAAAAAAsAQAAAQAAACwBAAABAAAABgAAkAcABAAAADAyMTABkQcABAAAAAECAwAAoAcABAAAADAxMDABoAMAAQAAAP//AAACoAQAAQAAAOgDAAADoAQAAQAAAJsCAAAAAAAA/9sAQwBQNzxGPDJQRkFGWlVQX3jIgnhubnj1r7mRyP///////////////////////////////////////////////////9sAQwFVWlp4aXjrgoLr/////////////////////////////////////////////////////////////////////////8IAEQgBKgHAAwEiAAIRAQMRAf/EABgAAQEBAQEAAAAAAAAAAAAAAAABAgME/8QAFgEBAQEAAAAAAAAAAAAAAAAAAAEC/9oADAMBAAIQAxAAAAHqEk1DMuTMsAgCihYlBZQBQASwSiSjOdRWs1dJE3Js5gsFY0JdCXA1Aax0JZTsLmEGNZMyiCAKUAKAFUilgRLACAzKUllikms6qLFiwpogMy1JYWoJblPULJLkmbCLIiwWUVQAolBUWpVSxkCAAmN5llltqkxqaVNDDWS1BKJLBc1GbK1JT1ERm5MiEsEoAtlFAAoZ1lpc6izUsgSLAsWY1IzvNq6zozrJdMjXPQaUy0OYJZAaTCq9JEZ1kkshLAADVm6y1IAAZ1mazqQ6zO7MrAAQznfONWKLYZ3ldTUrJk6saLELZo553kVTMtOwuZnWSSyEsBCpS7xV1cVasQBLDKWam8aTUssAAmLk1NQmpqJVVNZpjULFIuTZkZ3g1cbJA7JLm5shLBLBLBZRZSylb52XaTUuLJYompDZUiiTQ5zfONyyqzqNEWyKsuYazqkuDS4N51DG+ewuToGUsEsEsEsFlFlFgudGllGdZLnWDbOiyw0hIFmN4TbWIm+fQspc2arC5jdipENxSAwoXG01YSwEoksEolBZQUgNBqKliwQRrNpUQUnPpzNVCbzuUKzGU3KXO8Q1GikNZshCprOwlZAAkogUBRFlAJvO1MludyMLBShS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', 1);
INSERT INTO `sns_bdd`.`utilisateur` (`id`, `prenom`, `nom`, `password`, `auth`, `identifiant`, `image`, `installation_id`) VALUES (3, 'Jacques', 'Beaux', '', 'user', 'jacquesbeaux', '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDADUlKC8oITUvKy88OTU/UIVXUElJUKN1e2GFwarLyL6qurfV8P//1eL/5re6////////////zv//////////////2wBDATk8PFBGUJ1XV53/3Lrc////////////////////////////////////////////////////////////////////wgARCAEpAN4DASIAAhEBAxEB/8QAGAABAQEBAQAAAAAAAAAAAAAAAAECAwT/xAAWAQEBAQAAAAAAAAAAAAAAAAAAAQL/2gAMAwEAAhADEAAAAeyYzerluzeNYlWZNuea6vPTtmdTlOxOE9CuPfEO3nnOvS46zZaN2WMct5q9PPo6Y5jUhNQCK3189PS5dIq4N46+erysLcDpeQ63ii3NEQKBQQKIK314bjv5+nCtTIWCwAALZqXK5KEFJem15usl4zriySxMtZoAlEsAKgtmpYEXPVXSal0CEhnUOc64svD0cKzYsAAAAupZTW453pzOlzpdWCzPJOkzo1KVx68UwNQAACWDp0u8azbTOOvOya5K7Xl0jF3Fzukk1mXPPos87tLOTpKw1kgLA9dzMa6Zxmzd5aNc95rSo6SxalGNZiJaZ0TOfRzucGTWLlU1a3lM2lFAaM6Q2502xpbm4RYLZTes3WbjSOHP1l8jvwra7zeWtiW1JSxnWayuZda56lYClLrHSy2WyUJYipTlozsLBNZqCykZ2OM65mpNSWgvTG9ZWCxCpSojMmc71cLOkkstk1NpZKQY3makslqdKouKFZ1kqUqU4prO01lLnWSzM1ntrh1NBAMSprWrLAQRbkKgoOQzupEuLmxevU8nS867a56TQGaS3FNQWJCs6FUlDlZM7shJ6LQI5+f1eXU63O7Fg1JQQ1JREFzk2yl1rFXOZod6gqIBx7K8+zWVgsABAAi5ltmpSDHoUCKlIKGTml1KhLFACACSyW1ZYo6iBCznyrvjks1kres6AQACoBTMqWpZasl6HOy88ywqgIU1QtlJNQXNQZXSaSTWZqpZbcw//8QAIRAAAQMFAQEBAQEAAAAAAAAAAQAQEQISIDBAMSFBIlD/2gAIAQEAAQUC1woCtVqtLg/ZDT/QMsUMJVynCVcrmlAmcfitR+NT6wDlwiVdmCpxA+GFUG8Uq5XK5CpfCrVCnWHK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', 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sns_bdd`.`message`
-- -----------------------------------------------------
START TRANSACTION;
USE `sns_bdd`;
INSERT INTO `sns_bdd`.`message` (`id`, `alerte`, `type`, `couleur`, `installation_id`) VALUES (DEFAULT, 'Bien !', 'vert', '#B2FFC8', 1);
INSERT INTO `sns_bdd`.`message` (`id`, `alerte`, `type`, `couleur`, `installation_id`) VALUES (DEFAULT, 'Attention !', 'orange', '#FFDF8C', 1);
INSERT INTO `sns_bdd`.`message` (`id`, `alerte`, `type`, `couleur`, `installation_id`) VALUES (DEFAULT, 'Trop Fort !', 'rouge', '#FF6666', 1);
INSERT INTO `sns_bdd`.`message` (`id`, `alerte`, `type`, `couleur`, `installation_id`) VALUES (DEFAULT, 'Calme !', 'vert', '#B2FFC8', 2);
INSERT INTO `sns_bdd`.`message` (`id`, `alerte`, `type`, `couleur`, `installation_id`) VALUES (DEFAULT, 'Attention !', 'orange', '#FFDF8C', 2);
INSERT INTO `sns_bdd`.`message` (`id`, `alerte`, `type`, `couleur`, `installation_id`) VALUES (DEFAULT, 'Trop Bruyant !', 'rouge', '#FF6666', 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sns_bdd`.`curseur`
-- -----------------------------------------------------
START TRANSACTION;
USE `sns_bdd`;
INSERT INTO `sns_bdd`.`curseur` (`id`, `type`, `valeur`, `installation_id`) VALUES (DEFAULT, 'maximum', 64, 1);
INSERT INTO `sns_bdd`.`curseur` (`id`, `type`, `valeur`, `installation_id`) VALUES (DEFAULT, 'minimum', 22, 1);
INSERT INTO `sns_bdd`.`curseur` (`id`, `type`, `valeur`, `installation_id`) VALUES (DEFAULT, 'minimum', 14, 2);
INSERT INTO `sns_bdd`.`curseur` (`id`, `type`, `valeur`, `installation_id`) VALUES (DEFAULT, 'maximum', 46, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `sns_bdd`.`frequence`
-- -----------------------------------------------------
START TRANSACTION;
USE `sns_bdd`;
INSERT INTO `sns_bdd`.`frequence` (`id`, `valeur`, `installation_id`) VALUES (DEFAULT, 1, 1);
INSERT INTO `sns_bdd`.`frequence` (`id`, `valeur`, `installation_id`) VALUES (DEFAULT, 2, 2);

COMMIT;

