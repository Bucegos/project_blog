<?php
namespace App\Controller;

use App\Model\User;
use Exception;
/**
 * Basically the 'security' controller, used for logging and registering.
 * @property User $User
 */
class AuthController extends Controller
{
    /**
     * TODO: Go for full frontend -> UI.JS will handle all the modifications.
     * Login method.
     * @throws Exception
     * @return void
     */
    public function login(): void
    { // https://www.youtube.com/watch?v=wUkKCMEYj9M password recovery system!
        if ($this->request->is('POST') && !isset($_SESSION['user'])) {
            $response['result'] = false;
            if (!empty($this->request->data())) {
                $data = $this->request->data();
                $User = $this->model('user');
                $user = $User->findBy('user', 'username', $data['username']);
                if ($user !== false) {
                    $verified = password_verify($data['password'], $user['password']);
                    if ($verified !== false) {
                        $response['result'] = true;
                        $response['message'] = 'User successfully logged in.';
                        unset($user['password']);
                        $response['user'] = $user;
                        $_SESSION['user'] = $user;
                    } else {
                        $response['message'] = 'Wrong password';
                    }
                } else {
                    $response['message'] = 'Username not found.';
                }
            } else {
                $response['message'] = 'Please enter valid data.';
            }
            $this->newResponse($response);
            if ($response['result']) {
                if ($this->referer !== HOST . 'auth/register') {
                    $this->redirect($this->referer);
                } else {
                    $this->redirect('/');
                }
            } else {
                $this->redirect('/');
            }
        } else {
            if (isset($_SESSION['user'])) {
                $response = [
                    'result' => false,
                    'message' => 'You area already logged in.',
                ];
                $this->newResponse($response);
                $this->redirect('/');
            } else {
                throw new Exception('Method not allowed.');
            }
        }
    }

    /**
     * Registering the user and sign in automatically.
     * @return void
     */
    public function register(): void
    {
        if ($this->request->is('POST')) {
            $response['result'] = false;
            if (!empty($this->request->data())) {
                $data = $this->request->data();
                /** @var User $User */
                $User = $this->model('user');
                $User->validator->notBlank($data);
                $hashedPass = password_hash($data['password'], PASSWORD_BCRYPT);
                $user = $User->new($data['username'], $data['email'], $hashedPass);
                if ($user !== false) {
                    $response['result'] = true;
                    $response['message'] = 'User successfully registered.';
                    // unset the password and 'log' the user
                    unset($user['password']);
                    $_SESSION['user'] = $user;
                } else {
                    $response['message'] = 'An error occured, please try again.';
                }
            } else {
                $response['message'] = 'Please enter valid data.';
            }
            $this->newResponse($response);
            if ($response['result']) {
                $this->redirect('/');
            } else{
                $this->redirect('/auth/register');
            }
        } else {
            if (isset($_SESSION['user'])) {
                $response = [
                    'result' => false,
                    'message' => 'You area already logged in.',
                ];
                $this->newResponse($response);
                $this->redirect('/');
            } else {
                $this->render('auth' , 'register', [
                    'title' => 'Register',
                ]);
            }
        }
    }

    /**
     * Logout method.
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        $response = [
            'result' => true,
            'message' => 'Succefully logged out.',
        ];
        $this->newResponse($response);
        $this->redirect('/');
    }
}