<?php
function plugin_restapiconnector_install() {

   ini_set("max_execution_time", "0");

   $migrationname = 'Migration';

   require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/install/update.php");
   $version_detected = pluginRestapiconnectorGetCurrentVersion();

   require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/install/install.php");
   pluginRestapiconnectorInstall(PLUGIN_RESTAPICONNECTOR_VERSION, $migrationname);

   return true;

}

function plugin_restapiconnector_uninstall() {
   require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/inc/setup.class.php");
   require_once(PLUGIN_RESTAPICONNECTOR_DIR . "/inc/profile.class.php");
   return PluginRestapiconnectorSetup::uninstall();
}