Create a Virtual Host:
----------------------
    <VirtualHost *:80>

     ServerName www.timedoctor.local
     ServerAlias admin.timedoctor.local
     ServerAlias api.timedoctor.local
     ServerAlias dashboard.timedoctor.local
     ServerAlias login.timedoctor.local
     DocumentRoot "/Users/Masud/Sites/TD/TDv3/web"

     <Directory "/Users/Masud/Sites/TD/TDv3/web">
         Options Indexes FollowSymLinks MultiViews
         AllowOverride All
         Allow from All
     </Directory>
    </VirtualHost>

Host File: /etc/hosts
---------------------
127.0.0.1   www.timedoctor.local
127.0.0.1   api.timedoctor.local
127.0.0.1   admin.timedoctor.local
127.0.0.1   dashboard.timedoctor.local
127.0.0.1   login.timedoctor.local


Install vendor:
---------------
1. Run: php composer.phar self-update
2. Run: php composer.phar update

To Create MySQL Database:
-------------------------
1. change db configuration at parameter.yml
2. Run: app/console doctrine:database:create
3. Run: app/console doctrine:schema:update --force