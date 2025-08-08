<?php

namespace Core;

use Telegram\Bot\Api;
use Models\Post;

class BotModule {
    protected Api $bot;
    protected $chat_id;
    protected $text;

    public function __construct(Api $bot, $chat_id, $text) {
        $this->bot = $bot;
        $this->chat_id = $chat_id;
        $this->text = trim($text);
    }

    public function handle() {
        switch (true) {
            case $this->text === '/start':
                $this->start();
                break;

            case $this->text === '/help':
                $this->help();
                break;

            case $this->text === '/latest':
                $this->latestPost();
                break;

            default:
                $this->unknownCommand(); 
                break;
        }
    }

    protected function start() {
        $this->bot->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => "👋 Привет, господин! Этот бот подключён к вашему мини-блогу.\n\n🟢 Доступные команды:\n/help — помощь\n/latest — последний пост",
        ]);
    }

    protected function help() {
        $this->bot->sendMessage([
            'chat_id' => $this->chat_id, 
            'text' => "🛠 Вот список команд:\n\n/start — приветствие\n/latest — последний пост\n/help — помощь",
        ]);
    }

    protected function latestPost() {
        $post = Post::latest();

        if (!$post) {
            $this->bot->sendMessage([
                'chat_id' => $this->chat_id,
                'text' => "❌ Посты не найдены.",
            ]);
            return;
        }

        $message = "🆕 Последний пост:\n\n*{$post['title']}*\n{$post['content']}\n\n📎 Читать: http://localhost/post/{$post['id']}";

        $this->bot->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);
    }

    protected function unknownCommand() { 
        $this->bot->sendMessage([
            'chat_id' => $this->chat_id,
            'text' => "🤔 Я не понимаю эту команду. Напишите /help для списка.",
        ]);
    }
}
