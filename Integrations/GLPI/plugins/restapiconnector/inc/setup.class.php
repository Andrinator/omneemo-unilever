<?php

class PluginRestapiconnectorSetup {

   public static function uninstall() {
      global $DB;

      return true;
   }

   public function createRestApiConnectorUser() {
      $user = new User();
      $a_users = $user->find(['name' => 'Plugin_REST_API_Connector']);
      if (count($a_users) == '0') {
         $input = [];
         $input['name'] = 'Plugin_REST_API_Connector';
         $input['password'] = mt_rand(30, 39);
         $input['firstname'] = "Plugin REST API Connector";
         return $user->add($input);
      } else {
         $user = current($a_users);
         return $user['id'];
      }
   }

}