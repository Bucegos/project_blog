<?php

namespace App\Model;

use App\Helper\Logger;
use PDOException;

/**
 * |--------------------------------------------------------------------------
* | User model
* |--------------------------------------------------------------------------
* |
 */
class User extends Model
{

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return array|false
     */
    public function new(string $username, string $email, string $password)
    {
        $currentTimestamp = $this->getCurrentTimestamp();
        $sql = "INSERT INTO
            user(username, email, password, created)
            VALUES (:username, :email, :pass, :created)  
        ";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ':username' => $username,
                ':email' => $email,
                ':pass' => $password,
                ':created' => $currentTimestamp,
            ]);
            $userId = $this->pdo->lastInsertId();
            return $this->findBy('user', 'id', $userId);
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "user_new_{$username}");
            return false;
        }
    }

    /**
     * Method used to add a like for a post.
     * @param int $postId    Post id.
     * @param int $userId    User id.
     * @param string $table  The name of the table.
     * @param string $column The name of the column.
     * @return array|false
     */
    public function add(int $postId, int $userId, string $table, string $column)
    {
        $sql = "INSERT INTO
            $table(post_id, $column)
            VALUES (:post_id, :$column)
        ";
        try {
            $query = $this->pdo->prepare($sql);
            return $query->execute([
                ':post_id' => $postId,
                ":$column" => $userId,
            ]);
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "post_likes_{$postId}_{$userId}");
            return false;
        }
    }

    /**
     * Method used to remove a like from a post.
     * @param int $postId Post id.
     * @param int $userId User id.
     * @param string $table  The name of the table.
     * @param string $column The name of the column.
     * @return array|false
     */
    public function remove(int $postId, int $userId, string $table, string $column)
    {
        $sql = "DELETE FROM $table WHERE $table.post_id = :post_id AND $table.$column = :$column";
        try {
            $query = $this->pdo->prepare($sql);
            return $query->execute([
                ':post_id' => $postId,
                ":$column" => $userId,
            ]);
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "post_unlikes_{$postId}_{$userId}");
            return false;
        }
    }
}