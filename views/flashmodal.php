
<div class="flex flex-col items-center justify-center min-h-[60vh] py-16 px-4">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl max-w-lg w-full text-center">
        <h1 class="text-6xl font-extrabold text-red-500 mb-4 drop-shadow-lg">
            <?= $code ?? 'Ошибка' ?>
        </h1>
        <!-- <h2 class="text-2xl font-bold text-teal-300 mb-6">
            <?= $title ?? 'Что-то пошло не так...' ?>
        </h2> -->
        <p class="text-gray-300 text-lg mb-8">
            <?= $message ?? 'Извините, произошла ошибка. Попробуйте обновить страницу или вернуться на главную.' ?>
        </p>

        <a href="<?= url('/') ?>" class="bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">На главную</a>
    </div>
</div>

