<?php 

require_once __DIR__ . '/../vendor/autoload.php';// Подключаем автозагрузку

use Telegram\Bot\Api;
use Core\BotModule;
use Models\Telegram;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$telegram = new Api(env('TELEGRAM_BOT_TOKEN'));


$update = $telegram->getWebhookUpdate();

$message = $update->getMessage();
$chat = $message->getChat();

$chat_id = $chat->getId();
$text = $message->getText();

// Записываем весь апдейт для отладки
// log_message(print_r($update, true));

if ($chat_id && $text) {
    try {
        Telegram::create($chat_id, $chat->getUsername(), $chat->getFirstName());
        $bot = new BotModule($telegram, $chat_id, $text);
        $bot->handle();
    } catch (\Throwable $e) {
        $errorMessage = "[Ошибка в " . date('Y-m-d H:i:s') . "]\n";
        $errorMessage .= $e->getMessage() . "\n";
        $errorMessage .= $e->getFile() . ":" . $e->getLine() . "\n";
        $errorMessage .= $e->getTraceAsString() . "\n\n";
        log_message($errorMessage, 'error');
    }
} else {
    log_message("[Не получены chat_id или text]", 'error');
}

