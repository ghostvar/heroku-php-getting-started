<?php

$main = $app['controllers_factory'];

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
  return $username;
  if(/**case true */ false) {
    return $app->redirect('/admin');
  }
  return $app->redirect('/login');
});

$main->get('/admin', function () use ($app) {
  return "admin";
});

$main->before($authMiddleware);

return $main;
