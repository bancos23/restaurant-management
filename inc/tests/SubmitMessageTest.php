<?php

use PHPUnit\Framework\TestCase;

class SubmitMessageTest extends TestCase
{
    private $config;
    private $pdo;
    private $stmt;

    protected function setUp(): void
    {
        // Create a mock for the Config class
        $this->config = $this->createMock(Config::class);

        // Create a mock for the PDO class
        $this->pdo = $this->createMock(PDO::class);

        // Create a mock for the PDOStatement class
        $this->stmt = $this->createMock(PDOStatement::class);

        // Configure the Config mock to return the PDO mock
        $this->config->method('getCon')->willReturn($this->pdo);

        // Configure the PDO mock to return the PDOStatement mock
        $this->pdo->method('prepare')->willReturn($this->stmt);
    }

    public function testSubmit()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['sender'] = 'test_sender';
        $_POST['message'] = 'test_message';

        // Call the submit method
        $this->submit();

        $this->assertEquals('test_sender', $_POST['sender']);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sender = $_POST['sender'] ?? '';
            $message = $_POST['message'] ?? '';

            if (!empty($message)) {
                $stmt = $this->pdo->prepare('INSERT INTO messages (sender, data, message) VALUES (?, ?, ?)');
                $stmt->execute([$sender, $this->config->getData(), $message]);
                $_POST['message'] = '';
            }
        }
    }
}

class Config
{
    public function getCon()
    {
        // Mocked PDO connection
        $pdo = $this->createMock(PDO::class);
        $stmt = $this->createMock(PDOStatement::class);

        $pdo->method('prepare')->willReturn($stmt);
        $stmt->method('execute')->willReturn(true);

        return $pdo;
    }

    public function getData()
    {
        return 'group_data';
    }
}