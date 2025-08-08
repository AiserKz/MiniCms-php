<div id="toast-container" class="fixed top-20 right-10 z-50 p-4 text-center"></div>
<?php if (isset($_SESSION['toast'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            showToast("<?= $_SESSION['toast']['message'] ?>", "<?= $_SESSION['toast']['type'] ?>");
        });
    </script>
    <?php unset($_SESSION['toast']); ?>
<?php endif; ?>
</main>
    <footer class="flex items-end border-t border-gray-700 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-700 text-white py-8 mt-12 shadow-inner rounded-t-xl">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <span class="font-bold text-lg text-teal-300">MiniCMS Блог</span>
                <p class="text-sm text-gray-400">© <?= date('Y') ?> Все права защищены.</p>
            </div>
            <div class="flex space-x-6">
                <a href="https://github.com/" target="_blank" class="hover:text-blue-200 transition">
                    <!-- Иконка GitHub -->
                </a>
                <a href="mailto:info@minicms.local" class="hover:text-blue-200 transition">
                    <!-- Иконка Email -->
                </a>
            </div>
        </div>
    </footer>
</body>

<script>
    function showToast(message, type='info' , timeout = 3000) {
        const toast = document.createElement('div');
        toast.textContent = message;

        toast.style.cssText = `
            background-color: ${type === 'info' ? '#db7134ff' : type === 'error' ? '#e74c3c' : type === 'success' ? '#2ecc71' : '#3498db'};
            color: white;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s ease;
        `;

        const container = document.getElementById('toast-container');
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateX(0)';
        }, 100);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                toast.remove();
            }, 400);
        }, timeout);
    }
</script>

</html>
