<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = $_POST['sender'];
    $group = Config::getData('users', 'group', $sender);

    $q = Config::getCon()->prepare("SELECT * FROM `messages` WHERE `group` = ? ORDER BY time ASC");
    $q->execute(array($group));

    $messages = $q->fetchAll(PDO::FETCH_OBJ);

    if ($messages) {
        foreach ($messages as $message) {
            $name = join(" ", [Config::getData("users", "first_name", $message->sender), Config::getData("users", "last_name", $message->sender)]);
            if ($message->sender == $sender) { ?>
                <div class="direct-chat-msg end">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-end"><?php echo $name; ?></span>
                        <span class="direct-chat-timestamp float-start"><?php echo $message->time; ?></span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo BASE_URL ?>assets/img/user3-128x128.jpg" alt="message user image">
                    <div class="direct-chat-text"><?php echo $message->message; ?></div>
                </div>
<?php       } else { ?>
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-start"><?php echo $name; ?></span>
                        <span class="direct-chat-timestamp float-end"><?php echo $message->time; ?></span>
                    </div>
                    <img class="direct-chat-img" src="<?php echo BASE_URL ?>assets/img/user1-128x128.jpg" alt="message user image">
                    <div class="direct-chat-text"><?php echo $message->message; ?></div>
                </div>
<?php       }
        }
    }
    exit;
}
?>
