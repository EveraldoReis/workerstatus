ALTER TABLE `#__cardapio_categories` DROP COLUMN `cid`;

ALTER TABLE `#__cardapio_items` DROP COLUMN `cid`;

ALTER TABLE `#__cardapio_cardapios` DROP COLUMN `cid`;

ALTER TABLE `#__cardapio_categories` ADD COLUMN `rules` text;

ALTER TABLE `#__cardapio_items` ADD COLUMN `rules` text;

ALTER TABLE `#__cardapio_cardapios` ADD COLUMN `rules` text;