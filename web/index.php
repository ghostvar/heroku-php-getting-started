<h1>Helo World!</h1>

<?php

require('../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
echo "<br config=\""."\">";
$dotenv->load();
