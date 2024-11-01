CREATE TABLE IF NOT EXISTS `tinycarousel_gallery` (
  `gal_id` INT unsigned NOT NULL AUTO_INCREMENT,
  `gal_title` VARCHAR(255) NOT NULL,
  `gal_width` INT unsigned NOT NULL default '200',
  `gal_height` INT unsigned NOT NULL default '150',
  `gal_controls` VARCHAR(5) NOT NULL default 'true',
  `gal_autointerval` VARCHAR(5) NOT NULL default 'true',
  `gal_intervaltime` INT unsigned NOT NULL default '1500',
  `gal_animation` INT unsigned NOT NULL default '1000',
  `gal_random` VARCHAR(5) NOT NULL default 'YES',
  `gal_arrowcolor` VARCHAR(10) NOT NULL default '#C01313',
  PRIMARY KEY (`gal_id`)
) ENGINE=MyISAM /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;

-- SQLQUERY ---

CREATE TABLE IF NOT EXISTS `tinycarousel_image` (
  `img_id` INT unsigned NOT NULL AUTO_INCREMENT,
  `img_title` VARCHAR(255) NOT NULL,
  `img_imageurl` VARCHAR(1024) NOT NULL,
  `img_link` VARCHAR(1024) NOT NULL default '#',
  `img_linktarget` VARCHAR(10) NOT NULL default '_blank',
  `img_display` VARCHAR(5) NOT NULL default 'YES',
  `img_gal_id` INT unsigned NOT NULL,
  `img_expiration` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`img_id`)
) ENGINE=MyISAM /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci*/;