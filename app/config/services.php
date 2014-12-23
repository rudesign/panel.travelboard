<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

// Common config
$di->set('config', function() use ($di){
    return include __DIR__ . '/config.php';
}, true);

// Router
$di->set('router', function () use ($di) {
    return include __DIR__ . '/router/common.php';
}, true);

// Cookie helper
$di->set('cookie',  function()
{
    return new Cookie();
});

// Session
$di->set('session', function () {
    $session = new Session(array(
        'cookie_lifetime' => 86400,
    ));
    $session->start();

    return $session;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function () use ($config) {
    return new DbAdapter(array(
        'host' => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname' => $config->database->dbname
    ));
});

// Cache
$di->set('cache', function() {
    // lifetime in secs
    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 1200
    ));
    // memcached settings
    $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
        "host" => "localhost",
        "port" => "11211"
    ));

    return $cache;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    return $view;
}, true);

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
});
