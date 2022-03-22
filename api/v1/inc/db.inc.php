<?php

# INIT Vars & others   #
########################
date_default_timezone_set("Europe/Berlin");

$config_ini = parse_ini_file("conf.ini", true);

#define("DB_NAME", $config_ini["database"]["mysql_database"]);
#define("DB_USER", $config_ini["database"]["mysql_user"]);
#define("DB_PASSWORD", /*base64_decode(*/$config_ini["database"]["mysql_password_base64"]/*)*/);
#define("DB_HOST", $config_ini["database"]["mysql_host"]);
#define("DB_PORT", $config_ini["database"]["mysql_port"]);

#function conn(){
#$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
#if(mysqli_connect_error()){
#    die(mysqli_connect_error());
#}else{
#    return $conn;
#}
#}
########################



?>