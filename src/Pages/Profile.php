<?php
/**
 * @file profile.p.php
 * @brief Displays a user's profile information.
 * @details
 * This script retrieves and displays a user's profile information based on the username provided in the URL.
 * 
 * - It prepares and executes a SQL query to fetch user data from the `users` table where the username matches the provided parameter.
 * - If no user is found, it redirects to a 404 page.
 * - If a user is found, it displays the user's profile information including their full name, group, phone number, and email.
 * 
 * @author Bancos Gabriel
 * @date 2024-11-30
 */

use App\Config\Config;
use App\Config\Database;
use App\Controller\ProfileController;


$dbConnection = Config::getDatabase();
$profileController = new ProfileController($dbConnection);
$user = $profileController->findUser(Config::getPage(1));
if(!$user) {
    header("Location: " . $_ENV['BASE_URL'] . "404");
}
$data = $profileController->getUserData(Config::getPage(1));
?>

<title><?php echo join(" ", [$data->first_name, $data->last_name]); ?></title>

<div class="container">
    <div class="main-content">
        <div class="sidebar">
            <div class="card">
                <div class="card-header"><?php echo join(" ", [$data->first_name, $data->last_name]); ?>'s Profile</div>
                <div class="card-body">
                    <ul class="about-list">
                        <li><i class="nav-icon bi bi-suitcase-lg-fill"></i> <?php echo htmlspecialchars(Database::getData("groups", "name", $data->group)); ?></li>
                        <li><i class="nav-icon bi bi-telephone-fill"></i> <?php echo htmlspecialchars($data->phone); ?></li>
                        <li><i class="nav-icon bi bi-mailbox2"></i> <?php echo htmlspecialchars($data->email); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>