<?php

namespace App\Config;

use Dotenv\Dotenv;
use App\Config\Database;
use App\Controller\ErrorController;

/**
 * @file Config.php
 * @brief Configuration file for the application.
 * @details This file contains the configuration settings for the application, including the database connection settings, the base URL, and the site name. It also contains a class that initializes the database connection and handles the URL routing for the application.
 * @author Bancos Gabriel
 * @date 2024-12-08
 */

class Config {
    /**
    * @var Config The single instance of the Config class.
    */
    private static $instance = null;

    /**
     * @var Database The instance of the Database class.
     */
    private $database;

    /**
     * @var array The URL parts.
     */
    private static $_url = array();

    /**
     * Config constructor initializes necessary services.
     */
    private function __construct() {
        $this->loadEnv();  // Load environment variables
        $this->initializeDatabase();  // Initialize the database
        $this->initializeUrl();
    }

    /**
     * Get the Config instance (Singleton Pattern).
     *
     * @return Config The Config instance.
     */
    public static function getInstance(): Config {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Load environment variables from .env file.
     */
    private function loadEnv(): void {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }

    /**
     * Initialize the Database service.
     */
    private function initializeDatabase(): void {
        $this->database = Database::getInstance();
    }

     /**
     * Get the Database instance.
     *
     * @return Database The Database instance.
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * Get a configuration value from environment variables.
     *
     * @param string $key The key of the config value.
     * @return string|null The config value or null if not found.
     */
    public function getConfigValue(string $key): ?string {
        return $_ENV[$key] ?? null;
    }

    /**
     * Example method to include content (like header, page, footer).
     */
    public function renderContent(): void {
        include_once $this->resolvePath('../../Views/Header.php');
        $page = self::getPagePart(0) ?: 'index';
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
        $pagePath = __DIR__.'../../Pages/' . ucfirst($page) . '.php';

        if (file_exists($pagePath)) {
            include_once $pagePath;
        } else {
            $errorController = new ErrorController();
            $errorController->index();
        }

        include_once $this->resolvePath('../../Views/Footer.php');
    }

    public static function getPage($index = 0) {
        return self::$_url[$index];
    }

    private static function initializeUrl() {
        $url = $_GET['page'] ?? ''; 
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = rtrim($url, '/');
        self::$_url = explode('/', $url); 
    }

    public static function getCurrentPage() {
        $page = self::getPagePart(0) ?: 'index';
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
        $pagePath = __DIR__.'../../Pages/' . ucfirst($page) . '.php';
        if(file_exists($pagePath)) {
            return ucfirst($page);
        } else {
            return '404';
        }
    }

    public static function getPagePart($index = 0) {
        return isset(self::$_url[$index]) ? self::$_url[$index] : null;
    }

    private function resolvePath(string $relativePath): string {
        return realpath(__DIR__ . $relativePath);
    }
}