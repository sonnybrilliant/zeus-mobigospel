#!/bin/bash
echo "Starting with reset"
echo "==========================================="


DIR=`php -r "echo dirname(dirname(realpath('$0')));"`
cd "$DIR"
echo "Clearing cache on app/cache app/logs app/spool"
echo "==========================================="
rm -Rf app/cache/* app/logs/* app/spool/* 

php app/console doctrine:database:drop --force
#php app/console doctrine:database:drop --force --connection=test
php app/console doctrine:database:create
#php app/console doctrine:database:create --connection=test
php app/console doctrine:schema:update --force
#php app/console doctrine:schema:update --force --em=test
php app/console doctrine:fixtures:load
#php app/console doctrine:fixtures:load --em=test


echo "Perfoming Cache warmup"
echo "==========================================="
php app/console cache:warmup

echo "==========================================="
sudo rm src/Vanessa/CoreBundle/Entity/*.php~
echo "Empty songs and images"
sudo rm web/uploads/artists/*
sudo rm web/uploads/songs/tmp/*
sudo rm web/uploads/songs/full/*
sudo rm web/uploads/songs/preview/*
sudo rm web/downloads/*

sudo chmod 0777 -R app/cache/ app/logs/ app/spool/
sudo chmod 0777 -R app/cache/  

sudo chmod 0777 -R web/uploads/artists/ web/uploads/songs/tmp/ web/uploads/songs/full/
sudo chmod 0777 -R web/uploads/songs/preview/ web/downloads/ 

echo "Done, Thank you for your patiance!!!"
