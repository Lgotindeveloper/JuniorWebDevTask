<?php

//Включить отображение ошибок
//ini_set("display_errors", 1);
//error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
$cache_path = __DIR__  . '/cache';

require_once(ROOT . "/components/Router.php");
//На будущее, если используем не sqlite3
//require_once(ROOT . "/components/Db.php");

$router = new Router();
$router->execute();