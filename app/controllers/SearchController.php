<?php
namespace App\Controller;

/**
 * This will serve as the search controller.
 */
class SearchController extends Controller
{
    /**
     * Index method.
     * @return void
     */
    public function index(): void
    {
        $this->render('search', 'index', [
            'title' => 'Articles',
        ]);
    }
}