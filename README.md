ThreedotsSSOServer
==================

Single Sign On Implementation using Symfony2.4 and Doctrine ORM
 
Create a Virtual Host:
----------------------
    <VirtualHost *:80>

     ServerName www.timedoctor.local
     DocumentRoot "/Users/Masud/Sites/testengine/web"

     <Directory "/Users/Masud/Sites/testengine/web">
         Options Indexes FollowSymLinks MultiViews
         AllowOverride All
         Allow from All
     </Directory>
    </VirtualHost>

Host File: /etc/hosts
---------------------
127.0.0.1   www.testengine.locall


Install vendor:
---------------
1. Run: php composer.phar self-update
2. Run: php composer.phar update

To Create MySQL Database:
-------------------------
1. change db configuration at parameter.yml
2. Run: app/console doctrine:database:create
3. Run: app/console doctrine:schema:update --force