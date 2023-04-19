<?php

include("../../../inc/includes.php");

if (PluginNotifyMenu::canView()) {
   Html::header(
      __('REST API Connector', 'restapiconnector'),
      $_SERVER["PHP_SELF"],
      "admin",
      "pluginrestapiconnectormenu",
      "menu"
   );

   echo Html::manageRefreshPage();

   PluginRestapiconnectorMenu::displayMenu();

} else {
   Html::displayRightError();
}

Html::footer();