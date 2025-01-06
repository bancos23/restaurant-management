<?php
/**
 * @file logout.p.php
 * @brief Logs out the current user.
 * @details This script logs out the current user by unsetting the session variable and redirecting to the login page.
 * @author Bancos Gabriel
 * @date 2024-11-30
 */

use App\Controller\LogoutController;
use App\Config\Config;
 
$logoutController = new LogoutController();
$logoutController->performLogout();