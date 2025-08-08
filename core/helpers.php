<?php

function init() {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    } 

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $basePath = env('APP_URL');
    if (str_starts_with($uri, $basePath)) { // Проверка на наличие базового пути 1 аргумент - строка, 2 аргумент - начало строки
        $uri = substr($uri, strlen($basePath));// Удаляем базовый путь 1 аргумент - строка, 2 аргумент - количество удаленных символов
    }

    return rtrim($uri, '/') ?: '/'; // Если в конце строки есть слеш, то удаляем его
}

function view(string $template, array $data = []): void {
    $templatePath = __DIR__ . '/../views/' . $template . '.php';

    if (!file_exists($templatePath)) {
        die("Шаблон $template  не найден: $templatePath");
    }

    extract($data); // превращает ['title' => 'О нас'] в $title = 'О нас'
    require $templatePath;
}

function url(string $path = ''): string {
    $base = env('APP_URL');
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function redirect(string $path): void {
    header('Location: ' . url($path));
    exit;
}

if (!function_exists('dd')) {
    function dd(...$vars) {
        echo '<div style="font-family:monospace;background:#1e1e1e;color:#dcdcdc;padding:16px;border-radius:10px;height:100%;">';
        echo '<h3 style="color:#569cd6;margin-bottom:10px;">🐞 Debug Dump:</h3>';
        foreach ($vars as $key => $value) {
            echo "<div style='margin-bottom:12px;'><span style='color:#9cdcfe;'>\${$key}</span>:</div>";
            echo '<pre style="background:#2d2d2d;padding:10px;border-radius:6px;">';
            print_r($value);
            echo '</pre>';
        }
        echo '</div>';
        die();
    }
}

if (!function_exists('dump')) {
    function dump(...$vars) {
        foreach ($vars as $var) {
            echo '<pre style="background:#222;color:#aaffaa;padding:10px;border-radius:8px;">';
            var_dump($var);
            echo '</pre>';
        }
    }
}

function auth() {
    return isset($_SESSION['user_id']);
}

function user_id() {
    return $_SESSION['user_id'] ?? null;
}

function user_name() {
    return $_SESSION['user_name'] ?? "Гость";
}

function user_level() {
    return $_SESSION['user_level'] ?? 1;
}

function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    // Обязательно экранируем кавычки и закрываем строку правильно
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES) . '">';
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}


function is_floading($action_key, $seconds = 10) {
    $last = $_SESSION['last_' . $action_key] ?? 0;
    if (time() - $last < $seconds) {
        return true;
    }
    $_SESSION['last_' . $action_key] = time();
    return false;
}


function flash_modal($message, $errors = [], $type = 'error', $code = 500) {
    http_response_code($code); // Устанавливаем нужный HTTP-код

    $view = new \Core\View();
    
    // Отрисовываем шаблон, передаём в него данные
    echo $view->render('flashmodal', [
        'title' => 'Ошибка',
        'message' => $message,
        'type' => $type,
        'errors' => $errors
    ]);

    exit; // Завершаем выполнение скрипта
}

function flash_toast($message, $type = 'success') {
    $_SESSION['toast'] = ['message' => $message, 'type' => $type];
}

function checkOrFail($post) {
    if (empty($post)) {
        flash_modal('Пост не найден', 'error', 404);
    }
}

// function env($key, $default = null) {
//     static $env = null;

//     if ($env === null) {
//         $env = [];
//         $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//         foreach ($lines as $line) {
//             if (str_starts_with(trim($line), '#')) continue;
//             list($name, $value) = explode('=', $line, 2);
//             $env[trim($name)] = trim($value);
//         }
//     }

//     return $env[$key] ?? $default;
// }