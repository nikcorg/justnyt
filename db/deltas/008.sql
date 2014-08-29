CREATE TABLE `recommendation_hint` (
    `recommendation_hint_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `created_on` DATETIME,
    `url` VARCHAR (1024) NOT NULL,
    `alias` VARCHAR (50),

    PRIMARY KEY (`recommendation_hint_id`)
) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;

ALTER TABLE `recommendation` ADD COLUMN `recommendation_hint_id` INT UNSIGNED AFTER `curator_id`,
    ADD CONSTRAINT `recommendation_recommendation_hint_id`
        FOREIGN KEY (`recommendation_hint_id`) REFERENCES `recommendation_hint` (`recommendation_hint_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL;
