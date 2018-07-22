<?php

require_once __DIR__.'/../vendor/autoload.php';
define('PROJECT_ROOT', realpath(__DIR__ . '/../'));
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Exception\ParseException;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => PROJECT_ROOT.'/views',
));

$app->get('/', function() use($app) {
    return $app['twig']->render('index.twig');
});

$app->post('/generate', function(Request $request) use ($app) {
    $contents = $request->get("contents");

    $pkgmeta = new \WowPkgmeta\Pkgmeta();

    try {
        $pkgmeta->load($contents);
    } catch (ParseException $exception) {
        return new Response("Could not parse as YAML - are you sure your .pkgmeta is valid?");
    }



    return new Response("Blorp");
});

$app->run();