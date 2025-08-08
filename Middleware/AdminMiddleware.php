<?php

namespace Middleware;

class AdminMiddleware
{
    public static function handle() {
        if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] < 2) {
            redirect('/');
            exit;
        }
    }
}
