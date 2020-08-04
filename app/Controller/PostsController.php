<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\Tag;
use Exception;

/**
* |--------------------------------------------------------------------------
* | Posts controller
* |--------------------------------------------------------------------------
* |
* | This will serve as the posts controller.
* |
 * @property Post $Post
 * @property Tag $Tag
 */
class PostsController extends Controller
{

    /**
     * Used to create new posts.
     * @return void
     */
    public function write(): void
    {
        if ($this->request->is('POST')) {
            $slug = null;
            $response['result'] = false;
            if (!empty($this->request->data())) {
                $data = $this->request->data();
                $data['author_id'] = $_SESSION['user']['id'];
                $slug = $this->slugify($data['title']);
                /** @var Post $Post */
                $Post = $this->model('post');
                $data['status'] = $this->isAdminOrAuthor() ? 'approved' : 'created';
                $post = $Post->new(
                    $data['author_id'],
                    $data['title'],
                    $slug,
                    $data['cover'],
                    $data['tags'],
                    $data['status'],
                    $data['content']
                );
                if ($post !== false) {
                    $response['result'] = true;
                    $response['message'] = 'Post successfully created.';
                } else {
                    $response['message'] = 'An error occured, please try again.';
                }
            } else {
                $response['message'] = 'Please enter valid data.';
            }
            $this->newResponse($response);
            if ($response['result']) {
                $this->redirect("/posts/read/{$slug}");
            } else{
                $this->redirect('/posts/write');
            }
        } else {
            /** @var Tag $Tag */
            $Tag = $this->model('tag');
            $tags = $Tag->findAll('tag');
            $this->render('posts/write', [
                'title' => 'Write a new post',
                'tags' => $tags,
            ]);
        }
    }

    /**
     * @param string $slug
     * @return void
     */
    public function read(string $slug): void
    {
        $Post = $this->model('post');
        $post = $Post->findBy('post', 'slug', $slug);
        $this->render('posts/read', [
            'title' => $post['title'],
            'post' => $post,
        ]);
    }
}