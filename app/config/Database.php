<?php

namespace App\Config;

use PDO;
use PDOException;

/**
 * |--------------------------------------------------------------------------
* | Database class
* |--------------------------------------------------------------------------
* |
* | Connecting to the database using PDO.
* |
 */
class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    /**
     * Method used to connect to the database.
     * @return PDO|void
     */
    public function connect(): PDO
    {
        $this->servername = 'localhost';
        $this->username = 'root';
        $this->password = 'K!illerH!ills007';
        $this->dbname = 'blog';

        $dsn = "mysql:host=$this->servername;dbname=$this->dbname";

        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
            // set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // set default fetch mode to fetch associative
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}