<?php

namespace Core;

class Router
{
    protected $routes = [];

    protected $params = [];

    protected $requestMethod = [];

    protected $namespace = 'App\Controllers\\';

    public function add($route , $param, $requestMethod)
    {
        list($params['controller'] , $params['method']) = explode('@' , $param);
        $this->routes[$route][$requestMethod] = $params;
    }

    public function match($url, $requestMethod)
    {
        $url = explode('?' , $url)[0];
        foreach ($this->routes as $route => $params) {
            if($route == $url && isset($params[$requestMethod])) {
                $this->params = $params[$requestMethod];
                return true;
            }
        }
        return false;
    }

    public function dispatch($url)
    {
        $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

        if($this->match($url, $requestMethod)) {
            $controller = $this->params['controller'];
            $controller = $this->getNameSpace() . $controller;
            if(class_exists($controller)) {
                $controller_object = new $controller();
                $method = $this->params["method"];
                if(is_callable([$controller_object , $method])) {
                    // echo $controller_object->$method();
                    call_user_func_array([$controller_object, $method], array());
                } else {
                    die("Method {$method} (in controller {$controller}) not found");
                }
            } else {
                die("Controller class {$controller} not found");
            }
        } else {
            die("No route matched.");
        }
    }

    public function getNameSpace()
    {
        return $this->namespace;
    }

    // public function getRoutes()
    // {
    //     return $this->routes;
    // }

    // public function getParams()
    // {
    //     return $this->params;
    // }
}