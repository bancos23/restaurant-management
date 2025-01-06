<?php

namespace App\Controller;

use PDO;
use PDOException;

class LogoutController
{
    /**
     * Handles user login
     *
     * @param string $username
     * @param string $password
     * @return bool Returns true on successful login, false otherwise.
     */
    public function performLogout(): bool
    {
        try {
            unset($_SESSION['user']);
            header('Location: index');
            session_destroy();
            return true;

        } catch(PDOException $e) {
            error_log("Logout Error: " . $e->getMessage());
            $_SESSION['msg'] = '<center><p><font color="red">An error occurred. Please try again later.</font></p></center>';
            return false;
        }
    }
}