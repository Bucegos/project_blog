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
            } else{
                $this->redirect('/articles/write');
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
        $Article = $this->model('article');
        $article = $Article->findBy('article', 'slug', $slug);
        $this->render('article' , 'read', [
            'title' => $article['title'],
            'article' => $article,
        ]);
    }
}