<?php

function pluginRestapiconnectorInstall($version, $migrationname = 'Migration') {
   global $CFG_GLPI, $DB;

   $migration = new $migrationname($version);

   require_once(PLUGIN_RESTAPICONNECTOR_DIR . '/inc/credential.class.php');
   require_once(PLUGIN_RESTAPICONNECTOR_DIR . '/inc/endpoint.class.php');
   require_once(PLUGIN_RESTAPICONNECTOR_DIR . '/inc/rule.class.php');
   foreach (glob(PLUGIN_RESTAPICONNECTOR_DIR . '/inc/*.php') as $file) {
      require_once($file);
   }

   $migration->displayMessage("REST API Connector plugin installation");
   $migration->displayMessage("Creation tables in database");
   $DB_file = PLUGIN_RESTAPICONNECTOR_DIR . "/install/mariadb/plugin_restapiconnector-empty.sql";
   if (!$DB->runFile($DB_file)) {
      $migration->displayMessage("Error on creation tables in database");
   }

   $migration->displayMessage("Initialize configuration");
   PluginRestapiconnectorConfig()::initConfigModule();


}