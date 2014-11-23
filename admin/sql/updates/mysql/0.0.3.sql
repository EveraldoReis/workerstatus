ALTER TABLE `#__cardapio_categories` ADD COLUMN `views` int(11);
ALTER TABLE `#__cardapio_categories` ADD COLUMN `track_views` tinyint(1) DEFAULT 0;

ALTER TABLE `#__cardapio_items` ADD COLUMN `views` int(11);
ALTER TABLE `#__cardapio_items` ADD COLUMN `track_views` tinyint(1) DEFAULT 0;

ALTER TABLE `#__cardapio_cardapios` ADD COLUMN `views` int(11);
ALTER TABLE `#__cardapio_cardapios` ADD COLUMN `track_views` tinyint(1) DEFAULT 0;