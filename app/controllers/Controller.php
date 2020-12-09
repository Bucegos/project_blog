<?php
namespace App\Controller;

use App\Helper\Elements;
use App\Helper\Request;
use App\Model\Model;
use App\Model\User;

/**
 * Main app controller.
 * @property User $User
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
     * Instantiate a model.
     * @param string $model The name of the model.
     * @return Model        The new model instance.
     */
    protected function model(string $model): Model
    {
        $model = ucfirst($model);
        $model = MODELS_NAMESPACE . $model;
        return new $model;
    }

    /**
     * Require a view.
     * @param string $folder   The folder where the view is located.
     * @param string $view     The view that should be rendered.
     * @param array|null $data (optional) Data that will be sent to the view.
     * @return void
     */
    protected function render(string $folder, string $view, ?array $data = []): void
    {
        $data = $this->__setCommonViewVariables($data);
        Elements::add('header', $data);
        require_once TEMPLATES . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . "$view.php";
        Elements::add('footer');
    }

    /**
     * Redirect to a given location.
     * @param string $location The given location.
     * @return void
     */
    protected function redirect(string $location): void
    {
        header("Location: {$location}");
    }

    /**
     * Echo a json response.
     * @param array $response
     * @return void
     */
    protected function newJsonResponse(array $response): void
    {
        echo json_encode($response, JSON_PRETTY_PRINT);
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
     * Adding common variables to the view + setting cookies or session/local storage to be used in frontend.
     * @param array $data Array of data comming from each individual controller action which renders a view.
     * @return array      Returning the updated array of data to be used in the view.
     */
    private function __setCommonViewVariables(array $data): array
    {
        // user data.
        if (isset($_SESSION['user'])) {
            $data['user'] = $_SESSION['user'];
            /** @var User $User */
            $User = $this->model('user');
            $data['user']['bookmarks_count'] = $User->getBookmarksCount((int)$data['user']['id']);
            $data['user']['drafts_count'] = $User->getDraftsCount((int)$data['user']['id']);
        }
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
     * Method used to get the user id stored in session.
     * @return int|null Return the user id or null if it's not set.
     */
    protected function getUserId(): ?int
    {
        return isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : null;
    }

    /**
     * Method used to 'slugify' a given string.
     * @param string $string The string to be 'slugified'.
     * @return string        Return the new 'slugified' string.
     */
    public function slugify(string $string): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-')) . '-' . uniqid();
    }
}
