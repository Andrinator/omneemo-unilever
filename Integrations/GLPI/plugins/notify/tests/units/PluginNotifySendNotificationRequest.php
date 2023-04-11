<?php
class PluginNotifySendNotificationRequest {
   public function getAPIToken() {
      $curl = curl_init();

      curl_setopt_array($curl, array(
         CURLOPT_URL => 'https://dev-unilever.simpleone.ru/v1/auth/login',
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => 'POST',
         CURLOPT_POSTFIELDS => array('username' => 'a.miroshnikov','password' => 'j^7j.?Y)%\\9c(4_n'),
         CURLOPT_HTTPHEADER => array(
            'Cookie: SERVERID=srv-ngkdi10mECnZ8+wEmeqLOA|ZDV3v'
         ),
      ));

      $response = curl_exec($curl);
      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

      echo $httpCode;
      $authToken = json_decode($response)->{'data'}->{'auth_key'};

      curl_close($curl);
      return $authToken;
   }

   public function callAPI($method, $url, $data = false) {
      $curl = curl_init();

      switch ($method) {
         case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data) {
               curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
         case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
         default:
            if ($data) {
               $url = sprintf("%s?%s", $url, http_build_query($data));
            }
      }

      curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($curl, CURLOPT_USERPWD, "");
   }
}

$request = new PluginNotifySendNotificationRequest();
$response = $request->getAPIToken();
echo $response;