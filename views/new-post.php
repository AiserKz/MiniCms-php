<div class="flex flex-col items-center justify-center py-16 px-4">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl max-w-xl w-full">
        <a href="<?= url('/') ?>" class="text-teal-400 hover:text-teal-200 transition font-semibold">← Назад</a>
        <h1 class="text-3xl font-extrabold text-teal-300 mb-6 text-center drop-shadow-lg">Создать новый пост</h1>
        <form action="<?= url('/new-post') ?>" method="post" class="space-y-6 grid justify-items-stretch">
            <?= generate_csrf_token() ?>
            <label for="title_post" class="text-gray-400">Заголовок поста</label>
            <input 
                type="text" 
                name="title_post" 
                placeholder="Заголовок поста" 
                class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" 
                required
                value="<?= htmlspecialchars($data['title_post'] ?? '') ?>"
            >
            <label for="content" class="text-gray-400">Текст поста</label>
            <textarea 
                name="content" 
                placeholder="Текст поста..." 
                class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" 
                rows="8" 
                required
            ><?= htmlspecialchars($data['content'] ?? '') ?></textarea>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger mb-4">
                    <ul>
                        <?php foreach ($errors as $fieldErrors): ?>
                            <?php foreach ($fieldErrors as $error): ?>
                                <li class="text-red-500"><?= htmlspecialchars($error) ?></li>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
            <button 
                type="submit" 
                class="w-full bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition"
            >
                Опубликовать
            </button>
        </form>
    </div>
</div>
