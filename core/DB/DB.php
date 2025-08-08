<?php

namespace Core\DB;

class DB {
    protected static $pdo;

    public static function getConnection() {
        if (!self::$pdo) {
            self::$pdo = new \PDO(
                "mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_NAME') . ";port=" . env('DB_PORT'),
                env('DB_USER'),
                env('DB_PASS')
            );
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }

    public static function migrate() {
        $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                level TINYINT NOT NULL DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS posts (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                title VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS comments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                post_id INT NOT NULL,
                user_id INT NOT NULL,
                content TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS telegram_subscriptions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                chat_id INT NOT NULL,
                username VARCHAR(255),
                first_name VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        // $pdo = DB::getConnection();
        // $pdo->exec("ALTER TABLE users ADD COLUMN level TINYINT NOT NULL DEFAULT 1");


        self::getConnection()->exec($sql);
        echo "Таблицы успешно созданы";
    }
}