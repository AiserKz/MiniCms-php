<?php

namespace Models;

use Core\DB;
use Core\BaseModel;

class Post extends BaseModel {

    public static function tableName() {
        return 'posts';
    }

    public static function all() {
        $pdo = DB::getConnection();

        $stmt = $pdo->query("
            SELECT posts.*,
            users.name AS author_name 
            FROM posts 
            JOIN users ON posts.user_id = users.id 
            ORDER BY posts.created_at DESC"
        );
        return $stmt->fetchAll();
    }

    public static function findObject($id) {
        $pdo = DB::getConnection();

        $stmt = $pdo->prepare("
            SELECT posts.*, users.name AS author_name
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.id = :id
        ");

        $stmt->execute(['id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function search($term) {
        $pdo = DB::getConnection();

        $stmt = $pdo->prepare("
            SELECT posts.*, users.name AS author_name
            FROM posts
            JOIN users ON posts.user_id = users.id
            ORDER BY posts.created_at DESC
        ");

        $stmt->execute([
            'term' => '%' . $term . '%'
        ]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function delete($id) {
        $pdo = DB::getConnection();

        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public static function latest() {
        $pdo = DB::getConnection();
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 1");
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}