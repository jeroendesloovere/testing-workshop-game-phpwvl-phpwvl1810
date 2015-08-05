README
======

This directory should be used to place project specfic documentation including
but not limited to project notes, generated API/phpdoc documentation, or
manual files generated or hand written.  Ideally, this directory would remain
in your development environment only and should not be deployed with your
application to it's final production location.


Setting Up Your VHOST
=====================

The following is a sample VHOST you might want to consider for your project.

<VirtualHost *:80>
   DocumentRoot "/Users/dragonbe/workspace/theialive/public"
   ServerName theialive.local
   ServerAlias www.theialive.local

   # This should be omitted in the production environment
   SetEnv APPLICATION_ENV development

   <Directory "/Users/dragonbe/workspace/theialive/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>

   LogLevel info
   ErrorLog "/var/log/apache2/theialive-error_log"
   CustomLog "/var/log/apache2/theialive-access_log" common

</VirtualHost>
