Rakuun
======

A browsergame written in PHP.

Getting started
---------------
Here are the necessary steps for setting up Rakuun on your machine:

1. Install a webserver with PHP and MySQL (for development, we used [XAMPP](http://www.apachefriends.org/en/xampp.html)1.7.1 with Apache 2.2.11, PHP 5.2.9, MySQL 5.1.33)
2. Get the [CORE PHP Framework](https://github.com/Sebioff/CORE) - note the requirements listed in CORE's README file!
3. Copy config/local.php.sample to config/local.php and modify it. Basically you'll just have to enter your MySQL database connection info
4. For the Apache webserver, place the following configuration in a .htaccess file in the same directory as Rakuun and CORE.
   Note: The configuration requires mod_rewrite (a2enmod rewrite)
   Note: The expiration settings for static content and compression of .js and .css files are optional. Enable it as you please.

# ==========================================================================================
# disable magic_quotes_gpc
php_value magic_quotes_gpc off

DirectoryIndex Rakuun/www/index.php index.php

# turn on the RewriteEngine
RewriteEngine On

# rules
# add www. infront of url if missing
RewriteCond %{HTTP_HOST} ^rakuun.de
RewriteRule (.*) http://www.rakuun.de/$1 [R=301,L]

# versioned static files (cache buster)
RewriteRule (.*)-cb\d+\.(.*)$ $1.$2 [L]

# if file/directory does not exist, redirect to index.php with the query string appended
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ Rakuun/www/index.php [L,QSA]

# disallow browsing of git or svn working copy administrative dirs.
RedirectMatch 404 /\\.git(/|$)
RedirectMatch 404 /\\.svn(/|$)
RedirectMatch 404 /\\migrations(/|$)
RedirectMatch 404 \.(tpl)$

# set up expiration for static content
#<FilesMatch "\.(ico|pdf|flv|jpg|jpeg|png|gif|js|css|swf)$">
#<IfModule mod_expires.c>
#ExpiresActive On
#ExpiresDefault "access plus 1 year"
#</IfModule>
#<IfModule !mod_expires.c>
#Header set Expires "Thu, 15 Apr 2015 20:00:00 GMT"
#</IfModule>
#</FilesMatch>

# gzip text content if possible
#<IfModule mod_deflate.c>
#<FilesMatch "\.(js|css)$">
#SetOutputFilter DEFLATE
#</FilesMatch>
#</IfModule>

# ==========================================================================================


5. In case that you experience any errors during execution of the initial setup,
   you should perform a HTTP GET request to /rakuun/core/reset. Otherwise some automatic
   setup scripts might cause further errors on retry as they interfere.
