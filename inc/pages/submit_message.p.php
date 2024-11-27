<?php
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