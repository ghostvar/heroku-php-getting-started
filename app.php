<?php
require('../vendor/autoload.php');

use Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider;
use Symfony\Component\HttpFoundation\Session\Session;
use Silex\Provider\MonologServiceProvider;
use Silex\Application;


$app = new Application();
$app['debug'] = true;

// Register session
$app['session'] = new Session();
$app['session']->start();

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

// auth middleware
$app['authx'] = function () use ($app) {
  // redirect the user to the login screen if no access
  if (null === $user = $app['session']->get('user')) {
    return $app->redirect('/login');
  }
  $app['user'] = $user;
};


// Our web handlers

$app->get('/a', function () use ($app) {
  return 'A'; //???
});

$app->mount('/', include 'handler/mainHandler.php');
$app->mount('/blog', include 'handler/blogHandler.php');
$app->mount('/db', include 'handler/dbHandler.php');
