<?php 

use Core\View;
use Core\DB\DB;
use Models\Post;
use Models\Comments;


class CommentsController {

    public function newComment() {
        $content = $_POST['comment'];
        $post_id = $_POST['post_id'];
        if (is_floading('main', 10)){
            flash_toast('Невозможно добавить комментарий пожалуйста подождите', 'error');
        } else {
            $com = new Comments();
            $com->user_id = user_id();
            $com->post_id = $post_id;
            $com->content = $content;
            $com->save();
            flash_toast('Комментарии добавлен!', 'success');
        }
        redirect('/post/' . $post_id);
    }

   
}