ALTER TABLE `profile` ADD COLUMN `email` VARCHAR (255) DEFAULT NULL AFTER `homepage`;

ALTER TABLE `curator` ADD COLUMN `deactivated_on` DATETIME AFTER `activated_on`;
