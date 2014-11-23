ALTER TABLE `#__workerstatus_businesses` DROP COLUMN `cid`;

ALTER TABLE `#__workerstatus_persons` DROP COLUMN `cid`;

ALTER TABLE `#__workerstatus_workerstatuses` DROP COLUMN `cid`;

ALTER TABLE `#__workerstatus_businesses` ADD COLUMN `rules` text;

ALTER TABLE `#__workerstatus_persons` ADD COLUMN `rules` text;

ALTER TABLE `#__workerstatus_workerstatuses` ADD COLUMN `rules` text;