<?php

require_once __DIR__.'/../vendor/autoload.php';
//use Service\NewsService;
require_once '../src/services/newsService.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_pgsql',
        'dbname' => 'tech_test',
        'user' => 'silex',
        'password' => 'silex',
    ),
));


$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__ . '/views',
));

$app['news'] = $app->share(function($app)
{
	return new NewsService($app['db']);
});


$app['debug'] = true;
