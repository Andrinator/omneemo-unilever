<?php

define('NOTIFY_VERSION', '1.0.0');

function plugin_init_notify() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['notify'] = true;
   $PLUGIN_HOOKS['item_add']['notify'] = [
      'Monitor' => 'plugin_item_update_notify'
   ];

   $PLUGIN_HOOKS['item_add']['notify'] = [
      'Ticket' => 'plugin_ticket_notify'
   ];

   $Plugin = new Plugin();


}

function plugin_version_notify() {
   return ['name'         => 'Notify',
           'version'      => NOTIFY_VERSION,
           'author'       => 'Andrew Miroshnikov',
           'license'      => 'GPLv3',
           'homepage'     => '',
           'requirements' => [
              'glpi' => [
                 'min' => '0.90',
                 'max' => '10.0.4',
                 'dev' => true
              ],
              'php'  => [
                 'min' => '7.0'
              ]
           ]
    ];
}

function plugin_notify_check_prerequisites() {
   return true;
}

function plugin_notify_check_config($verbose = false) {
   if (true) {
      return true;
   }

   if ($verbose) {
      echo "Installed, but not configured";
   }
   return false;
}

function plugins_notify_options() {
   return [
      Plugin::OPTION_AUTOINSTALL_DISABLED => true,
   ];
}