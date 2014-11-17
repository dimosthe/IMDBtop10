IMDBtop10
=========

Displays the top ten movies on IMDB. The application progressively builds an arhive with the top ten movies for a particular date.  
It is based on the Yii2 framework. 

Requirements
------------
- PHP > 5.4.0
- php5-curl  
- Composer. If you do not have [Composer](http://getcomposer.org/), you can run
  the following commands on Linux and Mac OS X:
  1. `curl -s http://getcomposer.org/installer | php`
  2. `mv composer.phar /usr/local/bin/composer`
- cron

Deployment
----------
1. Clone the repository 
2. Run `composer global require "fxp/composer-asset-plugin:1.0.0-beta3"`. Installs the composer asset plugin which allows managing
   bower and npm package dependencies through Composer. You only need to run this command once for all. 
3. Run `composer install` in the root directory of the application in order to
   install dependencies. This will create the vendor directory with all
   package dependencies inlcuding the yii core source code.
4. Create a new database with the name `imdbdb` and a new user `imdbuser` with password `password1!` (or edit the file `config/db.php` and give your own database name, user and password). 
5. Run `./yii migrate` in the root directory to create the database tables.
6. Run `./yii imdbscraper/storerecords` in the root directory to make an initial call to imdb and store the top ten movies for the current date.
7. Create a cron job to execute the above script every day or week. 

How to test
-----------
1. You can use php build-in web server. Run `php -S localhost:8000` from the root directory.
2. Point your browser to `http://localhost:8000/frontend/web`.

How it works
------------
- It uses a scraper script (`commands/ImdbscraperController.php`) to fetch the IMDB charts page in order to get the top movies .
- The top 10 movies are stored in the database.
- The scraper script runs every day or week (it depends on the cron job setup) to get the top movies for the current date.
- A user selects an available date from the dropdown menu to get the top ten movies for that date.
- A caching system prevents the database from being queried each time the data needs to be displayed. 
