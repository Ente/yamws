# YAMWS

"Yet another Maintenance Website" is a project, aimed to be user-friendly and helpful when you're in need of technical support.

## Requirements

This software requires:
A linux OS,
PHP 7.4 (supported, Checked: 02.02.2022),
mySQL-Database,
Apache2-Webserver

(Tested with Lubuntu)

## Installation

Please choose one of the following guides to install YAMWS on your Webserver!

### Automatic installation

To automatically install YAMWS on your server, you can easily start the `install.sh` and then you just follow the instructions on the terminal.
Your database user and the configuration will be made automatically by the software

### Manual Installation

If the automatic installation did not worked for you, follow the steps from below:

1. Import the `setup/setup.sql` into mySQL
2. Change the user credentials for the database user in the `api\v1\inc\db.inc.php` file.
3. ...

## LICENSE

see LICENSE.md