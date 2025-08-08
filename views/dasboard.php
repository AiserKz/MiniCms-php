
<div class="flex flex-col items-center justify-center py-8 px-4">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-2xl max-w-6xl w-full">
        <h1 class="text-4xl font-extrabold text-teal-300 mb-8 text-center drop-shadow-lg">Управление постами</h1>
        <div class="flex justify-between items-center mb-8">
            <div>
                <span class="text-gray-400 text-lg mr-6">Всего постов: <span class="text-teal-300 font-bold"><?= count($posts) ?? 0 ?></span></span>
                <span class="text-gray-400 text-lg">Пользователей: <span class="text-teal-300 font-bold"><?= count($users) ?? 0 ?></span></span>
            </div>
            <div>
                <button id="btn" class="bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Пользователи</button>
                <a href="<?= url('/new-post') ?>" class="bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Создать пост</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table id="tableUser" class="hidden min-w-full bg-gray-900 rounded-xl shadow-lg">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">ID</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Имя</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Email</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Уровень</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b border-gray-800 hover:bg-gray-800 transition">
                            <td class="px-4 py-3 text-teal-300 font-mono"> <?= htmlspecialchars($user['id']) ?></td>
                            <td class="px-4 py-3 text-teal-300 font-mono"> <?= htmlspecialchars($user['name']) ?></td>
                            <td class="px-4 py-3 text-teal-300 font-mono"> <?= htmlspecialchars($user['email']) ?></td>
                            <td class="px-4 py-3 text-teal-300 font-mono"> <?= htmlspecialchars($user['level']) ?></td>
                            <td class="px-4 py-3 text-teal-300 font-mono">
                                <a href="<?= url('/user/update/' . $user['id']) ?>" class="text-teal-400 hover:text-teal-200 transition font-semibold mr-4">Редактировать</a>
                                <a href="<?= url('/user/delete/' . $user['id']) ?>" class="text-red-400 hover:text-red-200 transition font-semibold">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <table class="min-w-full bg-gray-900 rounded-xl shadow-lg" id="tablePost">
                <thead>
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">ID</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Заголовок</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Автор</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Дата</th>
                        <th class="px-4 py-3 text-left text-gray-300 font-semibold">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr class="border-b border-gray-800 hover:bg-gray-800 transition">
                            <td class="px-4 py-3 text-teal-300 font-mono"> <?= htmlspecialchars($post['id']) ?></td>
                            <td class="px-4 py-3 text-gray-100 font-semibold"><a href="<?= url('/post/' . $post['id']) ?>"><?= htmlspecialchars($post['title']) ?></a></td>
                            <td class="px-4 py-3 text-gray-200"><?= htmlspecialchars($post['author_name']) ?></td>
                            <td class="px-4 py-3 text-gray-400 text-sm">
                                <?= htmlspecialchars(date('d.m.Y H:i', strtotime($post['created_at']))) ?>
                            </td>
                            <td class="px-4 py-3 flex flex-wrap gap-2">
                                <a href="<?= url('/post/' . $post['id']) ?>" class="bg-teal-700 text-white px-3 py-1 rounded shadow hover:bg-teal-600 font-semibold transition text-sm">Просмотр</a>
                                <a href="<?= url('/post/update/' . $post['id']) ?>" class="bg-yellow-400 text-gray-900 px-3 py-1 rounded shadow hover:bg-yellow-500 font-semibold transition text-sm">Редактировать</a>
                                <a href="<?= url('/post/delete/' . $post['id']) ?>" class="bg-red-700 text-white px-3 py-1 rounded shadow hover:bg-red-600 font-semibold transition text-sm" onclick="return confirm('Удалить пост?')">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    const mainUi = {
        tablePost: document.querySelector('#tablePost'),
        tableUser: document.querySelector('#tableUser'),
        btn: document.querySelector('#btn'),
        toggleMode() {
            this.tablePost.classList.toggle('hidden');
            this.btn.innerText = this.tablePost.classList.contains('hidden') ? 'Посты' : 'Пользователи';
            this.tableUser.classList.toggle('hidden');
        },
        init() {
            if (this.btn) {
                this.btn.addEventListener('click', () => mainUi.toggleMode());
            }
        }
    };
    mainUi.init();
   
</script>