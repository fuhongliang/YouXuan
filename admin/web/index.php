<?php
//ini_set("display_errors","On");
//error_reporting(E_ALL);
header('Access-Control-Allow-Origin: *');

//todo
if (!empty($_POST['r'])) {

}

error_reporting(E_ERROR | E_PARSE);

require __DIR__ . '/../vendor/autoload.php';

$app = new app\hejiang\Application();
$app->run();
