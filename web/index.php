<?php

require('../vendor/autoload.php');

use Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Application;

use Acme\HelloControllerProvider;

// // memulai session
// if (session_status() == PHP_SESSION_NONE) {
//   session_start();
// }

$app = new Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

$app->register(new ServiceControllerServiceProvider());

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

$app->post('/db/', function() use($app) {

  $pesan = "";
  // buat nerima form
  if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $res = $app['pdo']->prepare("INSERT INTO test_table (name) VALUES ('{$name}')");
    if($res->execute()) {
      $pesan = "alert('Data tersimpan !');";
      $_SESSION['nama'] = $name;
    } else {
      $pesan = "alert('Data gagal tersimpan !');";
    }
  }

  return "<script>{$pesan} window.location = \"/db\";</script>";
});

$app->get('/db/', function() use($app) {
  session_start();
  $res = $app['pdo']->prepare('SELECT name FROM test_table');
  $res->execute();

  $html = "";
  while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $html .= "<li>{$row['name']}</li>";
  }

  $form = '
    <form action="" method="post">
      <input type="text" name="name">
      <button name="submit" type="submit">Simpan</button>
    </form>
  ';

  return `<ul>`.$html.`</ul>`.$form . '<br>NAME: '.@$_SESSION['nama'];
});


$app->mount('/blog', new HelloControllerProvider());

Request::enableHttpMethodParameterOverride();
$app->run();
