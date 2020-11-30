<?php

$main = $app['controllers_factory'];

$main->get('/admin', function () use ($app) {
  return "admin";
});

return $main;
