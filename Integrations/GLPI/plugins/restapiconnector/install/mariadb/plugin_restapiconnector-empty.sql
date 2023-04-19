DROP TABLE IF EXISTS `glpi_plugin_restapiconnector_configs`;

CREATE TABLE `glpi_plugin_restapiconnector_configs` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `type` varchar(255) DEFAULT NULL,
    `value` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unicity` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `glpi_plugin_restapiconnector_endpoints`;

CREATE TABLE `glpi_plugin_restapiconnector_endpoints` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `entities_id` int unsigned NOT NULL DEFAULT '0',
    `instance_url` varchar(255) NOT NULL DEFAULT '',
    `date_creation` timestamp NULL DEFAULT NULL,
    `comment` text DEFAULT NULL,
    `is_active` tinyint NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `glpi_plugin_restapiconnector_credentials`;

CREATE TABLE `glpi_plugin_restapiconnector_credentials` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `entities_id` int unsigned NOT NULL DEFAULT '0',
    `name` varchar(255) NOT NULL DEFAULT '',
    `username` varchar(255) NOT NULL DEFAULT '',
    `password` varchar(255) NOT NULL DEFAULT '',
    `comment` text DEFAULT NULL,
    `date_mod` timestamp NULL DEFAULT NULL,
    `itemtype` varchar(255) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `glpi_plugin_restapiconnector_rules`;

CREATE TABLE `glpi_plugin_restapiconnector_rules` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `entities_id` int unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `comment` text DEFAULT NULL,
    `date_mod` timestamp NULL DEFAULT NULL,
    `plugin_restapiconnector_endpoints` int unsigned NOT NULL DEFAULT '0',
    `plugin_restapiconnector_credentials` int unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `entities_id` (`entities_id`),
    KEY `date_mod` (`date_mod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `glpi_plugin_restapiconnector_rules_endpoints`;

CREATE TABLE `glpi_plugin_restapiconnector_rules_endpoints` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `entities_id` int unsigned NOT NULL DEFAULT '0',
    `glpi_plugin_restapiconnector_rules` int unsigned NOT NULL DEFAULT '0',
    `is_recursive` tinyint NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `entities_id` (`entities_id`),
    KEY `glpi_plugin_restapiconnector_rules` (`glpi_plugin_restapiconnector_rules`),
    KEY `is_recursive` (`is_recursive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `glpi_plugin_restapiconnector_rules_credentials`;

CREATE TABLE `glpi_plugin_restapiconnector_rules_credentials` (
    `id` int unsigned NOT NULL AUTO_INCREMENT,
    `entities_id` int unsigned NOT NULL DEFAULT '0',
    `glpi_plugin_restapiconnector_rules` int unsigned NOT NULL DEFAULT '0',
    `is_recursive` tinyint NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `entities_id` (`entities_id`),
    KEY `glpi_plugin_restapiconnector_rules` (`glpi_plugin_restapiconnector_rules`),
    KEY `is_recursive` (`is_recursive`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;