<?php
/**
 * @file Config.inc.php
 * @brief Configuration file for the application.
 * @details This file contains the configuration settings for the application, including the database connection settings, the base URL, and the site name. It also contains a class that initializes the database connection and handles the URL routing for the application.
 * @author Bancos Gabriel
 * @date 2024-11-30
 */

define('BASE_URL', 'http://localhost/');
define('SITE_NAME', 'Restaurant Panel');
define('DB_HOST', 'localhost');
define('DB_NAME', 'panel');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

class Config {
    /**
     * @brief The instance of the Config class.
     * @details This variable stores the instance of the Config class.
     */
    private static $instance = null;
    
    /**
     * @brief The database connection object.
     * @details This variable stores the database connection object.
     */
    private static $g_con;
    
    /**
     * @brief The URL array.
     * @details This variable stores the URL array.
     */
    private static $_url = array();
    
    /**
     * @brief Constructor for the Config class.
     * @details This constructor initializes the database connection and URL routing for the application.
     */
    private function __construct() {
        self::initDatabase();
        self::initUrl();
    }

    /**
     * @brief Initializes the Config class.
     * @details This method initializes the Config class and returns the instance of the class.
     * @return Config The instance of the Config class.
     */
    public static function init() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * @brief Gets the database connection.
     * @details This method returns the database connection object.
     * @return PDO The database connection object.
     */
    public static function getCon() {
        return self::$g_con;
    }

    /**
     * @brief Gets the page from the URL.
     * @details This method returns the page from the URL based on the index provided.
     * @param int $index The index of the page in the URL.
     * @return string The page from the URL.
     */
    public static function getPage($index = 0) {
        return self::$_url[$index];        
    }

    /**
     * @brief Initializes the database connection.
     * @details This method initializes the database connection using the database connection settings defined in the configuration file.
     */
    private static function initDatabase() {
        try {
            self::$g_con = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET,
                DB_USER, DB_PASS
            );
            self::$g_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$g_con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            file_put_contents('error_log', $e->getMessage() . PHP_EOL, FILE_APPEND);
            die('[MySQL] Connection failed!');
        }
    }

    /**
     * @brief Initializes the URL routing.
     * @details This method initializes the URL routing by parsing the URL and storing it in an array.
     */
    private static function initUrl() {
        $url = isset($_GET['page']) ? rtrim(filter_var($_GET['page'], FILTER_SANITIZE_URL), '/') : '';
        self::$_url = explode('/', $url);
    }

    /**
     * @brief Redirects to a specified page.
     * @details This method redirects to a specified page with an optional delay.
     * @param string $page The page to redirect to.
     * @param int|bool $delay The delay in seconds before redirecting, or false for no delay.
     */
    public static function gotoPage($page, $delay = false) {
        $url = BASE_URL . $page;
        if ($delay)
            echo '<meta http-equiv="refresh" content="' . $delay . ';url=' . $url . '">';
        else {
            header('Location: ' . $url);
            exit;
        }
    }

    /**
     * @brief Gets the page part from the URL.
     * @details This method returns the page part from the URL based on the index provided.
     * @param int $index The index of the page part in the URL.
     * @return string The page part from the URL.
     */
    public static function getPagePart($index = 0) {
        return isset(self::$_url[$index]) ? self::$_url[$index] : null;
    }

    /**
     * @brief Gets the content of the page.
     * @details This method includes the header, content, and footer of the page based on the URL.
     */
    public static function getContent() {
        include 'inc/header.inc.php';
    
        $page = self::getPagePart(0) ?: 'index';
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
        $pageFile = 'inc/pages/' . $page . '.p.php'; 
    
        if (file_exists($pageFile))
            include $pageFile;
        else 
            include 'inc/pages/404.p.php';
    
        include 'inc/footer.inc.php';
    }

    /**
     * @brief Gets the current page.
     * @details This method returns the current page based on the URL.
     * @return string The current page.
     */
    public static function getCurrentPage() {
        $page = self::getPagePart(0) ?: 'index';
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
		$pageFile = 'inc/pages/' . $page . '.p.php';
        if(file_exists($pageFile)) 
            return ucfirst($page);
        else 
            return '404';  
    }

    /**
     * @brief Gets the total number of rows in a table.
     * @details This method returns the total number of rows in a specified table.
     * @param string|array $table The table or tables to count the rows from.
     * @return int The total number of rows in the table.
     */
    public static function rows($table) {
        $allowedTables = ['users', 'posts', 'comments']; 
        if (is_array($table)) {
            $rows = 0;
            foreach ($table as $val) {
                if (!in_array($val, $allowedTables))
                    continue;
                $q = self::$g_con->prepare("SELECT COUNT(*) FROM `".$val."`");
                $q->execute();
                $rows += $q->fetchColumn();
            }
            return $rows;
        }
        if (!in_array($table, $allowedTables)) 
            return 0;

        $q = self::$g_con->prepare("SELECT COUNT(*) FROM `".$table."`");
        $q->execute();
        return $q->fetchColumn();
    }
    
    /**
     * @brief Gets data from a table.
     * @details This method retrieves data from a specified table based on the data and ID provided.
     * @param string $table The table to retrieve data from.
     * @param string $data The data to retrieve from the table.
     * @param int $id The ID of the data to retrieve.
     * @return string The data retrieved from the table.
     */
    public static function getData($table, $data, $id) {
        $q = self::$g_con->prepare('SELECT `'.$data.'` FROM `'.$table.'` WHERE `id` = :id');
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }
}
?>