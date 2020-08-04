<?php

namespace App\Controller;

use App\Model\Post;

/**
 * |--------------------------------------------------------------------------
* | Home controller
* |--------------------------------------------------------------------------
* |
* | This will serve as the default controller.
* |
 * @property Post $Post
 */
class HomeController extends Controller
{
    /**
     * Index method.
     * @return void
     */
    public function index(): void
    {
        /** @var Post $Post */
        $Post = $this->model('Post');
        $posts = $Post->getPostsWithUserAndTags();
        $this->render('home/index', [
            'title' => 'Home',
            'posts' => $posts,
        ]);
    }
}
