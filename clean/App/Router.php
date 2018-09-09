<?php
/**
 * @author d.ivaschenko
 */

namespace App;

class Router
{
    private $controller;
    private $action;

    public function __construct()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
        $uri = trim($uriParts[0], '/');

        $routes = include __DIR__ . '/../config/routes.php';

        if (empty($route = $routes["$method@$uri"])) {
            http_response_code(404);
            die();
        }

        [$this->controller, $this->action] = explode('@', $route);
        $this->controller = "\App\Controllers\\$this->controller";
        $this->controller = new $this->controller();
    }


    public function process(): void
    {
        try {
            $result = $this->controller->{$this->action}();
            if (!empty($result['headers'])) {
                foreach ($result['headers'] as $headerName => $info) {
                    header("{$headerName}: {$info[0]}", $info[1]);
                }
            }

            if (!empty($result['message'])) {
                echo($result['message']);
            }
        } catch (\Exception $e) {
            http_response_code($e->getCode());
        }

    }

}