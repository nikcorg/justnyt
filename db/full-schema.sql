-- CREATE TABLE `curator` (
-- ) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;
-- SET NAMES 'utf8' COLLATE 'utf8_general_ci'


CREATE TABLE `profile` (
    `profile_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `alias` VARCHAR (80) NOT NULL,
    `homepage` VARCHAR (255),
    `email` VARCHAR (255),
    `image` VARCHAR (40),
    `description` TEXT,

    PRIMARY KEY (`profile_id`),

    CONSTRAINT `profile_unique_email`
        UNIQUE INDEX (`email`)
) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;



CREATE TABLE `candidate` (
    `candidate_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `created_on` DATETIME NOT NULL,
    `invited_on` DATETIME,
    `invite_redacted_on` DATETIME,
    `invites_sent` INT UNSIGNED DEFAULT 0,
    `email` VARCHAR (255) NOT NULL,

    PRIMARY KEY (`candidate_id`)
) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;



CREATE TABLE `curator` (
    `curator_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `candidate_id` INT UNSIGNED,
    `profile_id` INT UNSIGNED,
    `token` VARCHAR (32) NOT NULL,
    `invite_token` VARCHAR (32) NOT NULL,
    `created_on` DATETIME,
    `activated_on` DATETIME,
    `deactivated_on` DATETIME,

    PRIMARY KEY (`curator_id`),

    CONSTRAINT `curator_token`
        UNIQUE INDEX (`token`),

    CONSTRAINT `curator_candidate_id`
        FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`candidate_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    CONSTRAINT `curator_profile_id`
        FOREIGN KEY (`profile_id`) REFERENCES `profile` (`profile_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    INDEX `curator_activated_on` USING BTREE (`activated_on` DESC)
) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;



CREATE TABLE `recommendation` (
    `recommendation_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `curator_id` INT UNSIGNED,
    `recommendation_hint_id` INT UNSIGNED,
    `created_on` DATETIME,
    `scraped_on` DATETIME,
    `approved_on` DATETIME,
    `graphic_content` TINYINT(1) DEFAULT 0,
    `shortlink` VARCHAR (32),
    `url` VARCHAR (1024),
    `title` VARCHAR (512),
    `quote` VARCHAR (512),

    PRIMARY KEY (`recommendation_id`),

    CONSTRAINT `recommendation_curator_id`
        FOREIGN KEY (`curator_id`) REFERENCES `curator` (`curator_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    CONSTRAINT `recommendation_recommendation_hint_id`
        FOREIGN KEY (`recommendation_hint_id`) REFERENCES `recommendation_hint` (`recommendation_hint_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    CONSTRAINT `recommendation_shortlink`
        UNIQUE INDEX (`shortlink`),

    INDEX `recommendation_created_on` USING BTREE (`created_on` DESC)

) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;



CREATE TABLE `recommendation_hint` (
    `recommendation_hint_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `created_on` DATETIME,
    `url` VARCHAR (1024) NOT NULL,
    `alias` VARCHAR (50),

    PRIMARY KEY (`recommendation_hint_id`)
) ENGINE=INNODB DEFAULT CHARACTER SET=utf8;



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
