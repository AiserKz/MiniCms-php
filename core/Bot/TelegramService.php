<?php 

namespace Core\Bot;

use Telegram\Bot\Api;
use Models\Telegram;

class TelegramService {
    protected $bot;

    public function __construct() {
        $this->bot = new Api(env('TELEGRAM_BOT_TOKEN'));
    }

    public function sendToAll($title, $link) {
        $chat = Telegram::all();

        $message = "🆕 Новый пост на сайте: *{$title}*\n\n📎 Читать: {$link}";

        foreach ($chat as $user) {
            try {
                $this->bot->sendMessage([
                    'chat_id' => $user['chat_id'],
                    'text' => $message,
                    'parse_mode' => 'Markdown'
                ]);
            } catch (\Throwable $e) {
                $errorMessage = "[Ошибка в " . date('Y-m-d H:i:s') . "]\n";
                $errorMessage .= $e->getMessage() . "\n";
                $errorMessage .= $e->getFile() . ":" . $e->getLine() . "\n";
                log_message($errorMessage, 'error');
            }
        }
    }
}