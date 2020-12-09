<?php
namespace App\Controller;

use App\Model\Article;
/**
 * This will serve as the default controller.
 * @property Article $Article
 */
class HomeController extends Controller
{
    /**
     * Index method.
     * @return void
     */
    public function index(): void
    {
        /** @var Article $Article */
        $Article = $this->model('Article');
        $articles = $Article->getArticlesFull();
//        var_dump($articles); die;
        $this->render('home', 'index', [
            'title' => 'Home',
            'articles' => $articles,
        ]);
    }
}
