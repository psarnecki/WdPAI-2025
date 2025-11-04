<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';

// TODO musimy zapewnic ze utworzony obiekt ma tylko jedna isntancje - wzorzec singleton
// TODO 2 /dashboard -- wszystkie dane
// /dashboard/12343 -- dane konkretnego uzytkownika REGEX
class Routing {

    public static $routes = [
        "login" => [
            "controller" => "SecurityController",
            "action" => "login"
        ],
        "register" => [
            "controller" => "SecurityController",
            "action" => "register"
        ],
        "dashboard" => [
            "controller" => "DashboardController",
            "action" => "index"
        ]
    ];

    public static function run($path) {
        switch($path) {
            case 'dashboard':
            case 'login':
            case 'register':
                $controller = Routing::$routes[$path]['controller'];
                $action = Routing::$routes[$path]['action'];

                $controllerObj = new $controller;
                $id = null;

                $controllerObj->$action($id);
                break;
            default:
                include 'public/views/404.html';
                break;
        }
    }
}