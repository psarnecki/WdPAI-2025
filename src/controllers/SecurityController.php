<?php

require_once 'AppController.php';

class SecurityController extends AppController {

    public function login() {
        return $this->render('login', ["message" => "Błędne dane logowania!"]);
    }

        public function register() {
        return $this->render('register', ["message" => "Rejestracja nie powiodła się!"]);
    }
}