<?php

/*
 * 
 * THIS FILE WILL BE CALLED EVERYTIME A SCRIPT RUNS
 * 
 * IT IS CALLED WHEN THE APPLICATION IS READY TO START
 * 
 */


\Climate\Application::registerService("ORM",function(){

	$pdo=new \PDO("mysql:host=localhost;dbname=information_schema","root", "root");
    return new \Face\DiORM($pdo);

});


/*
 
TIPS : Prepare your services like e.g 
 
\Climate\Application::registerService("ODM", function(){
    $conf=new \Doctrine\ODM\MongoDB\Configuration();

    $conf->setDefaultDB('DBName');

    $conf->setProxyDir("data/cache");
    $conf->setProxyNamespace('Proxies');

    $conf->setHydratorDir('data/cache');
    $conf->setHydratorNamespace('Hydrators');

    $annotationDriver = $conf->newDefaultAnnotationDriver(array('application/App/Document'));
    $conf->setMetadataDriverImpl($annotationDriver);
    AnnotationDriver::registerAnnotationClasses();

    $dm = DocumentManager::create(new Connection(), $conf);

    return $dm;
});

 
 */