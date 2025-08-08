<?php 

use Core\View;
use Models\Post;



class HomeController {
    
    public function index() {
        $posts = Post::all();
        View::render('home', ['title' => 'Главная', 'posts' => $posts]);
    }

    public function about() {
        View::render('about', ['title' => 'О нас']);
    }
}