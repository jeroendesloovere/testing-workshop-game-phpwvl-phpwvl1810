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
    PRIMARY KEY (`taskId`),
    INDEX `task_title_idx` (`title`)
);
