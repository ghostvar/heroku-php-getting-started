<?php
require('../vendor/autoload.php');

use Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Application;


$app = new Application();
$app['debug'] = true;

// Register session
$app->register(new Silex\Provider\SessionServiceProvider());

// Register the monolog logging service
$app->register(new MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register the csanquer/pdo for database service
$dbopts = parse_url(getenv('DATABASE_URL'));
$app->register(
  new PDOServiceProvider('pdo'),
  array(
    'pdo.server' => array(
      'driver'   => 'pgsql',
      'user' => $dbopts["user"],
      'password' => $dbopts["pass"],
      'host' => $dbopts["host"],
      'port' => $dbopts["port"],
      'dbname' => ltrim($dbopts["path"], '/')
    )
  )
);

// Our web handlers

$app->get('/', function () use ($app) {
  return 'A'; //???
});

$app->mount('/blog', include 'handler/blogHandler.php');
$app->mount('/db', include 'handler/dbHandler.php');
