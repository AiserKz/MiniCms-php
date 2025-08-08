
<div class="flex flex-col items-center justify-center py-12">
    <div class="bg-gray-800 p-6 rounded-2xl shadow-2xl max-w-md w-full">
        <div class="flex justify-center mb-8">
            <button id="loginTab" class="px-6 w-1/2 py-2 rounded-t-lg font-bold text-teal-300 bg-gray-900 focus:outline-none transition-all duration-300" onclick="showForm('login')">Вход</button>
            <button id="registerTab" class="px-6 w-1/2 py-2 rounded-t-lg font-bold text-gray-300 bg-gray-900 focus:outline-none transition-all duration-300" onclick="showForm('register')">Регистрация</button>
        </div>
        <div id="loginForm" class="transition-all duration-500">
            <form action="<?= url('/login') ?>" method="post" class="space-y-6">
                <?= generate_csrf_token() ?>
                <h2 class="text-2xl font-bold text-teal-300 mb-4 text-center">Вход</h2>
                <input type="text" name="name" placeholder="Логин" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" required>
                <input type="password" name="password" placeholder="Пароль" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" required>
                <button type="submit" class="w-full bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Войти</button>
            </form>
        </div>
        <div id="registerForm" class="hidden transition-all duration-500">
            <form action="<?= url('/register') ?>" method="post" class="space-y-6">
                <h2 class="text-2xl font-bold text-teal-300 mb-4 text-center">Регистрация</h2>
                <?= generate_csrf_token() ?>
                <input type="text" name="name" placeholder="Логин" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" required>
                <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" required>
                <input type="password" name="password" placeholder="Пароль" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" required>
                <input type="password" name="password_confirm" placeholder="Повторите пароль" class="w-full px-4 py-2 rounded bg-gray-900 text-gray-100 border border-gray-700 focus:outline-none focus:border-teal-500" required>
                <button type="submit" class="w-full bg-teal-700 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-600 font-semibold transition">Зарегистрироваться</button>
            </form>
        </div>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger mt-4">
                    <ul>
                        <?php foreach ($errors as $fieldErrors): ?>
                            <?php foreach ($fieldErrors as $error): ?>
                                <li class="text-red-500 text-center"><?= htmlspecialchars($error) ?></li>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
    </div>
</div>
<script>
function showForm(form) {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    if (form === 'login') {
        loginForm.classList.remove('hidden');
        loginForm.classList.add('animate-fadeIn');
        registerForm.classList.add('hidden');
        loginTab.classList.add('text-teal-300');
        registerTab.classList.remove('text-teal-300');
    } else {
        registerForm.classList.remove('hidden');
        registerForm.classList.add('animate-fadeIn');
        loginForm.classList.add('hidden');
        registerTab.classList.add('text-teal-300');
        loginTab.classList.remove('text-teal-300');
    }
}
</script>
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
  animation: fadeIn 0.5s;
}
</style>