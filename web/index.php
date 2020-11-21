<h1>Helo World!</h1>

<?php

echo "<br config=\""."\">";
require('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
