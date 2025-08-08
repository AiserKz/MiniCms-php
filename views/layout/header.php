<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | MiniCms</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" href="<?= asset('images/favicon.png') ?>" type="image/png">
    <style>
        /* Для плавного появления/скрытия мобильного меню */
        .mobile-menu { transition: max-height 0.3s ease; overflow: hidden; }
        .mobile-menu.closed { max-height: 0; }
        .mobile-menu.open { max-height: 500px; }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
<header>
    <nav class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 px-4 sm:px-8 py-4 flex items-center justify-between shadow-lg rounded-b-xl relative">
        <div class="flex items-center space-x-4 sm:space-x-8">
            <a href="<?= url('/') ?>" class="text-teal-300 font-bold text-xl hover:text-teal-400 transition">Главная</a>
            <a href="<?= url('/about') ?>" class="text-gray-200 text-lg hover:text-teal-400 transition hidden sm:inline">О проекте</a>
            <?php if (user_level() > 1): ?>
                <a href="<?= url('/dasboard') ?>" class="text-gray-200 text-lg hover:text-teal-400 transition hidden sm:inline">Админка</a>
            <?php endif; ?>
        </div>
        <!-- Бургер-меню для мобилки -->
        <button id="burger" class="sm:hidden flex flex-col justify-center items-center w-10 h-10 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" aria-label="Открыть меню">
            <span class="block w-7 h-1 bg-teal-400 mb-1 rounded"></span>
            <span class="block w-7 h-1 bg-teal-400 mb-1 rounded"></span>
            <span class="block w-7 h-1 bg-teal-400 rounded"></span>
        </button>
        <!-- Десктоп меню -->
        <div class="hidden sm:flex items-center space-x-4">
            <?php if (auth()): ?>
                <a href="<?= url('/new-post') ?>" class="bg-teal-700 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Создать пост</a>
                <div class="flex items-center space-x-2 px-3 py-1 rounded-lg">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode(user_name()) ?>&background=1e293b&color=14b8a6&size=40" alt="Аватар" class="w-8 h-8 rounded-full border-2 border-teal-400 shadow">
                    <span class="font-semibold"><?= htmlspecialchars(user_name()) ?></span>
                </div>
                <a href="<?= url('/logout') ?>" class="text-red-400 hover:text-red-300 font-semibold transition">Выйти</a>
            <?php else: ?>
                <a href="<?= url('/login') ?>" class="bg-teal-700 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Войти</a>
            <?php endif; ?>
        </div>
        <!-- Мобильное меню -->
        <div id="mobileMenu" class="mobile-menu closed absolute top-full left-0 w-full bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 sm:hidden z-50 rounded-b-xl">
            <div class="flex flex-col py-2 px-4 space-y-2">
                <a href="<?= url('/') ?>" class="text-teal-300 font-bold text-lg hover:text-teal-400 transition">Главная</a>
                <a href="<?= url('/about') ?>" class="text-gray-200 text-lg hover:text-teal-400 transition">О проекте</a>
                <?php if (user_level() > 1): ?>
                    <a href="<?= url('/dasboard') ?>" class="text-gray-200 text-lg hover:text-teal-400 transition">Админка</a>
                <?php endif; ?>
                <hr class="border-gray-700">
                <?php if (auth()): ?>
                    <a href="<?= url('/new-post') ?>" class="bg-teal-700 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Создать пост</a>
                    <div class="flex items-center space-x-2 px-3 py-1 rounded-lg">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode(user_name()) ?>&background=1e293b&color=14b8a6&size=40" alt="Аватар" class="w-8 h-8 rounded-full border-2 border-teal-400 shadow">
                        <span class="font-semibold"><?= htmlspecialchars(user_name()) ?></span>
                    </div>
                    <a href="<?= url('/logout') ?>" class="text-red-400 hover:text-red-300 font-semibold transition">Выйти</a>
                <?php else: ?>
                    <a href="<?= url('/login') ?>" class="bg-teal-700 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Войти</a>
                <?php endif; ?>
            </div>
        </div>
        <script>
            // Открытие/закрытие мобильного меню
            document.addEventListener('DOMContentLoaded', function() {
                const burger = document.getElementById('burger');
                const mobileMenu = document.getElementById('mobileMenu');
                burger.addEventListener('click', function() {
                    if (mobileMenu.classList.contains('closed')) {
                        mobileMenu.classList.remove('closed');
                        mobileMenu.classList.add('open');
                    } else {
                        mobileMenu.classList.remove('open');
                        mobileMenu.classList.add('closed');
                    }
                });
                // Закрытие меню при клике вне меню
                document.addEventListener('click', function(e) {
                    if (!burger.contains(e.target) && !mobileMenu.contains(e.target)) {
                        mobileMenu.classList.remove('open');
                        mobileMenu.classList.add('closed');
                    }
                });
            });
        </script>
    </nav>
</header>

<main class="flex-1 px-2 sm:px-12">
