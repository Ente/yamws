# Documentation for the settings.yamws.php File
# FIXME: Update documentation
Prefix "setting_"

## Possible settings

* `tls` - Values: `1.2`, `1.3` - Regulates which TLS Version should be accepted by the server
* `ldap` (Active Directory) - Values: `1`, `0` - Specifies the login method for users (more configuration needed)
* `ldap_user` - User
* `ldap_password` - Base64 encrypted password
* `ldap_host` - Hostname or DNS of the LDAP Server
* `ldap_domain` - Domain from the LDAP Server
* `ldap_basedn` - DN settings
* `ldap_group` - Group for the LDAP users
* `mail` - Values: `1`, `0` - Tells the application to send emails or not
* `backup` - Values: `1`, `0` - Allows you to let the application create your backups
* ...
