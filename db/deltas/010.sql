ALTER TABLE `recommendation_hint`
    ADD COLUMN `dropped_on` DATETIME AFTER `created_on`
;

ALTER TABLE `recommendation_hint`
    ADD COLUMN `dropped_by` INT UNSIGNED AFTER `dropped_on`,
    ADD CONSTRAINT `recommendation_hint_dropped_by`
        FOREIGN KEY (`dropped_by`) REFERENCES `curator` (`curator_id`)
        ON UPDATE CASCADE
        ON DELETE SET NULL
;
