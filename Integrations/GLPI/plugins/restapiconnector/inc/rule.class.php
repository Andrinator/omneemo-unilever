<?php

class PluginRestapiconnectorRule extends CommonDBTM {
   public $dohistory = true;
   public static $rightname = 'plugin_restapiconnector_rule';

   public static function canCreate() {
      return true;
   }

   public static function getTypeName($nb = 0) {
      return __('Rules', 'restapiconnector');
   }

   public function rawSearchOptions() {
      $tab = [];

      $tab[] = [
         'id'   => 'common',
         'name' => __('Notification rules', 'restapiconnector');
      ];

      $tab[] = [
         'id'       => '1',
         'table'    => $this->getTable(),
         'field'    => 'name',
         'name'     => __('Name'),
         'datatype' => 'itemlink'
      ];

      return $tab;
   }

   public function defineTabs($options = []) {
      $onglets = [];
      $this->addDefaultFormTab($onglets);
      $this->addStandardTab('Log', $onglets, $options);
      return $onglets;
   }

   public function showForm($id, array $options = []) {
      $this->initForm($id, $options);
      TemplateRenderer::getInstance()->display('');
   }

}