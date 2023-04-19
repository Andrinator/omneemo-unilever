<?php

use Glpi\Plugin\Hooks;

define('PLUGIN_RESTAPICONNECTOR_VERSION', '1.0.0');
define('PLUGIN_RESTAPICONNECTOR_MIN_VERSION', '10.0.2');
define('PLUGIN_RESTAPICONNECTOR_MAX_VERSION', '10.0.99');

define('PLUGIN_RESTAPICONNECTOR_DIR', __DIR__);

function plugin_glpiinventory_script_endswith($scriptname) {
   $script_name = filter_input(INPUT_SERVER, "SCRIPT_NAME");
   return substr($script_name, -strlen($scriptname)) === $scriptname;
}

function plugin_init_restapiconnector() {
   global $PLUGIN_HOOKS, $CFG_GLPI, $PF_CONFIG;

   $PLUGIN_HOOKS['csrf_compliant']['restapiconnector'] = true;

   $plugin = new Plugin();
   $debug_mode = true;

   if ($plugin->isActivated('restapiconnector')) {
      $plugin->registerClass('PluginRestapiconnectorConfig');
      $plugin->registerClass('PluginRestapiconnectorCredential');
      $plugin->registerClass('PluginRestapiconnectorEndpoint');
      $plugin->registerClass('PluginRestapiconnectorRule');

      $plugin->getFromDBbyDir('restapiconnector');

      PluginRestapiconnectorConfig::loadCache();

   }

   $PLUGIN_HOOKS['menu_toadd']['restapiconnector']['admin'] = 'PluginRestapiconnectorMenu';


}

function plugin_version_restapiconnector() {
   return ['name'         => 'REST API Connector',
           'version'      => RESTAPICONNECTOR_VERSION,
           'author'       => 'Andrew Miroshnikov',
           'license'      => 'GPLv3',
           'homepage'     => '',
           'requirements' => [
              'glpi' => [
                 'min' => PLUGIN_RESTAPICONNECTOR_MIN_VERSION,
                 'max' => PLUGIN_RESTAPICONNECTOR_MAX_VERSION,
                 'dev' => true
              ],
              'php'  => [
                 'min' => '7.0'
              ]
           ]
    ];
}

function plugin_restapiconnector_check_prerequisites() {
   return true;
}

function plugin_restapiconnector_check_config($verbose = false) {
   if (true) {
      return true;
   }

   if ($verbose) {
      echo "Installed, but not configured";
   }
   return false;
}

function plugins_restapiconnector_options() {
   return [
      Plugin::OPTION_AUTOINSTALL_DISABLED => true,
   ];
}