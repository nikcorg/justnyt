CREATE TABLE `visit`(
    `visit_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `recorded_on` DATETIME NOT NULL,
    `visitor_id` VARCHAR (32) NOT NULL,
    `recommendation_id` INT UNSIGNED,

    PRIMARY KEY (`visit_id`),

    CONSTRAINT `visit_recommendation_id`
        FOREIGN KEY (`recommendation_id`) REFERENCES `recommendation` (`recommendation_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;

ALTER TABLE recommendation DROP COLUMN `visits`;
