<?php
namespace App\Database;

use Exception;
use PDO;
use PDOException;
/**
* |--------------------------------------------------------------------------
* | Connection class
* |--------------------------------------------------------------------------
* | Used to connect to the database.
 */
class Connection
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {
        $this->servername = DATABASE_SERVERNAME;
        $this->username = DATABASE_USERNAME;
        $this->password = DATABASE_PASSWORD;
        $this->dbname = DATABASE_NAME;
    }

    /**
     * Method used to connect to the database.
     * @return PDO
     * @throws Exception
     */
    public function connect(): PDO
    {
        $dsn = "mysql:host=$this->servername;dbname=$this->dbname";
        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
            // set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // set default fetch mode to fetch associative
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}