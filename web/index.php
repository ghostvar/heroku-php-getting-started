<h1>Helo World!</h1>

<?php

require('../vendor/autoload.php');
echo "<br config=\""."\">";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
