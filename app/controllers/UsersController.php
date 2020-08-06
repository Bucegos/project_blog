<?php
namespace App\Controller;

use App\Model\User;
use Exception;
/**
 * This will serve as the users controller.
 * @property User $User
 */
class UsersController extends Controller
{
    private $currentLoggedUser;

    public function __construct()
    {
        $this->currentLoggedUser = $this->getUserId();
        parent::__construct();
    }

    /**
     * Method used to like articles.
     * @throws Exception
     * return void
     */
    public function add(): void
    {
        if ($this->request->is('POST')) {
            $response = [];
            $response['result'] = false;
            if (!empty($this->request->data())) {
                $data = $this->request->data();
                $table = $data['table'];
                $column = $data['column'];
                /** @var User $User */
                $User = $this->model('user');
                if (isset($_SESSION['user'])) {
                    $liked = $User->add($data['article'], $this->currentLoggedUser, "article_$table", $column);
                    if ($liked !== false) {
                        $response['result'] = true;
                        $response['message'] = 'Success!';
                    } else {
                        $response['message'] = 'An error occured, please try again.';
                    }
                } else {
                    $response['message'] = 'Please login to be able to like articles.';
                }
            } else {
                $response['message'] = 'Please enter valid data.';
            }
            $this->newJsonResponse($response);
        } else {
            throw new Exception('Method not allowed.');
        }
    }

    /**
     * Method used to unlike articles.
     * @throws Exception
     * return void
     */
    public function remove(): void
    {
        if ($this->request->is('POST')) {
            $response = [];
            $response['result'] = false;
            if (!empty($this->request->data())) {
                $data = $this->request->data();
                $table = $data['table'];
                $column = $data['column'];
                /** @var User $User */
                $User = $this->model('user');
                $unliked = $User->remove($data['article'], $this->currentLoggedUser, "article_$table", $column);
                if ($unliked !== false) {
                    $response['result'] = true;
                    $response['message'] = 'Success!';
                } else {
                    $response['message'] = 'An error occured, please try again.';
                }
            } else {
                $response['message'] = 'Please enter valid data.';
            }
            $this->newJsonResponse($response);
        } else {
            throw new Exception('Method not allowed.');
        }
    }
}
