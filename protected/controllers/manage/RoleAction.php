<?php
class RoleAction extends CAction
{
    public function run()
    {
        $role_id = Yii::app()->request->getParam('role_id');
        $state = Yii::app()->request->getParam('state');
        $is_delete = Yii::app()->request->getParam('is_delete');
        if($role_id && $state)
        {
            if($state == 'sure')
            {
                $state = 0;
            }
            $res = CManage::editRolestate($role_id,$state);
            echo $res;die;
        }
        if($role_id && $is_delete)
        {
            $res = CManage::deleteRole($role_id,$is_delete);
            echo $res;die;
        }
        $allManager = CManage::searchAllrole();
        $count = count($allManager);
        $this->controller->layout = false;
        $this->controller->render('role',array('allManager'=>$allManager,'count'=>$count));
    }
}