<?php
/**
|--------------------------------------------------------------------------
| Main app
|--------------------------------------------------------------------------
| The main App class which kickstarts everything being instantiated in
| index.php with every new request.
 */
class App
{
    private $controller = DEFAULT_CONTROLLER;
    private $method = DEFAULT_METHOD;
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
     * Set the controller.
     * @param string|null $controller
     * @return void
     */
    private function __setController(?string $controller = null): void
    {
        if ($controller !== null) {
            $controller = ucfirst($controller);
            $controllerPath = CONTROLLERS . DIRECTORY_SEPARATOR . "{$controller}Controller.php";
            if (file_exists($controllerPath)) {
                $this->controller = CONTROLLERS_NAMESPACE . "{$controller}Controller";
            }
        }
    }

    /**
     * Set the controller action.
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
