<?php

class PluginRestapiconnectorSendNotificationRequest extends CommonDBTM {
   public function getApiToken() {
      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://dev-unilever.simpleone.ru/v1/auth/login',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_POST => true,
         CURLOPT_POSTFIELDS => array('username' => 'a.miroshnikov','password' => 'j^7j.?Y)%\\9c(4_n'),
      ));

      $response = curl_exec($curl);
      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

      if ($httpCode === 200) {
         $authToken = json_decode($response)->{'data'}->{'auth_key'};
         return $authToken;
      }

      curl_close($curl);

   }

   public function callNotifyApiAction($token, $data = false) {
      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://dev-unilever.simpleone.ru/v1/api/c_simple/glpi/v1/glpi_notification',
         CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer ' . $token
         ),
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_POST => true,
      ));

      curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($curl, CURLOPT_USERPWD, "");

      $response = curl_exec($curl);
      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

      if ($httpCode === 200) {
         return $response;
      }

      curl_close($curl);

   }
}