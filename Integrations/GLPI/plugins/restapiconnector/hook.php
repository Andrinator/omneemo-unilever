<?php
function plugin_restapiconnector_install() {

   ini_set("max_execution_time", "0");

   if (basename(filter_input(INPUT_SERVER, "SCRIPT_NAME")) != "cli_install.php") {
      if (!isCommandLine()) {
         Html::header(__('Setup', 'restapiconnector'), filter_input(INPUT_SERVER, "PHP_SELF"), "config", "plugins");
      }
      $migrationname = 'Migration';
   } else {
      $migrationname = 'CliMigration';
   }

   require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/install/update.php");
   $version_detected = pluginRestapiconnectorGetCurrentVersion();

   if (!defined('FORCE_INSTALL') && isset($version_detected) && (defined('FORCE_UPGRADE') || ($version_detected != '0'))) {
      pluginRestapiconnectorUpdate($version_detected, $migrationname);
      require_once PLUGIN_RESTAPICONNECTOR_DIR . '/install/update.native.php';
      $version_detected = pluginRestapiconnectorGetCurrentVersion();
      pluginRestapiconnectorUpdateNative($version_detected, $migrationname);
   } else {
      require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/install/install.php");
      pluginRestapiconnectorInstall(PLUGIN_RESTAPICONNECTOR_VERSION, $migrationname);
   }
   return true;

}

function plugin_restapiconnector_uninstall() {
   require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/inc/setup.class.php");
   require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/inc/profile.class.php");
   return PluginRestapiconnectorSetup::uninstall();
}