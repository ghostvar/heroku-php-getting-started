<?php

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

$main = $app['controllers_factory'];

$app->get('/', function () {
  return 'Hello, Happy World!'; //???
});

$app->get('/login', function () use ($app) {
  return (
    "<h1>Halaman Login</h1>".
    "<form method=\"POST\">".
      "<input name=\"username\" type=\"text\" placeholder=\"Username\">".
      "<input name=\"password\" type=\"password\" placeholder=\"Password\">".
      "<button type=\"submit\" name=\"submit\">Login</button>".
    "</form>"
  );
});

$app->post('/login', function (Request $request) use ($app) {
  $username = $request->get('username');
  $password = $request->get('password');

  if(!empty($username) && !empty($password)) {
    $app['session']->set('user', array('username' => $username));
    return $app->redirect('/admin');
  }

  return $app->redirect('/login');
});

$main->get('/logout', function () use ($app) {
  $app['session']->set('user', null);
  return $app->redirect('/login');
});

$main->get('/admin', function () use ($app) {
  $user = $app['session']->get('user');
  return (
    "<h1>Halaman Admin</h1>".
    "<p>Welcome {$user['username']}!</p>".
    "<a href=\"/logout\">logout</a>"
  );
});

$main->before($authMiddleware);

return $main;
