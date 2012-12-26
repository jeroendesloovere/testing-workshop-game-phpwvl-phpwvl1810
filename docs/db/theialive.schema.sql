--
-- Create a table to store accounts
-- 
DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
    `accountId` INT NOT NULL UNSIGNED AUTO_INCREMENT,
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
-- Create a table to store projects
--
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
    `projectId` INT NOT NULL UNSIGNED AUTO_INCREMENT,
    `projectName` VARCHAR(50) NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY `projectId`
    UNIQUE KEY `projectNameUk`
);

--
-- Create a table to store tasks
--
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
    `taskId` INT NOT NULL AUTO_INCREMENT,
    `taskLabel` INT NOT NULL,
    `created` TIMESTAMP NOT NULL,
    `modified` TIMESTAMP NOT NULL,
    PRIMARY KEY (`taskId`)
);