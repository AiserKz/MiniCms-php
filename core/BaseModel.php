<?php

namespace Core;

use Core\DB;
use PDO;

/**
 * Абстрактный базовый класс модели.
 * Все модели (Post, User и т.д.) должны наследовать от него.
 */
abstract class BaseModel {
    // Атрибуты модели (title, content, user_id и т.д.)
    protected $attributes = [];

    /**
     * Конструктор — можно сразу передать данные.
     * Пример: new Post(['title' => 'Пример', 'content' => 'Текст'])
     */
    public function __construct($attributes = []) {
        $this->fill($attributes); // Заполняем массив атрибутов
    }

    /**
     * Метод fill() заполняет атрибуты модели.
     * Используется внутри конструктора или вручную.
     */
    public function fill($data) {
        foreach ($data as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Магический геттер: $post->title
     */
    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    /**
     * Магический сеттер: $post->title = 'Новый заголовок';
     */
    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    /**
     * Метод, который должен реализовать каждый наследник.
     * Должен возвращать имя таблицы: return 'posts';
     */
    abstract public static function tableName();

    /**
     * Поиск записи по ID. Возвращает объект текущей модели или null.
     * Пример: $post = Post::find(1);
     */
    public static function find($id) {
        $pdo = DB::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM " . static::tableName() . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Если нашли запись, возвращаем объект модели
        return $data ? new static($data) : null;
    }

    /**
     * Сохраняет модель: INSERT или UPDATE.
     * Если id существует — UPDATE, иначе — INSERT.
     * Пример:
     *   $post = new Post(['title' => '...', 'user_id' => 1]);
     *   $post->save();
     */
    public function save() {
        $pdo = DB::getConnection();
        $columns = array_keys($this->attributes); // Получаем список полей

        if (isset($this->attributes['id'])) {
            // Обновление (UPDATE)
            // Формируем: title = :title, content = :content
            $set = implode(', ', array_map(fn($col) => "$col = :$col", $columns));
            $sql = "UPDATE " . static::tableName() . " SET $set WHERE id = :id";
        } else {
            // 🆕 Вставка (INSERT)
            // Формируем: (title, content) VALUES (:title, :content)
            $cols = implode(', ', $columns);
            $placeholders = implode(', ', array_map(fn($col) => ":$col", $columns));
            $sql = "INSERT INTO " . static::tableName() . " ($cols) VALUES ($placeholders)";
        }

        // Выполняем подготовленный запрос
        $stmt = $pdo->prepare($sql);
        $stmt->execute($this->attributes);

        // Если это был INSERT, получаем ID и сохраняем в атрибутах
        if (!isset($this->attributes['id'])) {
            $this->attributes['id'] = $pdo->lastInsertId();
        }

        // Возвращаем id текущей записи
        return $this->attributes['id'];
    }
}
