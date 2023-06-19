<?php

namespace Shappy\Http;

use ReflectionClass;

class Router
{
    protected $routes = [];

    public function addRoute($method, $path, $handler)
    {
        $home_url = HOME_URL == '/' ? "" : HOME_URL;
        $path = $path == '/' && HOME_URL != '/' ? '' : $path;
        // dd($path);
        $this->routes[$method][$home_url.$path] = $handler;
    }

    public function handleRequest(Request $request)
    {
        $method = $request->method();
        $path = parse_url($request->getPathInfo(), PHP_URL_PATH);
        // remove extra '/' in path if there is one
        $path = ($path != '/' && $path[-1] == '/') ? substr($path, 0, -1) : $path;

        $handler = $this->findRouteHandler($method, $path);
        if ($handler === null) {
            echo "ERROR 404 - PAGE NOT FOUND";
            exit;
        }

        return $this->executeHandler($handler, $request);
    }

    protected function findRouteHandler($method, $path)
    {
        return $this->routes[$method][$path] ?? null;
    }

    protected function executeHandler($handler, Request $request)
    {
        if (is_callable($handler)) {
            return call_user_func($handler, $request);
        } elseif (is_string($handler)) {
            list($controller, $method) = explode('@', $handler);

            $namespace = '\Shappy\Controllers';

            // Create the fully qualified class name
            $className = $namespace . '\\' . $controller;

            // Instantiate the class using ReflectionClass
            $controllerInstance = (new ReflectionClass($className))->newInstance();

            if (method_exists($controllerInstance, $method)) {
                return $controllerInstance->$method($request);
            }
        }

        // Handle invalid handler, return an appropriate response

        echo "Invalid handler";
        exit;
    }
}
