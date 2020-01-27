[![Latest Stable Version](https:/poser.pugx.org/JohanLe/Weather/v/stable)](https:/packagist.org/packages/anax/remserver)


[![Build Status](https:/travis-ci.org/JohanLe/WeatherModule.svg?branch=master)](https:/travis-ci.org/JohanLe/WeatherModule)

[![Build Status](https:/scrutinizer-ci.com/g/JohanLe/WeatherModule/badges/build.png?b=master)](https:/scrutinizer-ci.com/g/JohanLe/WeatherModule/build-status/master)

[![Scrutinizer Code Quality](https:/scrutinizer-ci.com/g/JohanLe/WeatherModule/badges/quality-score.png?b=master)](https:/scrutinizer-ci.com/g/JohanLe/WeatherModule/?branch=master)

[![Code Coverage](https:/scrutinizer-ci.com/g/JohanLe/WeatherModule/badges/coverage.png?b=master)](https:/scrutinizer-ci.com/g/JohanLe/WeatherModule/?branch=master)




# Weather module for Anax

A module that allows you to get a weather forecast for the next ten days and weather data from the thirty previus days. 

Enter an ip-adress, the module finds the location of the ip-adress host and gather the weather data.

Contains an api that does the same thing but return a json-string.


Install
====

###### Composer

> composer require johanle/weather

###### Git 

> git clone https:/github.com/JohanLe/weather/


If installed with Composer you can use following commands with rsync:

##### With bash:

Run:
> bash ./setup.bash

##### Manually:
Run following commands.

Config files: 
> rsync -av vendor/johanle/weather/config/router/* config/router/

Src files:
> rsync -av vendor/johanle/weather/source/Weather src/

View files:
> rsync -av vendor/johanle/weather/view/weather view/

Test files: 
> rsync -av vendor/johanle/weather/test/weather test/



