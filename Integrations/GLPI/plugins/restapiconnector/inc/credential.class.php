<?php

class PluginRestapiconnectorCredential extends CommonDropdown {

   public $first_level_menu  = 'admin';

   public $second_level_menu = 'pluginrestapiconnectormenu';

   public $third_level_menu  = 'credential';

   public static $rightname  = 'plugin_restapiconnector_credential';

   public static function getTypeName($nb = 0) {
      return __('Authentication for instances', 'restapiconnector');
   }

   public function getAdditionalFields() {
      return [
         ['name'  => 'itemtype',
          'label' => __('Type'),
          'type'  => 'credential_itemtype'
         ],
         ['name'  => 'username',
          'lable' => __('Login'),
          'type'  => 'text',
         ],
         ['name'  => 'password',
          'label' => __('Password'),
          'type'  => 'password'
         ]
      ];
   }

   public function displaySpecificTypeField($id, $field = [], array $options = []) {
      switch ($field['type']) {
         case 'credential_itemtype':
            $this->showItemtype($id);
            break;
      }
   }

   public function showItemtype($id) {
      if ($id > 0) {
         $label = self::getLabelByItemtype($this->fields['itemtype']);
         if ($label) {
            echo $label;
            echo "<input type='hidden' name='itemtype' value='" . $this->fields['itemtype'] . "'>";
         }
      } else {
         $options = self::getCredentialItemTypes();
         $options[''] = Dropdown::EMPTY_VALUE;
         asort($options);
         Dropdown::showFromArray('itemtype', $options);
      }
   }

   public function defineMoreTabs($options = []) {
      return [];
   }

   public function displayMoreTabs($tab) {}

   public function rawSearchOptions() {

      $tab = [];

      $tab[] = [
         'id'   => 'common',
         'name' => __('Authentication for instances', 'restapiconnector'),
      ];

      $tab[] = [
         'id'       => '1',
         'table'    => $this->getTable(),
         'field'    => 'name',
         'name'     => __('Name'),
         'datatype' => 'itemlink',
      ];

      $tab[] = [
         'id'       => '2',
         'table'    => 'glpi_entities',
         'field'    => 'completename',
         'name'     => Entity::getTypeName(1),
         'datatype' => 'dropdown',
      ];

      $tab[] = [
         'id'            => '3',
         'table'         => $this->getTable(),
         'field'         => 'itemtype',
         'name'          => __('Type'),
         'massiveaction' => false,
      ];

      $tab[] = [
         'id'    => '4',
         'table' => $this->getTable(),
         'field' => 'username',
         'name'  => __('Login'),
      ];

      return $tab;
   }

   public static function checkBeforeInsert($input) {

      if ($input['password'] == '') {
         unset($input['password']);
      }

      if (!$input['itemtype']) {
         Session::addMessageAfterRedirect(
            __('It\'s mandatory to select a type and at least one field'),
            true,
            ERROR
         );
         $input = [];
      }
      return $input;
   }

   public function prepareInputForAdd($input) {
      return self::checkBeforeInsert($input);
   }

   public function prepareInputForUpdate($input) {
      return $input;
   }

   public static function getLabelByItemtype($credential_itemtype) {
       $credentialtypes = self::findItemtypeType($credential_itemtype);
       if (!empty($credentialtypes)) {
          return $credentialtypes['name'];
       }
       return false;
   }

   public static function getCredentialItemTypes() {
      return ['PluginGlpiinventoryInventoryComputerESX' => __('VMware host', 'glpiinventory')];
   }

   public static function getForItemtype($itemtype) {
      $itemtypes = [];
      foreach (PluginGlpiinventoryModule::getAll() as $data) {
         $class = PluginGlpiinventoryStaticmisc::getStaticMiscClass($data['directory']);
         if (is_callable([$class, 'credential_types'])) {
            foreach (call_user_func([$class, 'credential_types']) as $credential) {
               if (in_array($itemtype, $credential['targets'])) {
                  $itemtypes[$credential['itemtype']] = $credential['name'];
               }
            }
         }
      }
      return $itemtypes;
   }

   public static function dropdownCredentials($params = []) {

      global $CFG_GLPI;
      $p = [
         'value'    => '',
         'itemtype' => '',
         'id'       => 0
      ];

      $credential = new PluginRestapiconnectorCredential();
      if ($params['id'] > 0 && $credential->getFromDB($params['id'])) {
         $p = $credential->fields;
      }

      $types     = self::getCredentialsItemTypes();
      $types[''] = Dropdown::EMPTY_VALUE;
      $rand      = Dropdown::showFromArray(
         'plugin_glpiinventory_credentials_id',
         $types,
         ['value' => $p['itemtype']]
      );

      $ajparams = ['itemtype' => '__VALUE__',
                   'id'       => $p['id']
                  ];
      $url = Plugin::getWebDir('restapiconnector') . "/ajax/dropdownCredentials.php";
      Ajax::updateItemOnSelectEvent(
         "dropdown_plugin_glpiinventory_credentials_id$rand",
         "span_credentials",
         $url,
         $ajparams
      );

      echo "&nbsp;<span name='span_credentials' id='span_credentials'>";
      if ($p['id']) {
         self::dropdownCredentialsForItemtype($p);
      }
      echo "</span>";
   }

   public static function dropdownCredentialsForItemtype($params = []) {

      if (empty($params['itemtype'])) {
         return;
      }

      if ($params['itemtype'] == 'PluginGlpiinventoryInventoryComputerESX') {
         $params['itemtype'] = 'PluginGlpiinventoryCredential';
      }
      $value = 0;
      if (isset($params['id'])) {
         $value = $params['id'];
      }
      Dropdown::show($params['itemtype'], ['entity_sons' => true, 'value' => $value]);
   }

   public static function hasAtLeastOneType() {
      $types = self::getCredentialsItemTypes();
      return (!empty($types));
   }

   public function displayHeader() {
      parent::displayHeader();
      PluginGlpiinventoryMenu::displayMenu("mini");
   }

}