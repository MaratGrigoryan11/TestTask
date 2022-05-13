<?php


use Models\Interfaces\PostController;

class Router
{
    private array $routes;

    public function __construct()
    {

        $this->routes = [
            '/posts/{key}::DELETE' => [
                'controller' => PostController::class,
                'action' => 'delete'
            ],
            '/posts::POST' => [
                'controller' => PostController::class,
                'action' => 'store'
            ],
            '/posts::GET' => [
                'method' => 'GET',
                'controller' => PostController::class,
                'action' => 'getAction'
            ],
            '/::GET' => [
                'method' => 'GET',
                'controller' => HomeController::class,
                'action' => 'index'
            ],
        ];
    }

    /**
     * @throws Exception
     */
    public function __invoke()
    {
        $method = $_POST['method'] ?? $_SERVER['REQUEST_METHOD'];
        $params = [];

        $requestUri = $_SERVER['REQUEST_URI'];

        $routeArray = explode('/', $requestUri);

        $matchedRoutes = array_filter($this->routes, function ($key) use ($routeArray, $method) {
            return count(explode('/', $key)) === count($routeArray)
                && $method === explode('::', $key)[1];
        }, ARRAY_FILTER_USE_KEY);

        if (!count($matchedRoutes)) {
            throw new Exception('not found');
        }

        $matchedRoutes = array_filter($matchedRoutes, function ($key) use ($routeArray, &$params) {
            $keyString = explode('::', $key)[0];
            $keyArray = explode('/', $keyString);

            for ($i = 0; $i < count($routeArray); $i++) {
                $routePart = $keyArray[$i];

                if (preg_match('/{(.*)+}/', $routePart, $output_array)) {
                    $varName = str_replace('{', '', $routePart);
                    $varName = str_replace('}', '', $varName);

                    $params[$varName] = $routeArray[$i];
                    continue;
                }

                if ($routeArray[$i] !== $routePart) {
                    return false;
                }
            }

            return true;
        }, ARRAY_FILTER_USE_KEY);

        if (!count($matchedRoutes)) {
            throw new Exception('not found');
        }

        $route = $matchedRoutes[array_key_first($matchedRoutes)];

        $class = new $route['controller']();

        return $class->{$route['action']}($params);
    }
}