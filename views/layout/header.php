<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | MiniCms</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" href=" <?= asset('images/favcon.png') ?>" type="image/png">

</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex flex-col">
<header>
    <nav class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 px-8 py-4 flex items-center justify-between shadow-lg rounded-b-xl">
        <div class="flex items-center space-x-8">
            <a href="<?= url('/') ?>" class="text-teal-300 font-bold text-xl hover:text-teal-400 transition">Главная</a>
            <a href="<?= url('/about') ?>" class="text-gray-200 text-lg hover:text-teal-400 transition">О проекте</a>
            <!-- <a href="#" class="text-gray-200 text-lg hover:text-teal-400 transition">Блог</a> -->
            <?php if (user_level() > 1): ?>
                <a href="<?= url('/dasboard') ?>" class="text-gray-200 text-lg hover:text-teal-400 transition">Админка</a>
            <?php endif; ?>

        </div>
        <?php if (auth()): ?>
            <!-- Тут HTML для авторизованного пользователя -->
            <div class="flex items-center space-x-4">
                <a href="<?= url('/new-post') ?>" class="bg-teal-700 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Создать пост</a>
                <div class="flex items-center space-x-2 px-3 py-1 rounded-lg">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode(user_name()) ?>&background=1e293b&color=14b8a6&size=40" alt="Аватар" class="w-8 h-8 rounded-full border-2 border-teal-400 shadow">
                    <span class="font-semibold"><?= htmlspecialchars(user_name()) ?></span>
                </div>
                <a href="<?= url('/logout') ?>" class="text-red-400 hover:text-red-300 font-semibold transition">Выйти</a>
            </div>

        <?php else: ?>
            <div class="flex items-center space-x-4">
                <a href="<?= url('/login') ?>" class="bg-teal-700 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Войти</a>
         </div>
        <?php endif; ?>
    </nav>
</header>

<main class="flex-1 px-12">
