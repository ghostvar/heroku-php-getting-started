<h1>Helo World!</h1>

<?php

require('../vendor/autoload.php');

$dotenv = new Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "<br config=".$_ENV['DATABASE_URL'].">";