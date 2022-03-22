<?php
require_once "../inc/loader.php";
use yamws\yamws;
use yamws\auth;
use yamws\settings;
use yamws\ldap;

##############
$username = $_POST["username"];
$password = $_POST["password"];
##############

$actions = new auth();
$settings = new settings();
$ldap = new ldap();
$ldap_ob = $ldap->ldap_config();

if($actions->login($username, $password) == true){
    if($settings->get_ini_settings("authentication", "auth_require_ldap") == "true"){
        if($ldap_ob->authenticate($username, $password)){
            return;
        } else {
            die("Error");
        }
    }
    $user = $actions->get_data($_SESSION["user_id"], "1");
    if($user["role"] == "employee"){
        header("Location: ../../../employee/report.html");
        return;
    } elseif($user["role"] == "technician"){
        header("Location: ../../../technician/tools.html");
    } else{
        header("Location: ../../../index.html?error=no_valid_role");
    }
} else {
    die("Error: Error while logging in. You sure, that the user exists?");
}


?>