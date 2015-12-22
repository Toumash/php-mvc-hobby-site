<?php
define('ROOT',dirname(__DIR__));
require ROOT . '\dispatcher.php';
session_start();


$disp = new Dispatcher();
$disp->Dispatch($_GET['c'],$_GET['a']); // dispatch controller and action associated
echo '<h3 style="color:green;">Program run without any problems <strong>< OK > !</strong></h3>';