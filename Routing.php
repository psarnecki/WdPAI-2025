<?php

require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';

class Routing {

    private static ?Routing $instance = null;

    private function __construct() {}

    public static function getInstance(): Routing {
        if (self::$instance === null) {
            self::$instance = new Routing();
        }
        return self::$instance;
    }

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
        ],
        "search-cards" => [
            "controller" => "DashboardController",
            "action" => "search"
        ]
    ];

    public function run($path) {

        if (preg_match('/^dashboard\/(\d+)$/', $path, $matches)) {
            $controller = Routing::$routes["dashboard"]["controller"];
            $action = Routing::$routes["dashboard"]["action"];

            $controllerObj = new $controller;
            $controllerObj->$action((int)$matches[1]);
            return;
        }

        switch($path) {
            case 'dashboard':
            case 'login':
            case 'register':
            case 'search-cards':
                $controller = Routing::$routes[$path]['controller'];
                $action = Routing::$routes[$path]['action'];

                $controllerObj = new $controller;
                $controllerObj->$action(null);
                break;
            default:
                include 'public/views/404.html';
                break;
        }
    }
}