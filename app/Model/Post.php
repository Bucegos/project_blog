<?php

namespace App\Model;

use App\Helper\Logger;
use PDOException;

/**
 * |--------------------------------------------------------------------------
* | Post model
* |--------------------------------------------------------------------------
* |
 */
class Post extends Model
{

    /**
     * @param int $author        The current logged user.
     * @param string $title      The title of the post.
     * @param string $slug       The formatted title.
     * @param string|null $cover The cover image of the post.
     * @param array|null $tagIds (optional) The tags applied to the post.
     * @param string $status     (optional) The status of the post: 'approved' if the user is admin or author, 'created' otherwise.
     * @param string $content    (optional) The content of the post.
     * @return string|false
     */
    public function new(int $author, string $title, string $slug, ?string $cover = null, ?array $tagIds = null, string $status = 'created', string $content = 'Draft')
    {
        $currentTimestamp = $this->getCurrentTimestamp();
        $sql = "INSERT INTO
            post(author_id, title, slug, cover, status, content, created_at)
            VALUES (:autor_id, :title, :slug, :cover, :status, :content, :created_at)  
        ";
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ':autor_id' => $author,
                ':title' => $title,
                ':slug' => $slug,
                ':cover' => $cover,
                ':content' => $content,
                ':status' => $status,
                ':created_at' => $currentTimestamp,
            ]);
            $postId = $this->pdo->lastInsertId();
            foreach ($tagIds as $tagId) {
                $sql = "INSERT INTO post_tag(post_id, tag_id) VALUES (:post_id, :tag_id)";
                try {
                    $query = $this->pdo->prepare($sql);
                    $query->execute([
                        ':post_id' => $postId,
                        ':tag_id' => $tagId,
                    ]);
                } catch (PDOException $e) {
                    Logger::logError($e->getMessage(), "post_tag_new_{$postId}");
                    return false;
                }
            }
            return true;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "post_new_{$author}");
            return false;
        }
    }

    /**
     * Query used to get one or multiple posts with the user and tags related info.
     * @param int|null $id Post id.
     * @return array|false
     */
    public function getPostsWithUserAndTags(?int $id = null)
    {
        $sql = 'SELECT `post`.id, `post`.title, `post`.content, `post`.cover, 
            `post`.status, `post`.created_at, `post`.slug, 
            count(DISTINCT `post_likes`.liked_by) as likes, 
            JSON_ARRAYAGG(`post_likes`.liked_by) AS likedBy,
            JSON_ARRAYAGG(`tag`.name) AS tags,
            JSON_ARRAYAGG(`post_readers`.user_id) AS readers,
            `user`.username, `user`.image
        FROM `post`
        LEFT JOIN `post_likes` 
            ON `post`.id = `post_likes`.post_id
        LEFT JOIN `post_tag` 
            ON `post`.id = `post_tag`.post_id
        LEFT JOIN `post_readers` 
            ON `post`.id = `post_readers`.post_id
        LEFT JOIN `tag` 
            ON `post_tag`.tag_id = `tag`.id
        LEFT JOIN `user` 
            ON `post`.author_id = `user`.id    
        WHERE `post`.status = "approved"';
        if ($id !== null) {
            $sql .= " AND `post`.id = {$id} GROUP BY `post`.id";
        } else {
            $sql .= " GROUP BY `post`.id";
        }
        try {
            $query = $this->pdo->query($sql);
            $posts = $query->fetchAll();
            foreach ($posts as &$post) {
                $post['tags'] = json_decode($post['tags']);
                $post['likedBy'] = json_decode($post['likedBy']);
                $post['readers'] = json_decode($post['readers']);
                foreach ($post['tags'] as $tag) {
                    if ($tag !== null) {
                        $post['tags'][] = $tag;
                    } else {
                        $post['tags'] = null;
                    }
                }
                foreach ($post['likedBy'] as $like) {
                    if ($like !== null) {
                        $post['likedBy'][] = $like;
                    } else {
                        $post['likedBy'] = null;
                    }
                }
                foreach ($post['readers'] as $reader) {
                    if ($reader !== null) {
                        $post['readers'][] = $reader;
                    } else {
                        $post['readers'] = null;
                    }
                }
                if (!empty($post['tags'])) {
                    $post['tags'] = array_unique($post['tags']);
                }
                if (!empty($post['likedBy'])) {
                    $post['likedBy'] = array_unique($post['likedBy']);
                }
                if (!empty($post['readers'])) {
                    $post['readers'] = array_unique($post['readers']);
                }
            }
            return $posts;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), 'getAllPostsWithUserAndTags');
            return false;
        }
    }
}