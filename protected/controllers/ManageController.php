<?php
class ManageController extends Controller
{
    public function actions()
    {
        return array(
            'list'=>'application.controllers.manage.ListAction',
            'role'=>'application.controllers.manage.RoleAction',
            'info'=>'application.controllers.manage.InfoAction',
            'auth'=>'application.controllers.manage.AuthAction',
            'addrole'=>'application.controllers.manage.AddroleAction',
            'edit'=>'application.controllers.manage.EditAction',
            'doauth'=>'application.controllers.manage.DoauthAction',
            'editauth'=>'application.controllers.manage.EditauthAction',
            'editmanager'=>'application.controllers.manage.EditmanagerAction',
        );
    }
}