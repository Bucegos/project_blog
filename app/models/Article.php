<?php
namespace App\Model;

use App\Helper\Logger;
use PDOException;
/**
 * Used to handle database requests related to articles.
 */
class Article extends Model
{
    /**
     * @param int $author        The current logged user.
     * @param string $title      Article title.
     * @param string $slug       The formatted title.
     * @param string|null $cover The cover image of the article.
     * @param array|null $tagIds (optional) The tags applied to the article.
     * @param string $status     (optional) The status of the article: 'approved' if the user is admin or author, 'created' otherwise.
     * @param string $content    (optional) The content of the article.
     * @return string|false
     */
    public function new(int $author, string $title, string $slug, ?string $cover = null, ?array $tagIds = null, string $status = 'created', string $content = 'Draft')
    {
        $currentTimestamp = $this->getCurrentTimestamp();
        $sql = "INSERT INTO
            article(author_id, title, slug, cover, status, content, created_at)
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
            $articleId = $this->pdo->lastInsertId();
            foreach ($tagIds as $tagId) {
                $sql = "INSERT INTO article_tags(article_id, tag_id) VALUES (:article_id, :tag_id)";
                try {
                    $query = $this->pdo->prepare($sql);
                    $query->execute([
                        ':article_id' => $articleId,
                        ':tag_id' => $tagId,
                    ]);
                } catch (PDOException $e) {
                    Logger::logError($e->getMessage(), "article_tag_new_{$articleId}");
                    return false;
                }
            }
            return true;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), "article_new_{$author}");
            return false;
        }
    }

    /**
     * Query used to get one or multiple articles with the user and tags related info.
     * @param int|null $id Article id.
     * @return array|false
     */
    public function getArticlesFull(?int $id = null)
    {
        $sql = 'SELECT `article`.id, `article`.title, `article`.content, `article`.cover, 
            `article`.status, `article`.created_at, `article`.slug, 
            count(DISTINCT `article_likes`.liked_by) as likes, 
            JSON_ARRAYAGG(`article_likes`.liked_by) AS likedBy,
            JSON_ARRAYAGG(`tag`.name) AS tags,
            JSON_ARRAYAGG(`article_saves`.saved_by) AS savedBy,
            `user`.username, `user`.image
        FROM `article`
        LEFT JOIN `article_likes` 
            ON `article`.id = `article_likes`.article_id
        LEFT JOIN `article_tags` 
            ON `article`.id = `article_tags`.article_id
        LEFT JOIN `article_saves` 
            ON `article`.id = `article_saves`.article_id
        LEFT JOIN `tag` 
            ON `article_tags`.tag_id = `tag`.id
        LEFT JOIN `user` 
            ON `article`.author_id = `user`.id    
        WHERE `article`.status = "approved"';
        if ($id !== null) {
            $sql .= " AND `article`.id = {$id} GROUP BY `article`.id";
        } else {
            $sql .= " GROUP BY `article`.id";
        }
        try {
            $query = $this->pdo->query($sql);
            $articles = $query->fetchAll();
            foreach ($articles as &$article) {
                $article['tags'] = json_decode($article['tags']);
                $article['likedBy'] = json_decode($article['likedBy']);
                $article['savedBy'] = json_decode($article['savedBy']);
                foreach ($article['tags'] as $tag) {
                    if ($tag !== null) {
                        $article['tags'][] = $tag;
                    } else {
                        $article['tags'] = null;
                    }
                }
                foreach ($article['likedBy'] as $like) {
                    if ($like !== null) {
                        $article['likedBy'][] = $like;
                    } else {
                        $article['likedBy'] = null;
                    }
                }
                foreach ($article['savedBy'] as $save) {
                    if ($save !== null) {
                        $article['savedBy'][] = $save;
                    } else {
                        $article['savedBy'] = null;
                    }
                }
                if (!empty($article['tags'])) {
                    $article['tags'] = array_unique($article['tags']);
                }
                if (!empty($article['likedBy'])) {
                    $article['likedBy'] = array_unique($article['likedBy']);
                }
                if (!empty($article['saves'])) {
                    $article['savedBy'] = array_unique($article['savedBy']);
                }
            }
            return $articles;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), 'getArticlesFull');
            return false;
        }
    }
}