<?php

/**
 * Services are globally registered in this file
 */
use Phalcon\Mvc\Router\Annotations as Router;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Assets\Manager as AssetsManager;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Model\Manager as ModelsManager;
use Phalcon\Mvc\Model\MetaData\Memory as MetaDataAdapter;

use Biko\Mapper\AnnotationsInitializer;
use Biko\Mapper\AnnotationsMetaDataInitializer;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/biko/');
    return $url;
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
};

/**
 * Setting up the view component
 */
$di['view'] = function(){

    $view = new View();

    $view->registerEngines(array(
        ".volt" => function($view, $di) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                "compiledPath"      => __DIR__ . '/../cache/volt/',
                "compiledSeparator" => "-"
            ));

            return $volt;
        }
    ));

    return $view;
};

$di['assets'] = function() {

    $assets = new AssetsManager();

    $assets
        ->addJs('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false);

    $assets
        ->addCss('css/bootstrap.min.css')
        ->addCss('css/style.css');

    return $assets;
};

$di['router'] = function() {

    //Use the annotations router
    $router = new Router(false);

    //Read the resources from file
    require __DIR__ . '/routes.php';

    return $router;
};

$di['modelsManager'] = function() {

    $eventsManager = new EventsManager();

    $modelsManager = new ModelsManager();

    $modelsManager->setEventsManager($eventsManager);

    //Attach a listener to models-manager
    $eventsManager->attach('modelsManager', new AnnotationsInitializer());

    return $modelsManager;
};

$di['modelsMetadata'] = function() {

    $metaData = new MetaDataAdapter(array(
        'metaDataDir' => __DIR__ . '/../cache/metaData/'
    ));

    $metaData->setStrategy(new AnnotationsMetaDataInitializer());

    return $metaData;
};

$di['flash'] = function() {
    return new Phalcon\Flash\Direct(array(
        'error'   => 'alert alert-danger',
        'success' => 'alert alert-success',
        'notice'  => 'alert alert-info',
        'warning' => 'alert alert-warning',
    ));
};