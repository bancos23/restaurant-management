<?php
/**
 * @file profile.p.php
 * @brief Profile Page
 * @details
 * This script fetches and displays the profile information of a user based on the username provided in the URL.
 * 
 * It performs the following steps:
 * 1. Prepares and executes a SQL query to fetch user details from the `users` table where the username matches the provided parameter.
 * 2. If no user is found, it redirects to a 404 page.
 * 3. If a user is found, it displays the user's profile information including their full name, group, phone number, and email.
 * 
 * The profile information is displayed in a card format with the following details:
 * - Full name
 * - Group
 * - Phone number
 * - Email
 * 
 * If the user does not exist, a 404 error page is displayed.
 * 
 * @package RestaurantManagement
 * @author Mirth Kevin
 * @date 2024-11-30
 * 
 */
?>
<?php
$q = Config::getCon()->prepare('SELECT * FROM `users` WHERE `username` = ?');
$q->execute(array(Config::getPage(1)));
$data = $q->fetch(PDO::FETCH_OBJ);

if(!$q->rowCount()) 
    Config::gotoPage("404");
else { 
?>
<title><?php echo join(" ", [$data->first_name, $data->last_name]); ?></title>

<div class="container">
    <div class="main-content">
        <div class="sidebar">
            <div class="card">
                <div class="card-header"><?php echo join(" ", [$data->first_name, $data->last_name]); ?>'s Profile</div>
                <div class="card-body">
                    <ul class="about-list">
                        <li><i class="nav-icon bi bi-suitcase-lg-fill"></i> <?php echo htmlspecialchars(Config::getData("groups", "name", $data->group)); ?></li>
                        <li><i class="nav-icon bi bi-telephone-fill"></i> <?php echo htmlspecialchars($data->phone); ?></li>
                        <li><i class="nav-icon bi bi-mailbox2"></i> <?php echo htmlspecialchars($data->email); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>