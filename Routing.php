<?php

require_once 'src/controllers/SecurityController.php';

class Routing {

    public static $routes = [
        "login" => [
            "controller" => "SecurityController",
            "action" => "login"
        ],
        "register" => [
            "controller" => "SecurityController",
            "action" => "register"
        ]
    ];

    public static function run($path) {
        switch($path) {
            case 'dashboard':
                include 'public/views/dashboard.html';
                break;
            case 'login':
            case 'register':
                $controller = Routing::$routes[$path]['controller'];
                $action = Routing::$routes[$path]['action'];

                $controllerObj = new $controller;
                $controllerObj->$action();
                break;
            default:
                include 'public/views/404.html';
                break;
        }
    }
}