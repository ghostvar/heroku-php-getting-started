<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register the csanquer/pdo for database service
$dbopts = parse_url(getenv('DATABASE_URL'));
$app->register(
  new Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider('pdo'),
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

$app->get('/db/', function() use($app) {
  $res = $app['pdo']->prepare('SELECT name FROM test_table');
  $res->execute();

  $html = "";
  while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $html .= "<li>{$row['name']}</li>";
  }

  return `<ul>`.$html.`</ul>`;
});

$app->run();
