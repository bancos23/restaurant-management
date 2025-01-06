<?php

namespace App\Controller;

use PDO;
use PDOException;

class ProfileController
{
    private PDO $dbConnection;

    public function __construct(PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }
    /**
     * Handles user profile
     *
     * @param string $username
     * @return bool Returns true on successful finding user, false otherwise.
     */
    public function findUser(string $username): bool
    {
        try {
            $q = $this->dbConnection->prepare('SELECT * FROM `users` WHERE `username` = :username');
            $q->bindParam(':username', $username);
            $q->execute();

            if($q->rowCount()) {
                return true;
            }

            return false;

        } catch(PDOException $e) {
            error_log("Profile Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Handles user data
     *
     * @param string $username
     * @return object Returns user data.
     */
    public function getUserData($username): object
    {
        $q = $this->dbConnection->prepare('SELECT * FROM `users` WHERE `username` = :username');
        $q->bindParam(':username', $username);
        $q->execute();
        return $q->fetch(PDO::FETCH_OBJ);
    }
}