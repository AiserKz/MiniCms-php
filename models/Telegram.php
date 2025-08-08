<?php

namespace Models;

use Core\DB\DB;
use Core\Models\BaseModel;

class Telegram extends BaseModel
{
    public static function tableName() {
        return 'telegram_subscriptions';
    }

    public static function all() {
        $pdo = DB::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM " . static::tableName());
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function create($chat_id, $username, $first_name) {
        echo $chat_id . ' - ' . $username . ' - ' . $first_name;
        $pdo = DB::getConnection();

        $stmt = $pdo->prepare("INSERT IGNORE INTO " . static::tableName() . " (chat_id, username, first_name) VALUES (:chat_id, :username, :first_name)");
        $stmt->execute(['chat_id' => $chat_id, 'username' => $username, 'first_name' => $first_name]);

    }
}