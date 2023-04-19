<?php

include("../../../inc/includes.php");

Html::header(
   __('REST API Connector', 'restapiconnector'),
   $_SERVER['PHP_SELF'],
   'admin',
   'pluginrestapiconnectormenu',
   'endpoint'
);

PluginRestapiconnectorMenu::displayMenu('mini');

Search::show('PluginRestapiconnectorEndpoint');

Html::footer();