DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
    `accountId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `firstName` VARCHAR(45) NOT NULL,
    `lastName` VARCHAR(45) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password` CHAR(40) NOT NULL,
    `token` CHAR(42) NULL,
    `active` TINYINT(1) NOT NULL DEFAULT 0,
    `reset` TINYINT(1) NOT NULL DEFAULT 0,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`accountId`),
    UNIQUE KEY `account_email_uk` (`email`)
);

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
    `projectId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `accountId` INT UNSIGNED NOT NULL,
    `projectName` VARCHAR(45) NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`projectId`),
    INDEX `project_name_idx` (`projectName`)
);

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
    `taskId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `projectId` INT UNSIGNED NOT NULL,
    `accountId` INT UNSIGNED NOT NULL,
    `title` VARCHAR(45) NOT NULL,
    `description` TEXT NULL,
    `dueDate` TIMESTAMP NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    `done` TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`taskId`),
    INDEX `task_title_idx` (`title`)
);

DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
    `teamId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NULL,
    `description` TEXT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`teamId`),
    INDEX `team_name_idx` (`name`)
);

DROP TABLE IF EXISTS `team_account`;
CREATE TABLE `team_account` (
    `teamId` INT UNSIGNED NOT NULL,
    `accountId` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`teamId`, `accountId`)
);

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `sessionId` char(32) NOT NULL,
  `savePath` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL DEFAULT '',
  `modified` int(10) unsigned DEFAULT NULL,
  `lifetime` int(10) unsigned DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`sessionId`,`savePath`,`name`)
);
