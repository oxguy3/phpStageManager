# phpStageManager

A web-based theatre management utility.

Requires a web server with PHP 5.x (with MySQL extension) and a MySQL server. For the time being, phpMyAdmin or a similar tool is needed if one wishes to edit the users and roles tables from a browser.

Uses [jQuery](http://jquery.com/), [jQuery UI](http://jqueryui.com/) (with Smoothness theme), [FullCalendar](http://arshaw.com/fullcalendar/), [JSColor](http://jscolor.com/), [Fatcow's 3500 Free "Farm-Fresh Web Icons"](http://www.fatcow.com/free-icons)

## Installation

phpStageManager currently lacks an automatic installation script; however, it is still possible to install without too much trouble.

1. Copy all files in the master branch to a directory on your web server.
2. Using phpMyAdmin or other means, import install.sql into a database on your MySQL server.
3. Open psm_config.php with a text editor and edit the variables according to your server configuration and preferences (you must edit the values for the site address and SQL server for phpStageManager to function)
4. Access the website in a browser via your web server. Log in with username 'admin' and the password you want the admin account to have. This will set the password.

That should be all, happy stage managing!

## Usage

Coming soon!
