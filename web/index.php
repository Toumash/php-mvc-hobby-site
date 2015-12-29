<?php
define('ROOT', dirname(__DIR__));
require ROOT . '/dispatcher.php';
session_start();
define('DEFAULT_CONTROLLER', 'page');
require ROOT . '/controller/Controller.php';
require ROOT . '/model/model.php';
require ROOT . '/view/view.php';
error_reporting(E_ALL);


$disp = new Dispatcher();
$controller = isset($_GET['c']) ? $_GET['c'] : DEFAULT_CONTROLLER;
$action = isset($_GET['a']) ? $_GET['a'] : 'index';

$disp->Dispatch($controller, $action); // dispatch controller and action associated