<?php
define('ROOT', dirname(__DIR__));
require ROOT . '\dispatcher.php';
session_start();
define('DEFAULT_CONTROLLER', 'page');
require ROOT . '\controller\controller.php';
require ROOT . '\model\model.php';
require ROOT . '\view\view.php';


$disp = new Dispatcher();
$controller = $_GET['c'];
$action = $_GET['a'];
if (empty($controller)) {
    $controller = DEFAULT_CONTROLLER;
}
if (empty($action)) {
    $action = 'index';
}

$disp->Dispatch($controller, $action); // dispatch controller and action associated