<?php

namespace Middleware;

class GuestMiddleware {
    public static function handle() {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            redirect('/');
            exit;
        }
    }
}