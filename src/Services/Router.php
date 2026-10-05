<?php

namespace App\Services;

class Router{
    private array $routes = [];

    // Метод для регистрации GET-маршрута
    public function get(string $uri, callable $action): void{
        $this->routes['GET'][$this->trimUri($uri)] = $action;
    }

    // Метод для регистрации POST-маршрута
    public function post(string $uri, callable $action): void{
        $this->routes['POST'][$this->trimUri($uri)] = $action;
    }

    // Метод для запуска обработки текущего URL
    public function dispatch(): void 
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Получаем имя папки скрипта, если проект лежит в подпапке
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && $scriptName !== '\\') {
            $uri = substr($uri, strlen($scriptName));
        }
    
        $uri = '/' . trim($uri, '/');
    
        if (isset($this->routes[$method][$uri])) {
            call_user_func($this->routes[$method][$uri]);
        } else {
            http_response_code(404);
            echo "404 | Страница не найдена: " . htmlspecialchars($uri);
        }
    }

    private function trimUri(string $uri): string{
        return '/' . trim($uri, '/');
    }
}