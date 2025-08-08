<?php

function init() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    } 
    initBot();
    return initRoute();
}

function initRoute() {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if (preg_match('/\.(png|jpg|jpeg|gif|css|js|ico)$/i', $uri)) {
        return;
    } else if (str_starts_with($uri, '/.well-known/')) {
        return null;
    }


    log_message("Полученный путь: $uri");
    $basePath = env('APP_URL');
    if (str_starts_with($uri, $basePath)) {
        $uri = substr($uri, strlen($basePath)); // Удаляем базовый путь 1 аргумент - строка, 2 аргумент - количество удаленных символов
    }
    return rtrim($uri, '/') ?: '/'; 
}

function initBot() {
    $webhookUrl = env('TELEGRAM_BOT_WEBHOOK_URL') . env('APP_URL') . '/bot-webhook.php';

    if (cache_get('last_webhook') === $webhookUrl) { 
        return;
    }

    try {
        $telegram = new \Telegram\Bot\Api(env('TELEGRAM_BOT_TOKEN'));
        $telegram->setWebhook(['url' => $webhookUrl]);
        log_message("Webhook установлен: $webhookUrl");
        cache_set('last_webhook', $webhookUrl);
    } catch (\Throwable $e) {
        log_message("Ошибка установки webhook: " . $e->getMessage());
    }
}



function log_message(string $message, $type = 'info'): void {
    if (env('APP_DEBUG') === false) {
        return;
    }
    if ($type === 'error') {
        $path = '../logs/' . env('APP_LOG_ERROR_PATH', __DIR__ . '../logs/error_log.log');
    } else {
        $path = '../logs/' . env('APP_LOG_PATH', __DIR__ . '../logs/logs.log');
    }
    $dir = dirname($path);

    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    $fullMessage = "[" . date('Y-m-d H:i:s') . "] " . $message . PHP_EOL;
    file_put_contents($path, $fullMessage, FILE_APPEND);
}

function view(string $template, array $data = []): void {
    $templatePath = __DIR__ . '/../views/' . $template . '.php';

    if (!file_exists($templatePath)) {
        die("Шаблон $template  не найден: $templatePath");
    }

    extract($data); 
    require $templatePath;
}

function url(string $path = ''): string {
    $base = env('APP_URL');
    return rtrim($base, '/') . '/' . ltrim($path, '/');
}

function asset(string $path): string {
    $fullpath = __DIR__ . '/../public/uploads/' . ltrim($path, '/');
    $url = url('uploads/' . ltrim($path, '/'));

    if (file_exists($fullpath)) {
        $url .= '?v=' . filemtime($fullpath);
    }
    return trim($url);
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
    http_response_code($code); 

    $view = new \Core\View();
    
  
    echo $view->render('flashmodal', [
        'title' => 'Ошибка',
        'message' => $message,
        'type' => $type,
        'errors' => $errors
    ]);

    exit;
}

function flash_toast($message, $type = 'success') {
    $_SESSION['toast'] = ['message' => $message, 'type' => $type];
}

function checkOrFail($post) {
    if (empty($post)) {
        flash_modal('Пост не найден', 'error', 404);
    }
}


if (!function_exists('cache_path')) {
    function cache_path(): string {
        $path = __DIR__ . '/../cache/';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }
}

if (!function_exists('cache_set')) {
    function cache_set(string $key, string $value): void {
        $file = cache_path() . '/' . $key . '.cache';
        file_put_contents($file, $value);
    }
}

if (!function_exists('cache_get')) {
    function cache_get(string $key, $default = null): mixed {
        $file = cache_path() . '/' . $key . '.cache';
        if (file_exists($file)) {
            return trim(file_get_contents($file));
        }
        return $default;
    }
}

if (!function_exists('cache_has')) {
    function cache_has(string $key): bool {
        return file_exists(cache_path() . '/' . $key . '.cache');
    }
}

if (!function_exists('cache_delete')) {
    function cache_delete(string $key): void {
        $file = cache_path() . '/' . $key . '.cache';
        if (file_exists($file)) {
            unlink($file);
        }
    }
}