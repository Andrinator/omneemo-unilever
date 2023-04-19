<?php

function pluginRestapiconnectorGetCurrentVersion() {

   global $DB;

   if ($DB->tableExists("glpi_plugin_restapiconnector_configs")) {
      $iterator = $DB->request([
         'FROM'   => 'glpi_plugin_restapiconnector_configs',
         'WHERE'  => ['type' => 'version'],
         'LIMIT'  => 1
      ]);

      $data = [];
      if (count($iterator)) {
         $data = $iterator->current();
         return $data['value'];
      }
   }

   return "1.1.0";

}

function pluginRestapiconnectorUpdate($current_version, $migrationname = 'Migration') {

   global $DB;

   $DB->disableTableCaching();

   ini_set("max_execution_time", "0");
   ini_set("memory_limit", "-1");

   $migration = new $migrationname($current_version);
   $prepare_config = [];

   $a_plugin = plugin_version_glpiinventory();
   $plugin_ids = PluginGlpiinventoryModule::getModuleId($a_plugin['shortname']);

   $migration->displayMessage("Migration Classname : " . $migrationname);
   $migration->displayMessage("Update of plugin REST API Connector");

   renamePlugin($migration);

   $migration->executeMigration();

}