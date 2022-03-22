<?php

namespace yamws{

    use mysqli_result;

class settings extends yamws{
        
        /**
         * update_settings(...) - Updates a Setting to a new value
         * 
         * @param string $setting_name Name of the setting (e.g. inactive_ban_duration)
         * @param string $setting_value Value the Setting should get (e.g. 60)
         * @param array optional $parms - Optional parameters
         * 
         * @return boolean Returns true on success and false otherwise
         */


        public function __construct(){
            $yamws = new yamws();
        }

        public function update_settings($setting_name, $setting_value, $parms = NULL){
            global $conn;
            $sql = "UPDATE `settings` SET `setting_value`='{$setting_value}' WHERE `setting_name` = '{$setting_name}'";
            $res = mysqli_query($conn, $sql);
            if($res == false){
                die("Error: Error while processing query");
            }
        }

        public function set_settings($setting_name, $setting_value, $setting_default){
            global $conn;
            $sql = "INSERT INTO `settings` (`setting_name`, `setting_value`, `setting_default`) VALUES ('{$setting_name}', '{$setting_value}', '{$setting_default}'";
            $res = mysqli_query($conn, $sql);
            if($res == false){
                die("Error: Error while processing query!");
            }
        }

        /**
         * settings_default(...) - Gets the default setting
         * 
         * @param string $setting_name Name of the setting
         * @return string|int Returns the settings default value
         */
        public function settings_default($setting_name){
            global $conn;
            $sql = "SELECT `setting_default` FROM `settings` WHERE `setting_name` = '{$setting_name}';";
            $res = mysqli_query($conn, $sql);
            if($res != false){
                return mysqli_fetch_assoc($res);
            } else {
                die("Error: Error while processing query!");
            }

        }
        public function delete_settings($setting_id){

        }

        public function get_settings_id($setting_name){

        }


        public function get_ini_settings($settings_unit, $setting){
            global $config_ini;
            return $config_ini[$settings_unit][$setting];
        }
    }
}



?>