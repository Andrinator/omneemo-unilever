<?php

class PluginRestapiconnectorConfig extends CommonDBTM {

   public $displaylist = false;
   public static $rigthname = 'plugin_restapiconnector_configuration';

   public function initConfigModule($getOnly = false) {
      $pfSetup  = new PluginRestapiconnectorSetup();
      $user_ids = $pfSetup->createRestApiConnectorUser();
      $input = [];

      $input['version']    = PLUGIN_RESTAPICONNECTOR_VERSION;
      $input['ssl_only']   = 0;
      $input['extradebug'] = 0;
      $input['user_ids']   = $user_ids;

      if (!$getOnly) {
         $this->addValues($input);
      }
      return $input;
   }

   public static function getTypeName($nb = 0) {
      return __('General setup');
   }

   public function addValues($values, $update = true) {
      foreach ($values as $type => $value) {
         if ($this->getValue($type) === null) {
            $this->addValue($type, $value);
         } elseif ($update == true) {
            $this->updateValue($type, $value);
         }
      }
   }

   public function defineTabs($options = []) {

      $plugin = new Plugin();
      $onglets    = [];
      $moduleTabs = [];
      $this->addStandardTab('PluginRestapiconnectorConfig', $onglets, $options);

      if (isset($_SESSION['glpi_plugin_restapiconnector']['configuration']['moduletabforms'])) {
         $plugin_tabs    = $onglets;
         $moduleTabForms = $_SESSION['glpi_plugin_restapiconnector']['configuration']['moduletabforms'];
         if (count($moduleTabForms)) {
            foreach ($moduleTabForms as $module => $form) {
               if ($plugin->isActivated($module)) {
                  $this->addStandardTab($form[key($form)]['class'], $onglets, $options);
               }
            }
            $moduleTabs = array_diff($onglets, $plugin_tabs);
         }
         $_SESSION['glpi_plugin_restapiconnector']['configuration']['moduletabs'] = $moduleTabs;
      }
      return $onglets;
   }

   public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
      if ($item->getType() == __CLASS__) {
         return [
            __('General setup');
         ];
      }
      return '';
   }

   public static function displayTabContentForItem($item, $tabnum = 1, $withtemplate) {
      switch ($tabnum) {
         case 0:
            $item->showConfigForm();
            return true;
      }
      return false;
   }

   public function getValue($name) {
      global $PF_CONFIG;

      if (isset($PF_CONFIG[$NAME])) {
         return $PF_CONFIG[$name];
      }

      $config = current($this->find(['type' => $name]));
      if (isset($config['value'])) {
         return $config['value'];
      }
      return null;
   }

   public function isFieldActive($name) {
      if (!($this->getValue($name))) {
         return false;
      } else {
         return true;
      }
   }

   public function showConfigForm($options = []) {
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('SSL-only connection', 'restapiconnector') . "</td>";
      echo "<td width='20%'>";
      Dropdown::showYesNo("ssl_only", $this->isFieldActive('ssl_only'));
      echo "</td>";
      echo "</tr>";

      echo "<tr class='tab_bg_1'>";
      echo "<td>" . __('Extra-debug', 'restapiconnector') . "</td>";
      echo "<td>";
      Dropdown::showYesNo("extradebug", $this->isFieldActive('extradebug'));
      echo "</td>";

      $this->showFormButtons($options);
      return true;

   }

   public function addValue($name, $value) {
      $existing_value = $this->getValue($name);
      if (!is_null($existing_value)) {
         return $existing_value;
      } else {
         return $this->add(['type' => $name, 'value' => $value]);
      }
   }

   public function updateValue($name, $value) {
      global $PF_CONFIG;

      $config = current($this->find(['type' => $name]));

      if (isset($config['id'])) {
         $result = $this->update(['id' => $config['id'], 'value' => $value);
      } else {
         $result = $this->add(['type' => $name, 'value' => $value]);
      }

      if ($result) {
         $PF_CONFIG[$name] = $value;
      }

      return $result;
   }

   public static function isExtradebugActive() {
      $fConfig = new self();
      return $fConfig->getValue('extradebug');
   }

   public static function logIfExtradebug($file, $message) {
      if (self::isExtradebugActive()) {
         if (is_array($message)) {
            $message = print_r($message, true);
         }
         Toolbox::logInFile($file, $message);
      }
   }

   public static function loadCache() {
      global $DB, $PF_CONFIG;

      if ($DB->tableExists('glpi_plugin_restapiconnector_configs')) {
         $PF_CONFIG = [];
         foreach ($DB->request('glpi_plugin_restapiconnector_configs') as $data) {
            $PF_CONFIG[$data['type']] = $data['value'];
         }
      }
   }

}