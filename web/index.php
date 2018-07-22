<?php

require_once __DIR__.'/../vendor/autoload.php';
define('PROJECT_ROOT', realpath(__DIR__ . '/../'));

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => PROJECT_ROOT.'/views',
));

$app->get('/', function() use($app) {
    return $app['twig']->render('index.twig');
});

$app->run();