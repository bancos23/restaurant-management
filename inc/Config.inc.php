<?php
define('BASE_URL', 'http://localhost/');
define('SITE_NAME', 'Restaurant Panel');
define('DB_HOST', 'localhost');
define('DB_NAME', 'panel');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8');

class Config {
    private static $instance = null;
    private static $g_con;
    private static $_url = array();
    
    private function __construct() {
        self::initDatabase();
        self::initUrl();
    }

    public static function init() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public static function getCon() {
        return self::$g_con;
    }

    public static function getPage($index = 0) {
        return self::$_url[$index];        
    }

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

    private static function initUrl() {
        $url = isset($_GET['page']) ? rtrim(filter_var($_GET['page'], FILTER_SANITIZE_URL), '/') : '';
        self::$_url = explode('/', $url);
    }

    public static function gotoPage($page, $delay = false) {
        $url = BASE_URL . $page;
        if ($delay)
            echo '<meta http-equiv="refresh" content="' . $delay . ';url=' . $url . '">';
        else {
            header('Location: ' . $url);
            exit;
        }
    }

    public static function getPagePart($index = 0) {
        return isset(self::$_url[$index]) ? self::$_url[$index] : null;
    }

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

    public static function getCurrentPage() {
        $page = self::getPagePart(0) ?: 'index';
        $page = preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
		$pageFile = 'inc/pages/' . $page . '.p.php';
        if(file_exists($pageFile)) 
            return ucfirst($page);
        else 
            return '404';  
    }

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
    
    public static function getData($table, $data, $id) {
        $q = self::$g_con->prepare('SELECT `'.$data.'` FROM `'.$table.'` WHERE `id` = :id');
        $q->execute(['id' => $id]);
        return $q->fetchColumn();
    }
}
?>