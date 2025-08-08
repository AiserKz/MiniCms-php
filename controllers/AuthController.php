<?php 

use Core\View;
use Core\DB;
use Core\Validator;

class AuthController {
    public function index() {
        View::render('login', ['title' => 'Авторизация', 'error' => '']);
    }

    public function logout() {
        session_start();
        session_unset();  // Удаляет все переменные сессии
        session_destroy(); // Уничтожает саму сессию
        redirect('/login');
    }

    public function register() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_confrim = $_POST['password_confirm'];
        $validate = Validator::make($_POST, [
            'name' => 'required|min:3|max:255',
            'email' => 'required',
            'password' => 'required|min:4|max:255'
        ]);

        if ($validate->fails()) {
            View::render('login', ['title' => 'Авторизация', 'errors' => $validate->errors()]);
            return;
        }

        $password = password_hash($password, PASSWORD_BCRYPT);
        
        $pdo = DB::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute(['name' => $name]);

        if ($stmt->fetch()) {
            View::render('login', ['title' => 'Авторизация', 'error' => 'Пользователь с таким именем уже существует']);
            return;
        }
        
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_level'] = 1;
        redirect('/');

      
    }

    public function login() {
        session_destroy();
        session_start();
        session_regenerate_id(true);
        $pdo = DB::getConnection();
        $name = $_POST['name'];
        $password = $_POST['password'];

        $validate = Validator::make($_POST, [
            'name' => 'required|min:3|max:255',
            'password' => 'required|min:4|max:255'
        ]);

        if ($validate->fails()) {
            View::render('login', ['title' => 'Авторизация', 'errors' => $validate->errors()]);
            return;
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name");
        $stmt->execute(['name' => $name]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_level'] = $user['level'];
            
            redirect('/');
            exit;
        } else {
            View::render('login', ['title' => 'Авторизация', 'error' => 'Неверный логин или пароль']);
            exit;
        }
    }
}