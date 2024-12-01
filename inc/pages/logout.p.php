<?php
/**
 * @file logout.p.php
 * @brief Logs out the current user.
 * @details This script logs out the current user by unsetting the session variable and redirecting to the login page.
 * @author Bancos Gabriel
 * @date 2024-11-30
 */


unset($_SESSION['user']);
$_SESSION['msg'] = '<div class="alert alert-warning"><i class="fa fa-check sign"></i>You have been logged out!</div>'; 
Config::gotoPage(''); 
session_destroy();
return;
?>