<?php

use Core\View;
use Models\Post;
use Models\Comments;
use Models\User;

class AdminController {
    public function index() {
        $users = User::all();
        $posts = Post::all();
        View::render('dasboard', [
            'title' => 'Панель администратора', 
            'users' => $users,
            'posts' => $posts
        ]);
    }
}