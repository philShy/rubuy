<?php
class ArticleController extends Controller{

    public function actions(){
        return array(
            'list'=>'application.controllers.article.ListAction',
            'sort'=>'application.controllers.article.SortAction',
            'add'=>'application.controllers.article.AddAction',
            'edit'=>'application.controllers.article.EditAction',
        );
    }
}