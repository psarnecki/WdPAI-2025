<?php

require_once 'AppController.php';

class SecurityController extends AppController {

    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function login() {
        //var_dump('GET', $_GET);
        //var_dump('POST', $_POST);

        if(!$this->isPost()) {
            return $this->render("login");
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userRepository->getUserByEmail($email);

        //return $this->render('login', ["messages" => "Błędne dane logowania!"]);
        //return $this->render('dashboard', ["cards" => []]);

        if(!$user) {
            return $this->render("login", ['messages'=> 'User not exists!']);
        }

        if(!password_verify($password, $user['password'])) {
            return $this->render("login", ['messages'=> 'Wrong password!']);
        }

        // TODO create user session, cookie, token

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
    }

    public function register() {
        if($this->isGet()) {
            return $this->render("register");
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $password2 = $_POST['password_confirm'] ?? '';
        $firstname = $_POST['firstName'] ?? '';
        $lastname = $_POST['lastName'] ?? '';

        if (empty($email) || empty($password) || empty($firstname) || empty($lastname)) {
            return $this->render('register', ['messages' => 'Fill all fields']);
        }

        if ($password !== $password2) {
             return $this->render("register", ["messages" => "Passwords should be the same!"]);
        }

        if($this->userRepository->getUserByEmail($email)) {
             return $this->render("register", ["messages" => "User with this email already exists!"]);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $this->userRepository->createUser(
            $email,
            $hashedPassword,
            $firstname,
            $lastname
        );
        return $this->render("login", ["messages" => "User registered successfully. Please login!"]);
    }
}