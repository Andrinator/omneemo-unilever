<?php

class PluginRestapiconnectorEndpoint extends CommonDBTM {

   public $dohistory = true;
   public static $rightname = 'plugin_restapiconnector_endpoint';

   public static function canCreate() {
      return true;
   }

   public static function getTypeName($nb = 0) {
//       return __('Endpoints', 'restapiconnector');
   }

   public function rawSearchOptions() {
      $tab = [];

      $tab[] = [
         'id'   => 'common',
         'name' => __('Endpoint configuration', 'restapiconnector')
      ];

      $tab[] = [
         'id'       => '1',
         'table'    => $this->getTable(),
         'field'    => 'name',
         'name'     => __('Name'),
         'datatype' => 'itemlink'
      ];

//       $tab[] = [
//          'id'        => '2',
//          'table'     => 'glpi_entities',
//          'field'     => 'completename',
//          'linkfield' => 'entities_id',
//          'name'      => Entity::getTypeName(1),
//          'datatype'  => 'dropdown',
//       ];

      $tab[] = [
         'id'    => '2',
         'table' => $this->getTable(),
         'field' => 'endpoint',
         'name'  => __('Endpoint', 'restapiconnector');
      ];

//       $tab[] = [
//          'id'            => '4',
//          'table'         => PluginRestapiconnectorCredential::getTable(),
//          'field'         => 'name',
//          'datatype'      => 'dropdown',
//          'right'         => 'all',
//          'name'          => PluginRestapiconnectorCredential::getTypeName(1),
//          'forcegroupby'  => true,
//          'massiveaction' => false,
//          'joinparams'    => [
//             'beforejoin' => [
//                'table'      => PluginRestapiconnectorEndpoint_PluginRestapiconnectorEndpoint::getTable(),
//                'joinparams' => [
//                   'jointype'   => 'child',
//                ],
//             ],
//          ],
//       ];

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