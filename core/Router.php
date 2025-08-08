<?php 

namespace Core;

class Router {
    private $routes = [];

    public function get($uri, $action, $options = []) {
        $this->routes['GET'][$uri] = [
            'action' => $action,
            'middleware' => $options['middleware'] ?? null
        ];
    }

    public function post($uri, $action, $options = []) {
        $this->routes['POST'][$uri] = [
            'action' => $action,
            'middleware' => $options['middleware'] ?? null
        ];
    }

    public function dispatch($uri) {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {
            if (!verify_csrf_token($_POST['csrf_token'] ?? '') ) {
                flash_modal('Неправильный токен CSRF', 'error', 419);
            }   
        }
        if (!isset($this->routes[$method])) {
            flash_modal('Метод ' . $method . ' не разрешён', 'error', 422);
        }

        foreach ($this->routes[$method] as $route => $info) {
            $action = $info['action'];
            $middleware = $info['middleware'];

            // Превращаем /post/{id} → регулярку: /post/(\w+)
            $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9-_]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) { // используется для поиска совпадений с регулярным выражением в строке. Она возвращает логическое значение: 1, если совпадение найдено, 0, если совпадение не найдено, или false, если произошла ошибка. 
                array_shift($matches); // удаляем первый элемент массива, т.к. он всегда пустой
                list($controllerName, $methodName) = explode('@', $action);

                // 🛡️ Выполняем middleware перед контроллером
                if ($middleware) {
                    foreach ((array) $middleware as $mw) {
                        $mwClass = 'Middleware\\' . ucfirst($mw) . 'Middleware';

                        if (class_exists($mwClass)) {
                            $mwClass::handle();
                        } else {
                            echo "⚠️ Middleware класс '$mwClass' не найден!";
                            exit;
                        }


                    }
                }
                try {
                    require_once "../controllers/{$controllerName}.php";
                } catch (\Throwable $th) {
                    flash_modal('Ошибка загрузки контроллера', 'error', 500);
                }
                $controller = new $controllerName();
                return call_user_func_array([$controller, $methodName], $matches); // Вызываем указанный метод контроллера
            }
        }

        flash_modal('Такой страницы не существует...', 'error', 404);
        // http_response_code(404);
        // echo '404 Not Found';

        // $action = $this->routes[$method][$uri] ?? null;
      
        // if (!$action) {
        //     http_response_code(404);
        //     echo '404 Not Found';
        //     return;
        // }
        // // Разделяем строку типа 'HomeController@index' на две части:
        // // $controllerName = 'HomeController', $methodName = 'index'
        // list($controllerName, $methodName) = explode('@', $action);

        // // Подключаем файл контроллера по имени.
        // // Важно: используем двойные кавычки и фигурные скобки!
        // require_once "../controllers/{$controllerName}.php";

        // // Создаём объект этого контроллера
        // $controller = new $controllerName();

        // // Вызываем указанный метод контроллера
        // $controller->$methodName();
    }
}