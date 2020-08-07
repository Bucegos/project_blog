<?php
namespace App\Controller;

use App\Model\Article;
use App\Model\Tag;
use App\Model\User;
/**
* This will serve as the articles controller.
 * @property Article $Article
 * @property Tag $Tag
 * @property User $User
 */
class ArticlesController extends Controller
{
    /**
     * Create a new article.
     * @return void
     */
    public function write(): void
    {
        if ($this->request->is('POST')) {
            $slug = null;
            $response['result'] = false;
            if (!empty($this->request->data())) {
                $data = $this->request->data();
                $userId = $this->getUserId();
                $data['author_id'] = $userId;
                $slug = $this->slugify($data['title']);
                /** @var Article $Article */
                $Article = $this->model('article');
                /** @var User $User */
                $User = $this->model('user');
                $data['status'] = $User->isAdmin($userId) || $User->isAuthor($userId) ? 'approved' : 'created';
                $data['tags'] = $data['tags'] ?? null;
                $article = $Article->new(
                    $data['author_id'],
                    $data['title'],
                    $slug,
                    $data['cover'],
                    $data['tags'],
                    $data['status'],
                    $data['content']
                );
                if ($article !== false) {
                    $response['result'] = true;
                    $response['message'] = 'Article successfully created.';
                } else {
                    $response['message'] = 'An error occured, please try again.';
                }
            } else {
                $response['message'] = 'Please enter valid data.';
            }
            $this->newResponse($response);
            if ($response['result']) {
                $this->redirect("/articles/read/{$slug}");
            }
        } else {
            /** @var Tag $Tag */
            $Tag = $this->model('tag');
            $tags = $Tag->findAll('tag');
            $this->render('articles', 'write', [
                'title' => 'Write a new post',
                'tags' => $tags,
            ]);
        }
    }

    /**
     * View a certain article.
     * @param string $slug The article's slug.
     * @return void
     */
    public function read(string $slug): void
    {
        /** @var Article $Article */
        $Article = $this->model('article');
        $article = $Article->getArticlesFull($slug);
        // 'getArticlesFull' method was built to retrieve all articles in case there's no
        // condition applied, but in this case we expect only one, based on slug, so if
        // the query was successfull, we'll only send that to the view due to how we built
        // the 'article' element.
        if ($article !== false) {
            $article = $article[0];
            $article['short_articles'] = $Article->getArticlesShort($this->getUserId(), $slug);
        }
        $this->render('articles' , 'read', [
            'title' => $article['title'],
            'article' => $article,
        ]);
    }
}
