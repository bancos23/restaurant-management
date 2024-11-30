<?php
/**
 * @file submit_message.p.php
 * @brief Submit Message Page
 * @details
 * Handles the submission of a message via a POST request.
 * 
 * This script processes a POST request to submit a message. It retrieves the sender's
 * information, determines the sender's group, and inserts the message into the database.
 * 
 * @file /Users/eduhaidu/restaurant-management/inc/pages/submit_message.p.php
 * 
 * @package RestaurantManagement
 * @version 1.0
 * @date 2024-11-30
 * @author Bancos Gabriel
 * 
 */
?>
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