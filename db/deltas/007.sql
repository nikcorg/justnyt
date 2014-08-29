ALTER TABLE `candidate`
    ADD COLUMN `invite_redacted_on` DATETIME AFTER `invited_on`;
ALTER TABLE `candidate`
    ADD COLUMN `invites_sent` INT UNSIGNED DEFAULT 0 AFTER `invite_redacted_on`;
