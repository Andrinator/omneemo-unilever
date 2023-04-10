<?php
function plugin_notify_install() {
   global $DB;

   //instanciate migration with version
   $migration = new Migration(100);

   //Create table only if it does not exists yet!
   if (!$DB->tableExists('glpi_plugin_notify_configs')) {
      //table creation query
      $query = "CREATE TABLE glpi_plugin_notify_config (
                  id INT(11) NOT NULL AUTO_INCREMENT,
                  name VARCHAR(255) NOT NULL,
                  PRIMARY KEY(id)
               ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->queryOrDie($query, $DB->error());
   }

   if ($DB->tableExists('glpi_plugin_notify_configs')) {
      //missed value for configuration
      $migration->addField(
         'glpi_plugin_notify_configs',
         'value',
         'string'
      );

      $migration->addKey(
         'glpi_plugin_notify_configs',
         'name'
      );
   }

   //execute the whole migration
   $migration->executeMigration();

   return true;
}

function plugin_notify_uninstall() {
   global $DB;

   $tables = [
      'configs'
   ];

   foreach ($tables as $table) {
      $tablename = 'glpi_plugin_notify_' . $table;
      if ($DB->tableExists($tablename)) {
         $DB->queryOrDie(
            "DROP TABLE `$tablename`",
            $DB->error()
         );
      }
   }
   return true;
}

function plugin_item_update_notify($parm) {
   global $DB;

   $query = "INSERT INTO glpi_plugin_notify_config (name) VALUES ('Test')";
   $DB->queryOrDie($query, $DB->error());
}

function plugin_item_add_notify($parm) {
   global $DB;
   $query = "INSERT INTO glpi_plugin_notify_config (name) VALUES ('Test')";
   $DB->queryOrDie($query, $DB->error());
}

function plugin_ticket_notify($parm) {
   global $DB;

   $query = "INSERT INTO glpi_plugin_notify_config (name) VALUES ('Test')";
   $DB->queryOrDie($query, $DB->error());
}