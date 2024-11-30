<?php
/**
 * @file logout.p.php
 * @brief Logout Page
 * @details
 * Logs out the current user by unsetting the 'user' session variable,
 * setting a logout message, redirecting to the home page, and destroying the session.
 *
 * Actions performed:
 * - Unsets the 'user' session variable.
 * - Sets a session message indicating the user has been logged out.
 * - Redirects to the home page using Config::gotoPage().
 * - Destroys the session.
 * 
 * @package RestaurantManagement
 * @author Bancos Gabriel
 * @date 2024-11-30
 */
?>
<?php
unset($_SESSION['user']);
$_SESSION['msg'] = '<div class="alert alert-warning"><i class="fa fa-check sign"></i>You have been logged out!</div>'; 
Config::gotoPage(''); 
session_destroy();
return;
?>