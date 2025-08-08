<?php 

namespace Models;

use Core\DB;
use Core\BaseModel;
use PDO;

class User extends BaseModel
{
    public static function tableName() {
        return 'users';
    }

    public static function find($id) {
        $pdo = DB::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM " . static::tableName() . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    public static function all() {
        $pdo = DB::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM " . static::tableName());
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}