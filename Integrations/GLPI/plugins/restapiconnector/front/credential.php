<?php

include("../../../inc/includes.php");

Html::header(
   __('REST API Connector', 'restapiconnector'),
   $_SERVER['PHP_SELF'],
   'admin',
   'pluginrestapiconnectormenu',
   'credential'
);

PluginRestapiconnectorMenu::displayMenu('mini');

Search::show('PluginRestapiconnectorCredential');

Html::footer();