<?php
class ListAction extends CAction
{
    public function run()
    {
        $manage = Yii::app()->request->getParam('user-name');
        $userpassword = md5(Yii::app()->request->getParam('userpassword'));
        $sex = Yii::app()->request->getParam('sex');
        $phone = Yii::app()->request->getParam('user-tel');
        $email = Yii::app()->request->getParam('email');
        $role_id = Yii::app()->request->getParam('admin-role');
        $note = Yii::app()->request->getParam('note');
        $manager_id = Yii::app()->request->getParam('manager_id');
        $state = Yii::app()->request->getParam('state');
        $is_delete = Yii::app()->request->getParam('is_delete');
        if($manage&&$userpassword&&$phone&&$email&&$role_id)
        {
            $result = CManage::insertAdmin($manage,$userpassword,$sex,$phone,$email,$role_id,$note);
            if($result == false)
            {
                Yii::success("添加管理员失败",Yii::app()->createUrl('manage/list'),"1");die;
            }
        }
        //修改管理员状态
        if($manager_id && $state)
        {
            if($state == 'sure'){
                $state=0;
            }
            $res = CManage::editManagerstate($manager_id,$state);
            echo $res;die;
        }
        if($manager_id && $is_delete)
        {
            $res = CManage::deleteManager($manager_id,$is_delete);
            echo $res;die;
        }

        $allManager = CManage::searchAllmanager();
        $role = CManage::searchAllrole();
        $count = count($allManager);
        $this->controller->layout = false;
        $this->controller->render('list',array('allManager'=>$allManager,'count'=>$count,'role'=>$role));
    }
}