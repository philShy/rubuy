<?php
class CommentController extends Controller{

    public function actions(){
        return array(
            'comment_article'=>'application.controllers.comment.Comment_articleAction',
        );
    }
}