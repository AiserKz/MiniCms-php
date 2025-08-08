<?php 

use Core\View;
use Core\DB;
use Models\Post;
use Models\Comments;
use Core\TelegramService;
use Core\Validator;

class PostController {

    public function show($id) {
        $post = Post::findObject((int)$id);
        $comments = Comments::forPost((int)$id);
        checkOrFail($post);
        View::render('post', ['title' => 'Пост', 'post' => $post, 'comments' => $comments]);
    }

    public function create() {
        View::render('new-post', ['title' => 'Новый пост']);
    }

    public function newPost() {
        $validator = Validator::make($_POST, [
            'title_post' => 'required|min:3|max:255',
            'content' => 'required|min:3|max:1000'
        ]);
        if ($validator->fails()) {
            View::render('new-post', [
                'title' => 'Новый пост',
                'data' => ['title' => $_POST['title_post'], 'content' => $_POST['content']],
                'errors' => $validator->errors()]
            );
            return;
        }

        $title = $_POST['title_post'] ?? '';
        $content = $_POST['content'] ?? '';
        $author_id = user_id();
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        $post->user_id = $author_id;
        $lastId = $post->save();
        
        $telegram = new TelegramService();
        $telegram->sendToAll($title, $content);
        flash_toast('Пост добавлен!', 'success');
        redirect('/post/' . $lastId);
    }

    public function update($id) {
        $post = Post::find((int)$id);

        $post->title = $_POST['title'] ?? $post->title;
        $post->content = $_POST['content'] ?? $post->content;
        $post->save();
        flash_toast('Пост обновлен!', 'success');
        redirect('/post/' . $id);
    }


    public function updateForm($id) {
        $post = Post::findObject((int)$id);
        checkOrFail($post);
        if ($post['user_id'] != user_id() && user_level() < 2) {
            redirect('/');
        }
        View::render('update-post', ['title' => 'Редактирование поста', 'post' => $post]);
    }

    public function delete($id) {
        Post::delete($id);
        flash_toast('Пост удален!', 'info');
        redirect('/');
    }
}