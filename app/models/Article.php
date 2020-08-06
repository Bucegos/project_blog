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
     * @param string|null $slug Article slug.
     * @return array|false
     */
    public function getArticlesFull(?string $slug = null)
    {
        $sql = 'SELECT `article`.id, `article`.title, `article`.content, `article`.cover,
            `article`.status, `article`.created_at, `article`.slug,
            count(DISTINCT `article_likes`.liked_by) as liked_by,
            JSON_ARRAYAGG(`article_likes`.liked_by) AS liked_by,
            JSON_ARRAYAGG(`tag`.name) AS tags,
            JSON_ARRAYAGG(`article_bookmarks`.bookmarked_by) AS bookmarked_by,
            `user`.username, `user`.image
        FROM `article`
        LEFT JOIN `article_likes`
            ON `article`.id = `article_likes`.article_id
        LEFT JOIN `article_tags`
            ON `article`.id = `article_tags`.article_id
        LEFT JOIN `article_bookmarks`
            ON `article`.id = `article_bookmarks`.article_id
        LEFT JOIN `tag`
            ON `article_tags`.tag_id = `tag`.id
        LEFT JOIN `user`
            ON `article`.author_id = `user`.id
        WHERE `article`.status = "approved"';
        if ($slug !== null) {
            $sql .= " AND `article`.slug = '{$slug}' GROUP BY `article`.id";
        } else {
            $sql .= " GROUP BY `article`.id";
        }
        try {
            $query = $this->pdo->query($sql);
            $articles = $query->fetchAll();
            foreach ($articles as &$article) {
                $article['tags'] = array_unique(json_decode($article['tags']));
                $article['liked_by'] = array_unique(json_decode($article['liked_by']));
                $article['bookmarked_by'] = array_unique(json_decode($article['bookmarked_by']));
                // Due to how we'll use these values in the view, we need to check if these arrays
                // have a single key-value pair, and if it's '0' => 'null', the key has to be removed.
                if (count($article['tags']) === 1 && $article['tags'][0] === null) {
                    $article['tags'] = null;
                }
                if (count($article['liked_by']) === 1 && $article['liked_by'][0] === null) {
                    $article['liked_by'] = null;
                }
                if (count($article['bookmarked_by']) === 1 && $article['bookmarked_by'][0] === null) {
                    $article['bookmarked_by'] = null;
                }
            }
            return $articles;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), 'getArticlesFull');
            return false;
        }
    }
}
