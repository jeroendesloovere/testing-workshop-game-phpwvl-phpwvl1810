DROP TABLE IF EXISTS `account`;
CREATE TABLE `account` (
    `accountId` INTEGER NOT NULL primary key,
    `firstName` TEXT NOT NULL,
    `lastName` TEXT NOT NULL,
    `email` TEXT NOT NULL,
    `password` TEXT NOT NULL,
    `token` TEXT,
    `active` INTEGER NOT NULL,
    `reset` INTEGER NOT NULL,
    `created` TEXT NOT NULL,
    `modified` TEXT NOT NULL
);

DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
    `projectId` INTEGER NOT NULL PRIMARY KEY,
    `accountId` INTEGER NOT NULL,
    `projectName` TEXT NOT NULL,
    `created` TEXT NOT NULL,
    `modified` TEXT NOT NULL
);

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
    `taskId` INTEGER NOT NULL PRIMARY KEY,
    `projectId` INTEGER NOT NULL,
    `accountId` INTEGER NOT NULL,
    `title` TEXT NOT NULL,
    `description` TEXT NULL,
    `dueDate` TEXT NOT NULL,
    `created` TEXT NOT NULL,
    `modified` TEXT NOT NULL
);

DROP TABLE IF EXISTS `team`;
CREATE TABLE `team` (
    `teamId` INTEGER NOT NULL PRIMARY KEY,
    `name` TEXT,
    `description` TEXT,
    `created` TEXT NOT NULL,
    `modified` TEXT NOT NULL
);

DROP TABLE IF EXISTS `team_account`;
CREATE TABLE `team_account` (
    `teamId` INTEGER NOT NULL PRIMARY KEY,
    `accountId` INTEGER NOT NULL
);

DROP TABLE IF EXISTS `session`;
CREATE TABLE `session` (
  `sessionId` TEXT NOT NULL PRIMARY KEY,
  `savePath` TEXT NOT NULL,
  `name` TEXT NOT NULL,
  `modified` INTEGER,
  `lifetime` INTEGER,
  `data` TEXT
);
