<?php

namespace App\Controller;

use App\Helper\Request;
use App\Model\Model;
use App\Model\Role;

/**
|--------------------------------------------------------------------------
| Main app controller
|--------------------------------------------------------------------------
|
| This controller will be extended by all other controllers so
| every useful/re-usable method will be placed here so it can be inherited.
|
 */
class Controller
{

    protected $request;
    protected $referer;

    public function __construct()
    {
        $this->request = new Request;
        $this->referer = $_SERVER['HTTP_REFERER'] ?? '/';
    }

    /**
     * Require and instantiate a model.
     * @param string $model The name of the model.
     * @return Model        The new model instance.
     */
    protected function model(string $model): Model
    {
        $model = ucfirst($model);
        require_once ROOT . '/model/' . "{$model}.php";
        $model = "App\Model\\{$model}";
        return new $model;
    }

    /**
     * Require a view.
     * @param string $view The view that should be rendered.
     * @param array $data  Data that will be sent to the view.
     * @return void
     */
    protected function render(string $view, array $data = []): void
    {
        $data = $this->__setCommonViewVariables($data);
        require_once ROOT . '/templates/layout/header.php';
        require_once ROOT . '/templates/' . "{$view}.php";
        require_once ROOT . '/templates/layout/footer.php';
    }

    /**
     * Redirect to a given location.
     * @param string $location
     * @return void
     */
    protected function redirect(string $location): void
    {
        header("Location: {$location}");
    }

    /**
     * Echo a json response.
     * @param array $result
     * @return void
     */
    protected function newJsonResponse(array $result): void
    {
        echo json_encode($result, JSON_PRETTY_PRINT);
    }

    /**
     * Set a new response in $_SESSION.
     * @param array $response
     * @return void
     */
    protected function newResponse(array $response): void
    {
        $_SESSION['response']['message'] = $response['message'];
        $_SESSION['response']['result'] = $response['result'];
    }

    /**
     * Adding common variables to the view + setting cookies to be used in frontend.
     * @param array $data
     * @return array
     */
    private function __setCommonViewVariables(array $data): array
    {
        // setting common variables to be used in frontend or backend.
        $data['user'] = isset($_SESSION['user']) ? $_SESSION['user'] : null;
        $data['user']['reading_list_count'] = $this->model('user')->getReadinglistCount((int)$data['user']['id']);
        // setting the response for the view.
        if (isset($_SESSION['response'])) {
            $data['response']['message'] = $_SESSION['response']['message'];
            if ($_SESSION['response']['result']) {
                $data['response']['icon'] = 'check.png';
            } else {
                $data['response']['icon'] = 'error.png';
            }
            unset($_SESSION['response']);
        }
        return $data;
    }

    /**
     * @param $string
     * @return string
     */
    public function slugify($string): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-')) . uniqid();
    }

    protected function isAdminOrAuthor()
    {
        if (isset($_SESSION['user'])) {
            if (
                $_SESSION['user']['role'] === Role::ADMIN ||
                $_SESSION['user']['role'] === Role::AUTHOR
            ) {
                return true;
            }
        }
        return false;
    }
}
