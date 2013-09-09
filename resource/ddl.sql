CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id_relation_sequence_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_email_password` (`name`,`email`,`password`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_id_relations`
--

CREATE TABLE IF NOT EXISTS `user_id_relations` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `hash_id` varchar(64) NOT NULL,
  `hash_id_dec` bigint(20) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash_id` (`hash_id`),
  UNIQUE KEY `hash_id_dec` (`hash_id_dec`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_each_platform_authentications`
--

CREATE TABLE IF NOT EXISTS `user_each_platform_authentications` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `platform_id` int(11) DEFAULT NULL,
  `platform_user_id` varchar(255) DEFAULT NULL,
  `auth_token` varchar(64) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `platform_id_auth_token` (`platform_id`,`auth_token`),
  UNIQUE KEY `platform_id_and_user_id` (`platform_id`,`user_id`),
  UNIQUE KEY `platform_id_platform_user_id` (`platform_id`,`platform_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_role_id` (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE IF NOT EXISTS `user_devices` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `devide_id` varchar(255) NOT NULL,
  `devide_id_dec` bigint(20) unsigned NOT NULL,
  `device_token` varchar(255) NOT NULL,
  `os_type_id` int(11) NOT NULL,
  `last_login_datetime` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `os_type_id_device_id` (`os_type_id`,`devide_id`),
  UNIQUE KEY `os_type_id_device_id_dec` (`os_type_id`,`devide_id_dec`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;