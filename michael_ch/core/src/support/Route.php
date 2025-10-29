<?php
/*
| ======================================================================================================
| Name          : Route
| Description   : To create web route
| Requirements  : None
|
| Created by    : Michael Christopher Otniel Wijanto
| Creation Date : 2025-06-02
| Version       : 1.0.0
|
| Modifications:
|       - v1.0.1 - [Modifier Name 1] on [Modification Date 1]: [Brief description of the modification]
| ======================================================================================================
*/
namespace support;

use Path\RoutePath;

class Route
{
    private static array $routes = [];
    public static function Add(string $method, string $path, string $controller, string $function, array $middlewares = []) : void
    {
        self::$routes[] = [
            'method' => $method,
            'Path' => $path,
            'controller' => $controller,
            'function' => $function,
            'middleware' => $middlewares
        ];
    }

    public static function Run() : void
    {
        $path = "/";
//        if (isset($_SERVER['PATH_INFO'])) {
//            $path = $_SERVER['PATH_INFO'];
//        }
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $path = rtrim($uri, "/");
            $path = $path === "" ? "/" : $path;
        }

        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes as $route) {
            $pattern = "#^" . $route['Path'] . "$#";
            if (preg_match($pattern, $path, $variables) && $method == $route['method']) {

                foreach ($route["middleware"] as $middleware) {
                    $instance = new $middleware;
                    $instance->before();
                }

                $controller = new $route['controller'];
                $function = $route['function'];

                array_shift($variables);
                call_user_func_array([$controller, $function], $variables);

                return;
            }
        }
        redirect(RoutePath::EXCEPTION_PAGE_NOT_FOUND);
    }
}