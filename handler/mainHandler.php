<?php

$main = $app['controllers_factory'];

$app->get('/login', function () use ($app) {
  return (
    "<h1>Halaman Login</h1>".
    "<a href=\"/admin\">admin</a>"
  );
});

$main->get('/admin', function () use ($app) {
  return "admin";
});

$main->before($app['authx']);

return $main;
