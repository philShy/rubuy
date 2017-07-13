<?php
class AdminController extends Controller
{
    public function actions(){
        return array(
            'index'=>'application.controllers.admin.IndexAction',
        );
    }
}