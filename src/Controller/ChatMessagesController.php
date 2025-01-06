<?php


namespace App\Controller;

use PDO;
use PDOException;

use App\Config\Config;
use App\Config\Database;

class ChatMessagesController
{
    private PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function submitMessage() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sender = $_POST['sender'];
            $group = Database::getData('users', 'group', $sender);
            $message = $_POST['message'];

            if (isset($message) && !empty($message)) {
                $q = $this->dbConnection->prepare("INSERT INTO `messages` (`sender`, `group`, `message`, `time`) VALUES (?, ?, ?, NOW())");
                $q->execute(array($sender, $group, $message));
                $_POST['message'] = '';
            }
        }
    }

    public function fetchMessages(): array
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sender = $_POST['sender'];
            $group = Database::getData("users", "group", $sender);

            $sql = "SELECT * FROM `messages` WHERE `group` = ? ORDER BY time ASC";
            $stmt = $this->dbConnection->prepare($sql);
            $stmt->execute(array($group));
            $messages = $stmt->fetchAll(PDO::FETCH_OBJ);

            if ($messages) {
                foreach ($messages as $message) {
                    $name = join(" ", [Database::getData("users", "first_name", $message->sender), Database::getData("users", "last_name", $message->sender)]);
                    if ($message->sender == $sender) {
                        echo "<div class='direct-chat-msg end'>
                                <div class='direct-chat-infos clearfix'>
                                    <span class='direct-chat-name float-end'>{$name}</span>
                                    <span class='direct-chat-timestamp float-start'>{$message->time}</span>
                                </div>
                                <img class='direct-chat-img' src='" . $_ENV['BASE_URL'] . "assets/img/user3-128x128.jpg' alt='message user image'>
                                <div class='direct-chat-text'>{$message->message}</div>
                            </div>";
                    } else {
                        echo "<div class='direct-chat-msg'>
                                <div class='direct-chat-infos clearfix'>
                                    <span class='direct-chat-name float-start'>{$name}</span>
                                    <span class='direct-chat-timestamp float-end'>{$message->time}</span>
                                </div>
                                <img class='direct-chat-img' src='" . $_ENV['BASE_URL'] . "assets/img/user1-128x128.jpg' alt='message user image'>
                                <div class='direct-chat-text'>{$message->message}</div>
                            </div>";
                    }
                }
            }
            exit;
        }
    }
}