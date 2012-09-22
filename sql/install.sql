SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

-- -----------------------------------------------------
-- Table `plugin_vgcardutils_logs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_logs` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  `card_id` INT(11) NOT NULL ,
  `type` INT(11) NOT NULL ,
  `data` TEXT NOT NULL ,
  `time` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 4735
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_cards`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_cards` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT 'id' ,
  `serial` VARCHAR(45) NOT NULL ,
  `title` VARCHAR(45) NOT NULL COMMENT '卡牌名称' ,
  `subtitle` VARCHAR(255) NOT NULL ,
  `unitType` INT(11) NOT NULL ,
  `expansion_id` INT(11) NOT NULL ,
  `grade` INT(11) NOT NULL COMMENT '等级' ,
  `power` INT(11) NOT NULL COMMENT '能力' ,
  `shield` INT(11) NOT NULL COMMENT '盾护' ,
  `critical` INT(11) NOT NULL COMMENT '会心' ,
  `trigger` INT(11) NOT NULL ,
  `clan_id` INT(11) NOT NULL COMMENT '集团' ,
  `rarity_id` INT(11) NOT NULL ,
  `race_id` INT(11) NOT NULL COMMENT '种族' ,
  `skill` INT(11) NOT NULL COMMENT '技能描述' ,
  `effect` TEXT NOT NULL COMMENT '特技' ,
  `flavorText` VARCHAR(255) NOT NULL ,
  `illustrator` VARCHAR(45) NOT NULL ,
  `remark` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `card_no_UNIQUE` (`serial` ASC) )
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_clans`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_clans` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nation_id` INT(11) NOT NULL ,
  `title` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_expansions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_expansions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_nations`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_nations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_races`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_races` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 40
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_rarities`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_rarities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_tagmaps`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_tagmaps` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `tag_id` INT(11) NOT NULL ,
  `card_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 7447
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils_tags`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils_tags` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 38
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `plugin_vgcardutils`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `plugin_vgcardutils` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `value` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
