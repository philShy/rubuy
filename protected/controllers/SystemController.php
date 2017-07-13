<?php
class SystemController extends Controller{
    public function actions(){
        return array(
            'log'=>'application.controllers.system.LogAction',
            'setting'=>'application.controllers.system.SettingAction',
            'nav'=>'application.controllers.system.NavAction',
            'doc_category'=>'application.controllers.system.Doc_categoryAction',
            'doc_list'=>'application.controllers.system.Doc_listAction',
            'add_doc'=>'application.controllers.system.Add_docAction',
            'edit_doc'=>'application.controllers.system.Edit_docAction',
        );
    }
}