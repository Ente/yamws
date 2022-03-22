<?php
namespace yamws{
    require_once dirname(__DIR__, 7) . "/vendor/autoload.php";
    use LdapTools\Configuration;
    use LdapTools\LdapManager;
    use LdapTools\DomainConfiguration;
    use yamws\settings;
    use yamws\yamws;
    class ldap extends auth{

        public function __construct(){
            ini_set("display_errors", 1);
            $conn = yamws::conn();

        }
        
        public function ldap_config(){
            global $config_ini;
            $settings = new settings();
            $configuration = new Configuration();
            $domain = (new DomainConfiguration($config_ini["ldap"]["ldap_domain"]))
                ->setBaseDN($config_ini["ldap"]["ldap_basedn"])
                ->setServers(["{$config_ini["ldap"]["ldap_ip"]}"])
                ->setUsername($config_ini["ldap"]["ldap_user"])
                ->setPassword(base64_decode($config_ini["ldap"]["ldap_password_base64"]));
            if($settings->get_ini_settings("ldap", "saf") != "true"){
                $altdomain = (new DomainConfiguration($config_ini["ldap"]["ldap2_domain"]))
                ->setBaseDN($config_ini["ldap"]["ldap2_basedn"])
                ->setServers([$config_ini["ldap"]["ldap2_ip"]])
                ->setUsername($config_ini["ldap"]["ldap2_user"])
                ->setPassword(base64_decode($config_ini["ldap"]["ldap2_password_base64"]))
                ->setLazyBind(true)
                ->setLdapType("AD");
            } else {
                $altdomain = (new DomainConfiguration($config_ini["ldap"]["ldap_domain"]))
                ->setBaseDN($config_ini["ldap"]["ldap_basedn"])
                ->setServers([$config_ini["ldap"]["ldap_ip"]])
                ->setUsername($config_ini["ldap"]["ldap_user"])
                ->setPassword(base64_decode($config_ini["ldap"]["ldap_password_base64"]))
                ->setLazyBind(true)
                ->setLdapType("AD");
            }
            $configuration->addDomain($domain, $altdomain);
            $configuration->setDefaultDomain($config_ini["ldap"]["ldap_domain"]);
            $ldap = new LdapManager($configuration);
            return $ldap;
        }   
    }
}



?>