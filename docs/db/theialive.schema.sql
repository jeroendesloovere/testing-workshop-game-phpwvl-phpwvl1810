--
-- Disable foreign key checks
--
SET FOREIGN_KEY_CHECKS=0;
--
-- Create a table to store accounts
-- 
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
    `accountId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `firstName` VARCHAR(45) NOT NULL,
    `lastName` VARCHAR(45) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password` CHAR(13) NOT NULL,
    `token` CHAR(42) NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    `active` TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`accountId`),
    UNIQUE KEY `accountEmailUk` (`email`),
    INDEX `accountTokenIdx` (`token`)
);

--
-- Creating a group table for managing accounts
--
DROP TABLE IF EXISTS `group`;
CREATE TABLE `group` (
    `groupId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `groupName` VARCHAR(150) NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`groupId`),
    UNIQUE KEY `groupNameUk` (`groupName`)
);

--
-- Create a table to store projects
--
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
    `projectId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `projectName` VARCHAR(50) NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`projectId`),
    UNIQUE KEY `projectNameUk` (`projectName`)
);

--
-- Create a table to store tasks
--
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
    `taskId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `taskLabel` INT NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`taskId`)
);

--
-- Assigns an account to a group
--
DROP TABLE IF EXISTS `groupAccount`;
CREATE TABLE `groupAccount` (
    `groupId` INT UNSIGNED NOT NULL,
    `accountId` INT UNSIGNED NOT NULL,
    FOREIGN KEY `groupIdFk`(`groupId`) 
        REFERENCES `group`(`groupId`),
    FOREIGN KEY `accountIdFk`(`accountId`) 
        REFERENCES `account`(`accountId`)
) ENGINE=InnoDb;

--
-- Assigns a task to a project
--
DROP TABLE IF EXISTS `projectTask`;
CREATE TABLE `projectTask` (
    `projectId` INT UNSIGNED NOT NULL,
    `taskId` INT UNSIGNED NOT NULL,
    FOREIGN KEY `projectIdFk` (`projectId`)
        REFERENCES `project`(`projectId`),
    FOREIGN KEY `taskIdFk` (`taskId`)
        REFERENCES `task` (`taskId`)
) ENGINE=InnoDb;

--
-- Assigns a project to a group
--
DROP TABLE IF EXISTS `groupProject`;
CREATE TABLE `groupProject` (
    `groupId` INT UNSIGNED NOT NULL,
    `projectId` INT UNSIGNED NOT NULL,
    FOREIGN KEY `groupIdFk` (`groupId`) 
        REFERENCES `group` (`groupId`),
    FOREIGN KEY `projectIdFk` (`projectId`) 
        REFERENCES `project` (`projectId`)
) ENGINE=InnoDb;

--
-- Assigns a task to an account
--
DROP TABLE IF EXISTS `taskAccount`;
CREATE TABLE `taskAccount` (
    `taskId` INT UNSIGNED NOT NULL,
    `accountId` INT UNSIGNED NOT NULL,
    FOREIGN KEY `taskIdFk` (`taskId`)
        REFERENCES `task` (`taskId`),
    FOREIGN KEY `accountIdFk`(`accountId`) 
        REFERENCES `account`(`accountId`)
) ENGINE=InnoDb;

--
-- Storing Session data in the database
--
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
--
-- Enable foreign key checks
--
SET FOREIGN_KEY_CHECKS=1;