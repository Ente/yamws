<?php

namespace yamws{
    class yamws{
        public function __construct(){
            date_default_timezone_set("Europe/Berlin");

            $config_ini = parse_ini_file(dirname(__DIR__, 2) ."/conf.ini", true);

            #define("VERSION", "2.4");
            #define("ST_YEAR", "2022");
            #define("ERROR_FILE", $_SERVER["DOCUMENT_ROOT"] . "/errors.log");

            $glob_conf = [
                "version" => "2.4",
                "st_year", "2022",
                "error_file" => $_SERVER["DOCUMENT_ROOT"] . "/errors.log"
            ];
            return $glob_conf;
        }

        public function conn(){
            global $config_ini;
            $db_conf["db"] = $config_ini["database"]["mysql_database"];
            $db_conf["user"] = $config_ini["database"]["mysql_user"];
            $db_conf["password"] = /*base64_decode(*/$config_ini["database"]["mysql_password_base64"]/*)*/;
            $db_conf["host"] = $config_ini["database"]["mysql_host"];
            $db_conf["port"] = $config_ini["database"]["mysql_port"];
            $conne = mysqli_connect($db_conf["host"], $db_conf["user"], $db_conf["password"], $db_conf["db"], $db_conf["port"]);
            if(mysqli_connect_error()){
                die(mysqli_connect_error());
            }

            return $conne;
        }
    }
}


?>