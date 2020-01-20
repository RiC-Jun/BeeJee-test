<?php
session_start();

require __DIR__ . '/App/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$ctrl  = (count($parts) > 2) ? ucfirst($parts[1]) : 'Index';

$class = '\App\Controllers\\' . $ctrl;
$ctrl = new $class;
$ctrl();