WebOsProject
============

WebOsProject

* http://wos.mustis.org/
* http://github.com/mustis/WebOsProject
* Quakenet #mustis.dev

Installing
----------
1. Download, unpack, bla.
1. Import dump.sql into a MySQL db.
1. Rename config.php.sample -> config.php and edit.
1. Insert initial users into the DB.
   Prepend the PW_SALT (from config.php) to the password, then SHA1.
1. Set up a webserver for the frontend/ dir
