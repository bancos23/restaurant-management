<?php
/**
 * @file submit_message.p.php
 * @brief Submits a message to the chat.
 * @details This script is responsible for submitting a message to the chat. It receives the sender and message from the POST request and inserts the message into the database.
 * @author Bancos Gabriel
 * @date 2024-11-30
 */
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender = $_POST['sender'];
    $group = Config::getData('users', 'group', $sender);
    $message = $_POST['message'];

    if(isset($message) && !empty($message)) {
        $q = Config::getCon()->prepare("INSERT INTO `messages` (`sender`, `group`, `message`, `time`) VALUES (?, ?, ?, NOW())");
        $q->execute(array($sender, $group, $message));
        $_POST['message'] = '';
    }
}
?>