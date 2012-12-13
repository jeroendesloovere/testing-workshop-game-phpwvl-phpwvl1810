--
-- Account details
--
CREATE TABLE `account` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `email` VARCHAR(150) NOT NULL,
    `password` CHAR(40) NOT NULL,
    `created` DATETIME NOT NULL,
    `modified` DATETIME NOT NULL,
    `active` TINYINT(1) NOT NULL DEFAULT 0,
    `token` CHAR(40) NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `account_email_uk` (`email`)
) ENGINE=MyIsam CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';