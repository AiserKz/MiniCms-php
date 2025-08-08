<?php 

namespace Middleware;

class AuthMiddleware {
    public static function handle() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
            exit;
        }
    }
}