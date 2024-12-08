use PHPUnit\Framework\TestCase;
username TEXT,

<?php

class EmployeesPageTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->pdo->exec("CREATE TABLE users (
            id INTEGER PRIMARY KEY,
            first_name TEXT,
            last_name TEXT,
            `group` TEXT,
            days_off INTEGER
        )");

        $this->pdo->exec("CREATE TABLE groups (
            id INTEGER PRIMARY KEY,
            name TEXT
        )");

        Config::setCon($this->pdo);
    }

    public function testNoUsersFound()
    {
        ob_start();
        include '/Users/eduhaidu/restaurant-management/inc/pages/employees.p.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('No users found.', $output);
    }

    public function testUsersDisplayed()
    {
        $this->pdo->exec("INSERT INTO users (username, first_name, last_name, `group`, days_off) VALUES
            ('jdoe', 'John', 'Doe', '1', 5),
            ('asmith', 'Alice', 'Smith', '2', 3)");

        $this->pdo->exec("INSERT INTO groups (id, name) VALUES
            (1, 'Admin'),
            (2, 'User')");

        ob_start();
        include '/Users/eduhaidu/restaurant-management/inc/pages/employees.p.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('John Doe', $output);
        $this->assertStringContainsString('Alice Smith', $output);
        $this->assertStringContainsString('Admin', $output);
        $this->assertStringContainsString('User', $output);
        $this->assertStringContainsString('5', $output);
        $this->assertStringContainsString('3', $output);
    }
}

class Config
{
    private static $con;

    public static function setCon($con)
    {
        self::$con = $con;
    }

    public static function getCon()
    {
        return self::$con;
    }

    public static function getData($table, $column, $value)
    {
        $stmt = self::$con->prepare("SELECT $column FROM $table WHERE id = ?");
        $stmt->execute([$value]);
        return $stmt->fetchColumn();
    }
}
?>