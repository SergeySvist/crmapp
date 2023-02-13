<?php

namespace Core\Routing;

use App\Models\User;
use Core\CookieManager;
use Exception;

class Router
{
    /**
     * @var Route[]
     */
    private static array $routes;

    /**
     * @throws Exception
     */
    public static function __callStatic(string $name, array $args)
    {
        $method = match ($name)
        {
            'get' => HttpMethod::GET,
            'post' => HttpMethod::POST,
            'put' => HttpMethod::PUT,
            'delete' => HttpMethod::DELETE,
            default => null,
        };

        if ($method) {
            $route = new Route($method, $args[0], $args[1], $args[2]);  // TODO: validate args...
            self::$routes[] = $route;

            return $route;
        }

        throw new Exception('Invalid route');
    }
    private function getUri(): string
    {
        if (! empty($_SERVER['REQUEST_URI']))
        {
            $uri = $_SERVER['REQUEST_URI'];
            return trim($uri, '/');
        }

        return '';
    }

    private function executeAction(Route $route)
    {
        $controllerName = $route->getControllerClass();

        if (class_exists($controllerName)) {
            call_user_func_array([new $controllerName, $route->getActionMethod()], $route->getArgs());
        }
    }

    public function run()
    {
        $uri = $this->getUri();

        if (! $uri)
            header('Location: ' . HOME_URL);

        $method = $_SERVER['REQUEST_METHOD'];

        $args = [];

        foreach (self::$routes as $route) {
            if ($route->getHttpMethod()->value === $method && preg_match("~{$route->getPattern()}~", $uri, $args)) {
                array_shift($args);

                $route->setArgs($args);

                if ($route->isWithAuth()) {
                    //browser
                    if (CookieManager::checkAuth()) {
                        $this->executeAction($route);
                        return;
                    }
                    //api
                    if(User::checkExists(["token" => $_SERVER['HTTP_USER_TOKEN_KEY']])){
                        file_put_contents('test.txt', 1);
                        $this->executeAction($route);
                        return;
                    }
                } else {
                    $this->executeAction($route);
                    return;
                }

                header('Location: /login');
            }
        }

        // 404
        require_once ROOT . '/app/views/static/404View.php';
    }
}
