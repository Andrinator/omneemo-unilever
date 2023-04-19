<?php

use Glpi\Application\View\TemplateRenderer;

class PluginRestapiconnectorMenu extends CommonGLPI {

   public static function getTypeName($nb = 0) {
      return __('REST API Connector', 'restapiconnector');
   }

   public static function getMenuName() {
      return self::getTypeName();
   }

   public static function getAdditionalMenuOptions() {
      $fi_full_path = Plugin::getWebDir('restapiconnector');
      $fi_rel_path  = Plugin::getWebDir('restapiconnector', false);

      $elements = [
         'endpoint'   => 'PluginRestapiconnectorEndpoint',
         'credential' => 'PluginRestapiconnectorCredential',
         'rule'       => 'PluginRestapiconnectorRule',
         'config'     => 'PluginRestapiconnectorConfig'
      ];

      $options = [];

      $options['menu']['title']           = self::getTypeName();
      $options['menu']['page']            = self::getSearchURL(false);
      $options['menu']['links']['config'] = PluginRestapiconnectorConfig::getFormURL(false);
      foreach ($elements as $type => $itemtype) {
         $options[$type] = [
            'title' => $itemtype::getTypeName(),
            'page'  => $itemtype::getSearchURL(false)
         ];
         $options[$type]['links'['search'] = $itemtype::getSearchURL(false);
         if ($itemtype::canCreate()) {
            $options[$type]['links']['add'] = $itemtype::getFormURL(false);
         }
         $options[$type]['links']['config'] = PluginRestapiconnectorConfig::getFormURL(false);
      }

      $options['config']['page'] = PluginRestapiconnectorConfig::getFormURL(false);

      return $options;

   }

   public static function displayMenu($type = 'big') {
      global $CFG_GLPI;
      $fi_path = Plugin::getWebDir('restapiconnector');
      $menu = [];

      $dashboard_menu = [];
      $dashboard_menu[0]['name'] = __('Executed rules analytics');
      $dashboard_menu[0]['link'] = $fi_path . "/front/menu.php";

      $menu['dashboard'] = [
         'name'     => __('Dashboard');
         'children' => $dashboard_menu;
      ];

      $general_menu = [];
      $general_menu[0]['name'] = __('Instances endpoints', 'restapiconnector');
      $general_menu[0]['link'] = $fi_path . "/front/endpoint.php";

      $general_menu[1]['name'] = __('General configuration', 'restapiconnector');
      $general_menu[1]['link'] = $fi_path . "/front/config.form.php";

      if (!empty($general_menu)) {
         $menu['general'] = [
            'name'     => __('General', 'restapiconnector');
            'children' => $general_menu;
         ];
      }

      $rules_menu = [];
      $rules_menu[0]['name'] = __('Rules management', 'restapiconnector');
      $rules_menu[0]['link'] = $fi_path . "/front/rule.php";

      if (!empty($rules_menu)) {
         $menu['rules'] = [
            'name'     => __('Rules', 'restapiconnector');
            'children' => $rules_menu;
         ];
      }

      $security_menu = [];
      $security_menu[0]['name'] = __('Authentication for instances', 'restapiconnector');
      $security_menu[0]['link'] = $fi_path . "/front/credential.php";

      if (!empty($security_menu)) {
         $menu['security'] = [
            'name'     => __('Security', 'restapiconnector');
            'children' => $security_menu;
         ];
      }

      TemplateRenderer::getInstance()->display('@restapiconnector/submenu.html.twig', [
         'menu' => $menu;
      ]);

   }


}