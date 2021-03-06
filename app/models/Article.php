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
            if (!empty($tagIds)) {
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
        $sql = 'SELECT `articles`.id, `articles`.title, `articles`.content,
            `articles`.cover, `articles`.created_at, `articles`.slug,
            count(DISTINCT `article_likes`.liked_by) as likes,
            JSON_ARRAYAGG(`article_likes`.liked_by) AS liked_by,
            JSON_ARRAYAGG(`tags`.name) AS tags,
            JSON_ARRAYAGG(`article_bookmarks`.bookmarked_by) AS bookmarked_by,
            `users`.username, `users`.summary as user_summary, `users`.image as user_image, `users`.joined as user_joined
        FROM `articles`
        LEFT JOIN `article_likes`
            ON `articles`.id = `article_likes`.article_id
        LEFT JOIN `article_tags`
            ON `articles`.id = `article_tags`.article_id
        LEFT JOIN `article_bookmarks`
            ON `articles`.id = `article_bookmarks`.article_id
        LEFT JOIN `tags`
            ON `article_tags`.tag_id = `tags`.id
        LEFT JOIN `users`
            ON `articles`.author_id = `users`.id
        WHERE `articles`.status = "approved"';
        if ($slug !== null) {
            $sql .= " AND `articles`.slug = '{$slug}' GROUP BY `articles`.id";
        } else {
            $sql .= " GROUP BY `articles`.id";
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

    /**
     * Query used to get a limited number of articles with the user and tags related info.
     * @param int $userId  User id.
     * @param string $slug The current article's slug, added in where clause so we won't show the same article the user is on in the 'more' section.
     * @return array|false
     */
    public function getArticlesShort(int $userId, string $slug)
    {
        $sql = 'SELECT `article`.id, `article`.title, `article`.slug,
            JSON_ARRAYAGG(`tag`.name) AS tags
        FROM `article`
        LEFT JOIN `article_tags`
            ON `article`.id = `article_tags`.article_id
        LEFT JOIN `tag`
            ON `article_tags`.tag_id = `tag`.id
        WHERE `article`.status = "approved"
            AND `article`.author_id = :user_id
            AND `article`.slug != :slug
        GROUP BY `article`.id
        ORDER BY RAND()
        LIMIT 3';
        try {
            $query = $this->pdo->prepare($sql);
            $query->execute([
                ':user_id' => $userId,
                'slug' => $slug,
            ]);
            $articles = $query->fetchAll();
            foreach ($articles as &$article) {
                $article['tags'] = array_unique(json_decode($article['tags']));
                // Due to how we'll use these values in the view, we need to check if these arrays
                // have a single key-value pair, and if it's '0' => 'null', the key has to be removed.
                if (count($article['tags']) === 1 && $article['tags'][0] === null) {
                    $article['tags'] = null;
                }
            }
            return $articles;
        } catch (PDOException $e) {
            Logger::logError($e->getMessage(), 'getArticlesShort');
            return false;
        }
    }
}
