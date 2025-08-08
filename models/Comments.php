<?php 

namespace Models;

use Core\DB\DB;
use Core\Models\BaseModel;

class Comments extends BaseModel {
    public static function tableName() {
        return 'comments';
    }

    public static function all() {
        $pdo = DB::getConnection();

        $stmt = $pdo->query("
            SELECT comments.*,
            users.name AS username
            FROM comments
            JOIN users ON comments.user_id = users.id
            ORDER BY comments.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public static function forPost($postId) {
        $pdo = DB::getConnection();

        $stmt = $pdo->prepare("
            SELECT comments.*, users.name AS author_name
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.post_id = :post_id
            ORDER BY comments.created_at ASC
        ");

        $stmt->execute(['post_id' => $postId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    } 
}