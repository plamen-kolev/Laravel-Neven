#!/usr/bin/env bash
# WARNING THIS IS FOR DEVELOPMENT!!!
sudo apt-get install php5-cli sqlite php5-sqlite php5-curl mysql-server php5-mysql phpunit php5-memcached memcached
 mysql -u root -p
 create database neven;
 grant usage on neven.* to admin@localhost identified by 'admin';

php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php
php -r "if (hash('SHA384', file_get_contents('composer-setup.php')) === '41e71d86b40f28e771d4bb662b997f79625196afcca95a5abf44391188c695c6c1456e16154c75a211d238cc3bc5cb47') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
# codeception
wget http://codeception.com/codecept.phar