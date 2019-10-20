# poker_hands

requirements: 
PHP 7.1 and above
npm 6.4.1 and above

installation:

clone the repository and run the following command in the root directory 

npm install  -- to download the node modules
npm run dev -- to run webpack bundler
php composer.phar install -- to download composer modules
php bin/console doctrine:fixtures:load --- to load the seed data into the DB
php -S 127.0.0.1:8000 -t public --- to start the server

login credentials : 
username : admin1
password: test

*Note
Please note that i used a free online database service which seems to be quite slow, therfore uploading the hands.txt could be slow
https://remotemysql.com/
