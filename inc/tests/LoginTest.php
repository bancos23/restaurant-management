
<?php
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    protected $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY, username TEXT, password TEXT)");
        $this->pdo->exec("INSERT INTO users (username, password) VALUES ('testuser', 'testpass')");
        Config::setCon($this->pdo);
    }

    public function testSuccessfulLogin()
    {
        $_POST['aLogin'] = true;
        $_POST['uName'] = 'testuser';
        $_POST['uPass'] = 'testpass';

        ob_start();
        include '/Users/eduhaidu/restaurant-management/inc/pages/login.p.php';
        ob_end_clean();

        $this->assertEquals(1, $_SESSION['user']);
    }

    public function testFailedLogin()
    {
        $_POST['aLogin'] = true;
        $_POST['uName'] = 'wronguser';
        $_POST['uPass'] = 'wrongpass';

        ob_start();
        include '/Users/eduhaidu/restaurant-management/inc/pages/login.p.php';
        ob_end_clean();

        $this->assertEquals('<center><p><font color="red">Wrong password or email!</font></p></center>', $_SESSION['msg']);
    }

    protected function tearDown(): void
    {
        unset($_SESSION['user']);
        unset($_SESSION['msg']);
        unset($_POST['aLogin']);
        unset($_POST['uName']);
        unset($_POST['uPass']);
    }
}

class Config
{
    private static $con;

    public static function setCon($pdo)
    {
        self::$con = $pdo;
    }

    public static function getCon()
    {
        return self::$con;
    }

    public static function gotoPage($page)
    {
        // Redirect to the specified page
    }
}
?>