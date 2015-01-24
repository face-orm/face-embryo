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

You can download embryo at http://laemons.github.io/face-embryo/build/embryo-0.1.0.phar.

```shell
    $ wget http://laemons.github.io/face-embryo/build/embryo-0.1.0.phar
```

Then it is recommended to make it executable on the system :

```shell
    $ sudo mv embryo-0.1.2.phar /usr/local/bin/embryo
    $ sudo chmod a+x /usr/local/bin/embryo
```

It's always good to update it in case this readme is not update to date :

```shell
    $ embryo update
```


Usage
-----

TODO
