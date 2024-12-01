<?php
/**
 * @file fetch_messages.p.php
 * @brief Fetches messages for a given user and group from the database and displays them in a chat format.
 * @details
 * This script fetches messages for a given user and group from the database and displays them in a chat format.
 * 
 * It expects a POST request with the following parameter:
 * - 'sender': The ID of the user sending the request.
 * 
 * The script performs the following steps:
 * 1. Retrieves the group of the sender from the database.
 * 2. Prepares and executes a SQL query to fetch all messages for the group, ordered by time in ascending order.
 * 3. Fetches all messages as objects.
 * 4. Iterates through the messages and displays them in a chat format.
 *    - If the message sender is the same as the request sender, the message is displayed on the right side.
 *    - Otherwise, the message is displayed on the left side.
 * 
 * Each message includes:
 * - The sender's name (first and last name).
 * - The timestamp of the message.
 * - The sender's profile image.
 * - The message content.
 * 
 * The script exits after processing the messages.
 * @author Bancos Gabriel
 * @date 2024-11-30
 */

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
