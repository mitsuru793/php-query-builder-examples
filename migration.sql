DROP TABLE IF EXISTS `users`, `posts`;

CREATE TABLE `users` (
  `id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `posts` (
  `id` INT(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` INT(11) unsigned NOT NULL,
  `title` VARCHAR(255) DEFAULT '',
  `content` VARCHAR(140) DEFAULT '',
  `status` INT(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
