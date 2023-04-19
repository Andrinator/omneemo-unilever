<?php

class PluginAssetAssistantProfile extends Profile {

   public static $rightname = 'config';

   public function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {
      return self::createTabEntry('Asset Assistant');
   }

   public static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {
      $pfProfile = new self();
      if ($item->fields['interface'] == 'central') {
         $pfProfile->showForm($item->fields['id']);
      } else {
         $pfProfile->showFormSelf($item->fields['id']);
      }
      return true;
   }

   public function showForm($profile_ids, $options = []) {

      $openform = true;
      $closeform = true;
      $profile = new Profile();

      echo "<div class='firstbloc'>";
      if (($canedit = Session::haveRigthsOr(self::rightname, [CREATE, UPDATE, PURGE])) && $openform) {
         echo "<form method='post' action='" . $profile->getFormURL() . "'>";
      }

      $profile->getFromDB($profile_ids);

      $rights = $this->getRightsGeneral();
      $profile->displayRightsChoiceMatrix($rights, ['canedit'       => $canedit,
                                                    'default_class' => 'tab_bg_2',
                                                    'title'         => __('General', 'assetassistant')
                                                   ]);

      if ($canedit && $closeform) {
         echo "<div class='center'>";
         echo Html::hidden('id', ['value' => $profile_ids]);
         echo Html::submit(_sx('button', 'Save'), ['name' => 'update']);
         echo "</div>\n";
         Html::closeForm();
      }
      echo "</div>";

      $this->showLegend();
      return true;

   }

   public function showFormSelf($profile_ids = 0, $openform = true, $closeform = true) {
      echo "<div class='firstbloc'>";
      $profile = new Profile();

      if (($canedit = Session::haveRightsOr(self::$rightname, [CREATE, UPDATE, PURGE])) && $openform) {
         echo "<form method='post' action='" . $profile->getFormURL() . "'>";
      }

      $profile->getFromDB($profile_ids);

      if ($canedit && $closeform) {
         echo "<div class='center'>";
         echo Html::hidden('id', ['value' => $profile_ids]);
         echo Html::submit(_sx('button', 'Save'), ['name' => 'update']);
         echo "</div>\n";
         Html::closeForm();
      }
      echo "</div>";

      $this->showLegend();
   }

   public static function uninstallProfile() {
      $pfProfile = new self();
      $a_rights = $pfProfile->getAllRights();
      foreach ($a_rights as $data) {
         ProfileRight::deleteProfileRights([$data['field']]);
      }
   }

   public function getAllRights() {
      $a_rights = [];
      $a_rights = array_merge($a_rights, $this->getRightsGeneral());
      return $a_rights;
   }

   public function getRightsGeneral() {
      $rights = [
         ['rights'    => [READ => __('Read')],
          'label'     => __('Menu', 'assetassistant'),
          'field'     => 'plugin_assetassistant_menu'
         ],
         ['rights'    => [READ => __('Read'), UPDATE => __('Update')],
          'itemtype'  => 'PluginAssetAssistantConfig',
          'label'     => __('Configuration', 'assetassistant'),
          'field'     => 'plugin_assetassistant_configuration'
         ]
      ];

      return $rights;
   }

   public static function addDefaultProfileInfos($profile_ids, $rights) {
      $profileRight = new ProfileRight();
      foreach ($rights as $right => $value) {
         if (!countElementsInTable('glpi_profilerights', ['profile_ids' => $profile_ids, 'name' => $right])) {
            $myright['profile_ids'] = $profile_ids;
            $myright['name']        = $right;
            $myright['rights']      = $value;
            $profileRight->add($myright);
            $_SESSION['glpiactiveprofile'][$right] = $value;
         }
      }
   }

}