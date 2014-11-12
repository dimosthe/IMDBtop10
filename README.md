IMDBtop10
=========

Displays the top ten movies on IMDB. It is based on the Yii2 framework. 

Requirements
------------
- PHP > 5.4.0
- php5-curl  
- Composer. If you do not have [Composer](http://getcomposer.org/), you can run
  the following commands on Linux and Mac OS X:
  1. `curl -s http://getcomposer.org/installer | php`
  2. `mv composer.phar /usr/local/bin/composer`

Deployment
----------
1. Clone the repository 
2. Run `composer global require "fxp/composer-asset-plugin:1.0.0-beta3"`. Installs the composer asset plugin which allows managing
   bower and npm package dependencies through Composer. You only need to run this command once for all. 
3. Run `composer install` in the root directory of the application in order to
   install dependencies. This will create the vendor directory with all
   package dependencies inlcuding the yii core source code.
