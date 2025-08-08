<?php

namespace Core;

class View {
    public static function male($view, $data = []) {
        $viewPath = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new \Exception('View not found: ' . $viewPath);
        }
        // Передаём переменные внутрь шаблона
        extract($data);

        require $viewPath;
    }

    public static function render($template, $data = []) {
        extract($data); // превращает ['title' => 'О нас'] в $title = 'О нас'
        include "../views/layout/header.php";
        include "../views/$template.php";
        include "../views/layout/footer.php";
    }
}