<?php

define("ROOT", dirname(__FILE__));
require_once (ROOT.'/app/lib/Dev.php');
require_once (ROOT.'/app/lib/ClassAutoLoad.php');

use app\core\Router;

ini_set('session.gc_maxlifetime', 86400);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);
session_start();

$router = new Router;
$router->run();





