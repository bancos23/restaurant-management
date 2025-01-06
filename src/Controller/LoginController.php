<?php

namespace App\Controller;

use PDO;
use PDOException;

class LoginController
{
    private PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
    * Handles user password
    *
    * @param string $password
    * @param string $userpassword
    * @return bool Returns true if the passwords are the same, otherwise false.
    */
    public function verifyPassword(string $password, string $userpassword): bool
    {
        return $password === $userpassword;
    }

    /**
     * Handles user login
     *
     * @param string $username
     * @param string $password
     * @return bool Returns true on successful login, false otherwise.
     */
    public function performLogin(string $username, string $password): bool
    {
        try {
            $q = $this->dbConnection->prepare('SELECT * FROM `users` WHERE `username` = :username');
            $q->bindParam(':username', $username);
            $q->execute();

            if($q->rowCount()) {
                $user = $q->fetch(PDO::FETCH_OBJ);
                if($this->verifyPassword($password, $user->password)) {
                    $_SESSION['user'] = $user->id;
                    return true;
                }
            }

            $_SESSION['msg'] = '<center><p><font color="red">Wrong password or username!</font></p></center>';
            return false;

        } catch(PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            $_SESSION['msg'] = '<center><p><font color="red">An error occurred. Please try again later.</font></p></center>';
            return false;
        }
    }
}