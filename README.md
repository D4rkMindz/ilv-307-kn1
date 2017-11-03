# WEB APPLICAITION TEMPLATE

This project is created in educational course as exam. This application won't be developed any further.

## Installation

You just have to download this Project and put it into your htdocs folder. 
Afterwards you need to type
```
$ composer install
```
Afterwards you need to rename /config/env.example.php to /config/env.php. In the env.php file is the configuration for the database.
The next task is to configure the mailing system. For that, you need a [DEBUGMAIL Account](https://debugmail.io). You need to create a new project (within debugmail) and fill the provided data into the variables in the env.php file. The "to" value is the your email. The "from" value can be any email, but i recommend it to take yours (this email will be displayed in the email). 
It is also required to add your OPEN Weather Map API key to $env['weather']['key'];

If you want to use the tests or other nice features, you need to install [Apache Ant](https://lernjournal.d4rkmindz.ch/doku.php/installationen:ant "Documented Ant installation")

Many files (e.g. phinx.php) are not required for this project, but they are not removed because of the development "usage".

Please install all fonts in the /resources/fonts folder on your computer (Windows: Double-click and install in the top left corner).

Tests (requires database configuration in /config/env.php)
````
$ ant phpunit
````
Coverage
````
$ ant phpunit-coverage
````

## Usage

You can edit the /files/produkte.csv file to update your product data.

 * kategorie = rind|kaninchen|pflanzliches depending where to display the product
 * titel = string, freely selectable
 * beschreibung = string, freely selectable
 * preis = float, you MUST write the last 2 decimal digits (like 123.**00**)
 * bildname = place the image into the /public/images/{kategorie}/ folder and just write the image name (like kaninchen_wuerste.jpg)
 
 Please keep in mind, that you are editing a [CSV File](https://www.thoughtspot.com/blog/6-rules-creating-valid-csv-files "CSV Basics").
 
 ## Notice
 
 Sometimes (mostly on full hour) an error can occur (Notice: Undefined index: list in C:\xampp\htdocs\template\src\Service\Weather\WeatherService.php on line 37)
 If this happens, make sure you have enough API Calls left. If not, just edit the last [date].json filename and set the last number (after the _ underscore) to the actual time (hour).
 To put the application in "Prod mode" please uncomment 
 ```
//error_reporting(0);
//ini_set('display_errors', '0');
 ```
 in the /config/config.php file. Afterwards you have to delete the code that was uncommented at the beginning.
 
 ### Wetter page
 You can force reload the weatherdata by adding the "_r=1" parameter to the URL. You can also specify which record should be reloaded by adding the parameter "_t". 
 
 _t=0 => will not work
 
 _t=1 => forcereload weather
 
 _t=2 => forcereload humidity
 
 _t=3 => forcereload temperature
 
 _t=4 => forcereload wind