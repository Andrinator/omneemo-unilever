<?php

class CliMigration extends Migration {

   public function __construct($ver) {
      $this->deb     = time();
      $this->version = $ver;
   }

   public function displayMessage($msg) {
      $msg .= " (" . Html::timestampToString(time() - $this->deb) . ")";
      echo str_pad($msg, 100) . "\n";
   }

   public function displayTitle($title) {
      echo "\n" . str_pad(" $title ", 100, '=', STR_PAD_BOTH) . "\n";
   }

   public function displayWarning($msg, $red = false) {
      if ($red) {
         $msg = "** $msg";
      }
      echo str_pad($msg, 100) . "\n";
   }

}