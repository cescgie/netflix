CREATE TABLE `new_releases` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `movie_date` varchar(256) DEFAULT NULL,
  `movie_title` varchar(256) DEFAULT NULL,
  `movie_description` varchar(1024) NULL,
  `movie_genres` varchar(256) DEFAULT NULL,
  `movie_image` varchar(1024) DEFAULT NULL,
  `movie_year` int(10) unsigned NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;