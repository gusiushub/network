<?php

define("ROOT", dirname(__FILE__));
require_once (ROOT.'/app/lib/Dev.php');
require_once (ROOT.'/app/lib/ClassAutoLoad.php');

use app\core\Router;

session_start();

$router = new Router;
$router->run();





