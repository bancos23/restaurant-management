<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

ini_set('log_errors', 1);
ini_set('error_log', 'error_log');

spl_autoload_register(function ($class) {
    include 'inc/' . $class . '.inc.php';
});

Config::init()->getContent();