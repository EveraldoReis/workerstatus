ALTER TABLE `#__workerstatus_businesses` ADD COLUMN `views` int(11);
ALTER TABLE `#__workerstatus_businesses` ADD COLUMN `track_views` tinyint(1) DEFAULT 0;

ALTER TABLE `#__workerstatus_persons` ADD COLUMN `views` int(11);
ALTER TABLE `#__workerstatus_persons` ADD COLUMN `track_views` tinyint(1) DEFAULT 0;

ALTER TABLE `#__workerstatus_workerstatuses` ADD COLUMN `views` int(11);
ALTER TABLE `#__workerstatus_workerstatuses` ADD COLUMN `track_views` tinyint(1) DEFAULT 0;