CLIMATE
==========
FRAMEWORK FOR PHP CLI APPLICATIONS

----------


Climate intends to make easyest as possible the creation of CLI application using php.


Here is a quick guide for creating your new app.

Please feel free to communicate about issues or suggestions. It is everytime appreciated !

-----------------

QUICK START
======

Requirement
-----

Climate needs **php5.4** to be installed.

Knowledges of **php5.3 OOP**

Knowledges of **YAML**

Install Climate
-----

First of all grab the [latest stable release][1]   and unarchive it anywhere you want. 



Now use composer to load dependencies.

At the root the downloaded dir : 

``` 
php -r "eval('?>'.file_get_contents('https://getcomposer.org/installer'));" 

php composer.phar install
```

If you never used Composer look at [Composer website][2] for furthers informations


Config Climate
-----------------

Go to the  ``` application ``` folder and open ``` climate.config.yml ``` 


Edit  ``` applicationName ``` and ``` applicationVersion: ``` with your application informations.


Edit  ``` accessLog ``` and ``` errorLog ``` with the paths where you want to put the logs.

DONT FORGET TO CREATE THE DIRECTORY THAT YOU SPECIFIED IN LOG CONFIGS. 
e.g If you leave the defaults values create the log dir at the root of the climate dir (not in the application dir).


You can set up email alerts and modify the used routes file (see below).

The option ``` debugRoutes ``` will allow to run the application without launching scripts in order to test safely your routes (see below)


Now come back to the root of the application and run ``` php climate.php ``` to test if your settings are ok. If so, you will have a default Climat message showing the applications works.
If it doesn't work, then look at the error (if an error is shown) else look in the log file. Most of time the application may not work because log dir is not created in the good place. If error persists feel free to open an issue.


Now you have a default working application. CONGRATS !



Now let's see how to configure you routes. That's to say the params and options that you can give when running the application.


Config Routes
-----------------

Defaultly the routes are defined in application/routes.yml

A correct route file will have the following form :

```yaml
---

default:
  controller: Climate
  action: climate
  man: Climate Application Manual Page
  
  children:

    word:
      controller: Climate
      action: word
      man: Write a word
      
      options:
        n:
          type: int
          default: 1
          man: number of time the word has to be written
          
        w:
          type: string
          default: climate
          man: the word to write
          

```

The ```default``` key **MUST** be the root of the file and will be present only once. 
Actually it defines the default route when you just type.  

You can see the ``` controller ``` key. Controller defines which controller to call when the route will match.
Controller are in ``` application/Controller ```. They must have the ``` Controller ``` namespace and must extend  ``` \Climate\Controller ```.


The key ``` action ``` is the method of the controller to call.

E.g when you type ``` php climate.php ``` you will enter the 'default' key which routes you to the class ```\Controller\Climate``` in the method ```climate```.



Now let's see the key ``` children ```. As it suggests it allows to defines children routes. 

Here is a child route named "word". You can reach it by typing ``` php climate.php word ``` which will method ``` word ``` of object ``` \Controller\Climate ```

There is now a key ``` option ```. Here you can see options ```n``` and ```w```. Try to type ``` php climate.php word -w awesome -n 2 ```. This willl write "awesome" twice
Each option has a type ``` int - string - one|word|amougn|list - activated ``` (note that list of string is still not activated)

Default route can have more than one child and each child can have zero, one or more children. [TODO : Example]

``` man ``` keyword will allow to define information for auto generated manual page

First Controller
-------------  

TODO

  

Tools  
-------------

TODO



Roadmap
-------------

Short roadmap of climate development :

 - [ ] Improve Router Config and Script
 - [ ] 'List of string' option type
 - [ ] Man generator
 - [ ] Ouputer Object for controller return





[1]: https://github.com/SneakyBobito/climate/archive/v0.1.0-alpha.zip
[2]: http://getcomposer.org/download/
