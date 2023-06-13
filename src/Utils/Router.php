<?php 


namespace Shappy\Utils;

class Router {
    private $routes = [];

    public function route($path, $method, $callback, $csrfProtected = false) {
        $this->routes[$path][$method] = [
            'callback' => $callback,
            'csrfProtected' => $csrfProtected
        ];
    }

    public function handleRequest($path, $method, $token = null) {

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if($path != "/" && $path[strlen($path)-1] == '/') {
            $path = substr($path, 0, -1);
        }


        if (array_key_exists($path, $this->routes) && array_key_exists($method, $this->routes[$path])) {
            $route = $this->routes[$path][$method];
            $callback = $route['callback'];
            
            if ($route['csrfProtected']) {
                if (!$this->verifyCSRFToken($token)) {
                    echo "CSRF Token verification failed!";
                    return;
                }
            }

            if (is_callable($callback)) {
                $callback();
            } else {
                echo "Invalid callback for route '$path' and method '$method'";
            }
        } else {
            error_404();
        }
    }

    private function verifyCSRFToken($token) {
        if (isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token']) {
            return true;
        }
        return false;
    }
}