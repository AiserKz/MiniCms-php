<div class="flex flex-col items-center justify-center min-h-[60vh] py-12 px-4">
    <article class="bg-gray-800 p-8 rounded-2xl shadow-2xl max-w-2xl w-full">
        <a href="<?= url('/') ?>" class="text-teal-400 hover:text-teal-200 transition font-semibold">← Назад к списку</a>
        <h1 class="text-4xl font-extrabold text-teal-300 mb-4 drop-shadow-lg text-center">
            <?= htmlspecialchars($post['title']) ?>
        </h1>
        <div class="flex flex-col md:flex-row md:justify-between items-center mb-6">
            <span class="text-gray-400 text-lg">
                Автор: <span class="text-teal-400 font-semibold"><?= htmlspecialchars($post['author_name']) ?></span>
            </span>
            <span class="text-gray-500 text-sm mt-2 md:mt-0">
                <?= htmlspecialchars(date('d.m.Y H:i', strtotime($post['created_at']))) ?>
            </span>
        </div>
        <div class="prose prose-invert max-w-none text-gray-200 text-lg leading-relaxed mb-8">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>
        <div class="flex justify-between items-center">
            <?php if (user_level() > 1 || user_id() == $post['user_id']): ?>
                <a href="<?= url('/post/update/' . $post['id']) ?>" class="text-yellow-400 hover:text-black duration-300 transition font-semibold p-2 border border-yellow-400 rounded hover:bg-yellow-600">Редактировать</a>
            <?php endif; ?>
            <a href="#comments" class="text-teal-400 hover:text-teal-200 transition font-semibold">Комментарии</a>
        </div>
    </article>

    <!-- Блок комментариев (пример, можно доработать) -->
    <section id="comments" class="mt-12 bg-gray-800 p-6 rounded-xl shadow-lg max-w-2xl w-full">
        <h2 class="text-2xl font-bold text-teal-300 mb-4">Комментарии</h2>
        <?php if (empty($comments)): ?>
            <p class="text-gray-400 mb-2">Нет комментариев. Будьте первым!</p>
        <?php else: ?>
            <?php foreach ($comments as $com): ?>
                <div class="flex items-center space-x-4 mb-4">
                    <p class="text-gray-400 text-sm">
                        Автор: <span class="text-teal-400 font-semibold"><?= htmlspecialchars($com['author_name']) ?></span>
                    </p>
                    <p class="text-gray-500 text-sm">
                        <?= htmlspecialchars(date('d.m.Y H:i', strtotime($com['created_at']))) ?>
                    </p>
                </div>
                <div class="prose prose-invert max-w-none text-gray-200 text-lg leading-relaxed mb-4">
                    <?= nl2br(htmlspecialchars($com['content'])) ?>
                </div>
                    
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (auth()): ?>
        <form action="<?= url('/post/add-comment') ?>" method="post" class="space-y-4">
            <?= generate_csrf_token() ?>
            <input name="post_id" type="hidden" value="<?= $post['id'] ?>" ></input>
            <textarea name="comment" placeholder="Ваш комментарий..." class=" w-full px-4 py-2 rounded-lg bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" rows="4" required></textarea>
            <button type="submit" class="bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Отправить</button>
        </form>
        <?php else: ?>
            <p class="text-gray-400 mb-2">Войдите, чтобы оставить комментарий.</p>
        <?php endif; ?>
    </section>
</div>