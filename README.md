# WEB APPLICAITION TEMPLATE

This Repository is a Template for Web Applications. 
CSS and Styling with [Twitter Bootstrap](http://getbootstrap.com/ "Bootstrap Home").

## Installation

You just have to download this Project and put it into your htdocs folder. 
Afterwards you need to type
```
$ composer install
```
Afterwards you need to rename /config/env.example.php to /config/env.php. In the env.php file is the configuration for the database.
If you want to use the tests or other nice features, you need to install [Apache Ant](https://lernjournal.d4rkmindz.ch/doku.php/installationen:ant "Documented Ant installation")

Tests (requires database configuration in /config/env.php)
````
$ ant phpunit
````
Coverage
````
$ ant phpunit-coverage
````