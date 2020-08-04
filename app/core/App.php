<?php

define('ROOT', realpath(__DIR__ . '/..'));
require_once 'autoload.php';
/**
|--------------------------------------------------------------------------
| Main app
|--------------------------------------------------------------------------
|
| The main App class which kickstarts everything being instantiated in
| index.php with every new request.
| Require all the needed files for the application with 'autoload.php'.
|
 */
class App
{

    private $controllerPath = ROOT . '/controller/HomeController.php';
    private $controller = 'App\Controller\HomeController';
    private $method = 'index';
    private $params = [];

    public function __construct()
    {
        $url = $this->__parseUrl();
        $this->__setController($url[0]);
        unset($url[0]);
        $this->controller = new $this->controller;
        if (isset($url[1])) {
            $this->__setMethod($url[1]);
            unset($url[1]);
        }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->params);
        unset($_REQUEST['url']);
    }

    /**
     * Method used to parse the url.
     * @return array|null
     */
    private function __parseUrl(): ?array
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return null;
    }

    /**
     * Method used to set and require the controller.
     * @param string|null $controller
     * @return int
     */
    private function __setController(string $controller = null): int
    {
        if ($controller !== null) {
            $controller = ucfirst($controller);
            $controllerPath = ROOT . "/controller/{$controller}Controller.php";
            if (file_exists($controllerPath)) {
                $this->controllerPath = $controllerPath;
                $this->controller = "App\Controller\\{$controller}Controller";
            }
        }
        return require_once $this->controllerPath;
    }

    /**
     * Used to set method.
     * @param string $method
     * @return void
     */
    private function __setMethod(string $method): void
    {
        if (method_exists($this->controller, $method)) {
            $this->method = $method;
        }
    }
}
