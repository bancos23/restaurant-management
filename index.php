<?php

require __DIR__.'/vendor/autoload.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__.'/error_log.txt');

use App\Config\Config;

Config::getInstance();

$config = Config::getInstance();
$config->renderContent(); 