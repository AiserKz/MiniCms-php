<div class="flex flex-col items-center justify-center min-h-[60vh] py-12 px-4">
    <form action="<?= url('/post/update/' . $post['id']) ?>" method="post" class="bg-gray-800 p-8 rounded-2xl shadow-2xl max-w-2xl w-full">
        <?= generate_csrf_token() ?>
        <h1 class="text-3xl font-extrabold text-teal-300 mb-6 text-center drop-shadow-lg">Редактировать пост</h1>
        <label for="title" class="block text-gray-400 text-sm mb-2">Заголовок поста</label>
        <input 
        type="text" 
        name="title" 
        value="<?= htmlspecialchars($post['title']) ?>" 
        placeholder="Заголовок поста" 
        class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500 mb-4" 
        required
        >
        <label for="content" class="block text-gray-400 text-sm mb-2">Текст поста</label>
        <textarea 
        name="content" 
        placeholder="Текст поста..." 
        class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500 mb-6" 
        rows="8" 
        required
        ><?= htmlspecialchars($post['content']) ?></textarea>
        <span>Автор: <span class="text-teal-400 font-semibold"><?= htmlspecialchars($post['author_name']) ?></span></span>
        <div class="flex justify-between items-center">
            <a href="<?= url('/post/' . $post['id']) ?>" class="text-teal-400 hover:text-teal-200 transition font-semibold">← Назад к посту</a>
            <button type="submit" class="bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Сохранить</button>
            <a href="<?= url('/post/delete/' . $post['id']) ?>" class="bg-red-700 text-white px-6 py-2 rounded-lg shadow hover:bg-red-600 font-semibold transition">Удалить</a>
        </div>
    </form>
</div>
