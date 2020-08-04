<?php

namespace App\Model;

use App\Database\Connection;
use App\Helper\Logger;
use App\Helper\Validator;
use PDOException;

/**
|--------------------------------------------------------------------------
| Main app model
|--------------------------------------------------------------------------
|
| Every model "subclass" will extend this main model class which will
| contain every useful/reusable method on all models.
|
 */
class Model
{

    protected $pdo;
    public $validator;

    public function __construct()
    {
        $this->pdo = new Connection;
        $this->pdo = $this->pdo->connect();
        $this->validator = new Validator;
    }

    /**
     * Method to find a result by a specific column.
     * @param string $model.
     * @param string $column
     * @param int|string $value
     * @return array|false
     */
    public function findBy(string $model, string $column, $value)
    {
        $sql = "SELECT * FROM {$model} WHERE {$column}=:column";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([':column' => $value]);
            return $query->fetch();
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "{$model}_{$column}_findBy_{$value}");
            return false;
        }
    }

    /**
     * Method used to get everything from a specific table.
     * @param string   $table The name of the table.
     * @param int|null $limit (optional) A limit, if it's necessary.
     * @return array|false
     */
    public function findAll(string $table, ?int $limit = null)
    {
        $sql = "SELECT * FROM {$table}";
        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
        }
        try {
            $query = $this->pdo->query($sql);
            return $query->fetchAll();
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "{$table}_findAll");
            return false;
        }
    }

    /**
     * Method to get the count of rows.
     * @param int $id
     */
    public function countRows(int $id)
    {

    }

    /**
     * @return string
     */
    protected function getCurrentTimestamp(): string
    {
        return date("Y-m-d H:i:s");
    }
}
