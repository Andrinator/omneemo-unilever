<?php
class PluginRestapiconnectorCommonView extends CommonDBTM {
   const MSG_INFO = 0;
   const MSG_WARNING = 1;
   const MSG_ERROR = 2;

   public $base_urls = [];

   public function __construct() {
      global $CFG_GLPI;
       parent::__construct();

       $fi_path = Plugin::getWebDir('notify');

       $this->base_urls = [
          'fi.base'   => $fi_path,
          'fi.front'  => $fi_path . "/front",
       ];
   }

   public function getBaseUrlFor($name) {
      if (array_key_exists($name, $this->base_urls)) {
         return $this->base_urls[$name];
      }
      trigger_error(
         "The requested url type '$name' doesn't exists. " .
         "Maybe the developper have forgotten to register it in the 'base_urls' variable."
      );
      return "";
   }

   public function showList() {
      Search::show(get_class($this));
   }

   public function showTextField($title, $varname) {
      echo "<div class='mb-2 row col-12 col-sm-6'>";
      echo "<label class='form-label col-sm-4 col-form-label'>" . $title . "&nbsp;:</label>";
      echo "<div class='col-sm-6'>";
      echo Html::input($varname, ['value' => $this->fields[$varname]]);
      echo "</div>";
      echo "</div>";
   }

   public function showIntegerField($title, $varname, $options = []) {
      echo "<div class='mb-2 row col-12 col-sm-6'>";
      echo "<label class='form-label col-sm-4 col-form-label'>" . $title . "&nbsp;:</label>";
      echo "<div class='col-sm-6'>";
      Dropdown::showNumber($varname, $options);
      echo "</div>";
      echo "</div>";
   }

   public function showCheckboxField($title, $varname, $options = []) {
      echo "<div class='mb-2 row col-12 col-sm-6'>";
      echo "<label class='form-label col-sm-4 col-form-label'>" . $title . "&nbsp;:" . "</label>";
      echo "<div class='col-sm-6'>";
      $options['name'] = $varname;
      $options['checked'] = $this->fields[$varname];
      $options['zero_on_empty'] = true;

      Html::showCheckbox($options);
      echo "</div>";
      echo "</div>";
   }

   public function showDropdownForItemtype($title, $itemtype, $options = []) {
      echo "<div class='mb-2 row col-12 col-sm-6'>";
      echo "<label class='form-label col-sm-4 col-form-label'>" . $title . "&nbsp;:" . "</label>";
      echo "<div class='col-sm-6'>";
      $dropdown_options = array_merge(
         [
          'width' => '90%',
          'display' => true,
         ],
         $options
      );
      $rand = Dropdown::show($itemtype, $dropdown_options);
      echo "</div>";
      echo "</div>";
      return $rand;
   }

   public function showDropdownFromArray($title, $varname, $values = [], $options = []) {
      echo "<div class='col-lg-4'>";
      echo $title . "&nbsp;";

      if (!isset($options['width'])) {
         $options['width'] = '40%';
      }

      if (!is_null($varname)) {
         $options['value'] = $this->fields[$varname];
      }
      $rand = Dropdown::showFromArray(
         $varname,
         $values,
         $options
      );
      echo "</div>";
      return $rand;
   }

   public function showDateTimeField($title, $varname, $options = []) {
      if ($this->fields['id'] > 0) {
         $value = $this->fields[$varname];
      } else {
         if (array_key_exists('maybeempty', $options) and $options['maybeempty']) {
            $value = "";
         } else {
            $value = date("Y-m-d H:i:s");
         }
      }
      $options['value'] = $value;

      echo "<div class='mb-2 row col-12 col-sm-6'>";
      echo "<label class='form-label col-sm-4 col-form-label'>" . $title . "&nbsp;:</label>";
      echo "<div class='col-sm-6 datetime'>";
      Html::showDateTimeField(
         $varname,
         $options
      );
      echo "</div>";
      echo "</div>";
   }

   public function showTextArea($title, $varname) {
      echo "<div class='mb-2 row col-12 col-sm-6'>";
      echo "<label class='form-label col-sm-4 col-form-label'>" . $title . "&nbsp;:</label>";
      echo "<div class='col-sm-6'>";
      echo "<textarea class='autogrow form-control' name='" . $varname . "' >" . $this->fields[$varname] . "</textarea>";
      echo "</div>";
      echo "</div>";
   }

   public function getMessage($msg, $type = self::MSG_INFO) {
      switch ($type) {
         case self::MSG_WARNING:
            $msg = __('Warning:', 'notify') . " $msg";
            $class_msg = 'warning';
            break;
         case self::MSG_ERROR:
            $msg = __('Error:', 'notify') . " $msg";
            $class_msg = 'error';
            break;
         case self::MSG_INFO:
         default:
            $class_msg = '';
            break;
      }
      return "<div class='box' style='margin-bottom:20px;'>
               <div class='box-tleft'>
                <div class='box-tright'>
                 <div class='box-tcenter'></div>
                </div>
               </div>
               <div class='box-mleft'>
                <div class='box-mright'>
                 <div class='box-mcenter'>
                  <span class='b $class_msg'>$msg</span>
                 </div>
                </div>
               </div>
               <div class='box-bleft'>
                <div class='box-bright'>
                 <div class='box-bcenter'></div>
                </div>
               </div>
              </div>";
   }
}
