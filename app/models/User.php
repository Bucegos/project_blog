<?php
namespace App\Model;

use App\Helper\Logger;
use PDOException;
/**
 * User model.
 */
class User extends Model
{
    public CONST ADMIN = 'Admin';
    public CONST AUTHOR = 'Author';
    public CONST User = 'User';

    /**
     * @param string $username The given username.
     * @param string $email    The given email.
     * @param string $password The hashed password.
     * @return array|false     Return the new created user or false if the creation failed.
     */
    public function new(string $username, string $email, string $password)
    {
        $currentTimestamp = $this->getCurrentTimestamp();
        $sql = "INSERT INTO
            user(username, email, password, joined)
            VALUES (:username, :email, :pass, :joined)
        ";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ':username' => $username,
                ':email' => $email,
                ':pass' => $password,
                ':joined' => $currentTimestamp,
            ]);
            $userId = $this->pdo->lastInsertId();
            return $this->findBy('user', 'id', $userId);
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "user_new_{$username}");
            return false;
        }
    }

    /**
     * Method used to add a like for a article.
     * @param int $articleId Article id.
     * @param int $userId    User id.
     * @param string $table  The name of the table.
     * @param string $column The name of the column.
     * @return array|false
     */
    public function add(int $articleId, int $userId, string $table, string $column)
    {
        $sql = "INSERT INTO
            $table(article_id, $column)
            VALUES (:article_id, :$column)
        ";
        try {
            $query = $this->pdo->prepare($sql);
            return $query->execute([
                ':article_id' => $articleId,
                ":$column" => $userId,
            ]);
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "article_likes_{$articleId}_{$userId}");
            return false;
        }
    }

    /**
     * Method used to remove a like from an article.
     * @param int $articleId Article id.
     * @param int $userId    User id.
     * @param string $table  The name of the table.
     * @param string $column The name of the column.
     * @return array|false
     */
    public function remove(int $articleId, int $userId, string $table, string $column)
    {
        $sql = "DELETE FROM $table WHERE $table.article_id = :article_id AND $table.$column = :$column";
        try {
            $query = $this->pdo->prepare($sql);
            return $query->execute([
                ':article_id' => $articleId,
                ":$column" => $userId,
            ]);
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "article_unlikes_{$articleId}_{$userId}");
            return false;
        }
    }

    /**
     * Method used to remove a like from an article.
     * @param int $articleId Article id.
     * @param int $userId    User id.
     * @param string $table  The name of the table.
     * @param string $column The name of the column.
     * @return array|false
     */
    public function getReadingList(int $articleId, int $userId, string $table, string $column)
    {
        // TODO: modify -> will use in /users/reading-list
        $sql = "DELETE FROM $table WHERE $table.article_id = :article_id AND $table.$column = :$column";
        try {
            $query = $this->pdo->prepare($sql);
            return $query->execute([
                ':article_id' => $articleId,
                ":$column" => $userId,
            ]);
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "article_unlikes_{$articleId}_{$userId}");
            return false;
        }
    }

    /**
     * Method used to get the reading list count.
     * @param int $userId User id.
     * @return int|false
     */
    public function getBookmarksCount(int $userId)
    {
        $sql = "SELECT COUNT(*) FROM `article_bookmarks` WHERE `article_bookmarks`.bookmarked_by = :userId";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ":userId" => $userId,
            ]);
            return $query->fetchColumn();
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), 'getBookmarksCount');
            return false;
        }
    }

    /**
     * Method used to get the reading list count.
     * @param int $userId User id.
     * @return int|false
     */
    public function getDraftsCount(int $userId)
    {
        $sql = "SELECT COUNT(*) FROM `article` WHERE `article`.status = 'draft' AND `article`.author_id = :userId";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ":userId" => $userId,
            ]);
            return $query->fetchColumn();
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), 'getBookmarksCount');
            return false;
        }
    }

    /**
     * Verifies whether the user has role admin or not.
     * @param int $userId The given user id.
     * @return bool       True if the user is admin, false otherwise.
     */
    public function isAdmin(int $userId): bool
    {
        $sql = "SELECT COUNT(*) FROM `user` WHERE `user`.id = :userId AND `user`.role = :role";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ':userId' => $userId,
                ':role' => self::ADMIN,
            ]);
            return $query->fetchColumn() > 0;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "isAdmin");
            return false;
        }
    }

    /**
     * Verifies whether the user has role author or not.
     * @param int $userId The given user id.
     * @return bool       True if the user is author, false otherwise.
     */
    public function isAuthor(int $userId): bool
    {
        $sql = "SELECT COUNT(*) FROM `user` WHERE `user`.id = :userId AND `user`.role = :role";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ':userId' => $userId,
                ':role' => self::AUTHOR,
            ]);
            return $query->fetchColumn() > 0;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "isAdmin");
            return false;
        }
    }
}
