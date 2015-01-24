face-embryo
===========

Embryo is a generation tool for [face ORM](https://github.com/laemons/face).

Embryo is under **Alpha**. It is working, but some behaviours may change, some can be removed and some can will be implemented.
If you detect any bug feel free to report them on the issue tracker.

Purpose of face Embryo
----------------------

One of the most annoying step during the development of an ORM based application is to build the models.

The goal of embryo is to speed up this step by generating the models for you. It only requires a well designed
mysql schema (foreign keys, primary keys..).


Install
-------

You can download embryo at http://laemons.github.io/face-embryo/build/embryo-0.1.2.phar.

```shell
    $ wget http://laemons.github.io/face-embryo/build/embryo-0.1.2.phar
```

Then it is recommended to make it executable on the system :

```shell
    $ sudo mv embryo-0.1.2.phar /usr/local/bin/embryo
    $ sudo chmod a+x /usr/local/bin/embryo
```

It's always good to update it in case there is a new version of it :

```shell
    $ embryo update
```


Usage
-----

Once it's installed you can generate models for your application.

There a few requirement :

* ``cd`` at the root of your application
* having a reachable mysql database
* the tables of the mysql database must use innodb and must have primary keys and foreign keys configured (it's how embryo can detect the relationships between tables)

If everything is ok, just run
```shell
    embryo models -h localhost -u username -p password -d database generate -o ./models
```

 * -h is the hostname where the db lives
 * -u is the username used to login into the db
 * -p is the password used to login into the db
 * -d is the database name to use
 * -o is the directoy where we want to output the php class models
 

Roadmap
-------

* Make the generation configurable from a config file
* Give more controle on the generated files (classname, namespace, default methods...) to allow re-generation of models without erasing current files
