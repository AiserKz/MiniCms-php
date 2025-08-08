<div class="flex flex-col items-center justify-center py-12">
   
    <h1 class="text-5xl font-extrabold text-teal-300 mb-3 drop-shadow-lg">MiniCMS Блог</h1>
    <p class="text-xl text-gray-300 max-w-xl text-center">Добро пожаловать в тестовый блог на PHP! Здесь вы найдёте интересные статьи, советы и новости из мира веб-разработки.</p>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($posts as $post) : ?>
            <div class="mt-3 bg-gray-800 p-6 rounded-lg shadow-lg hover:bg-gray-700 transition duration-300 ease-in-out">
                <h2 class="text-2xl font-semibold text-teal-300 mb-2"><?= htmlspecialchars($post['title']) ?></h2>
                <p class="text-gray-400 mb-4"><?= htmlspecialchars($post['author_name'] )?>, <?= htmlspecialchars($post['created_at']) ?></p>
                <p class="text-gray-200 mb-6 text-elipsed line-clamp-5"><?= htmlspecialchars($post['content']) ?></p>
                <a href="<?= url('/post/' . $post['id']) ?>" 
                    class=" bg-teal-700 text-white px-4 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">
                    Читать далее
                </a>
            </div> 
        <?php endforeach; ?>
    </div>
</div>

