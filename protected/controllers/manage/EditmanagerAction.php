<?php
class EditmanagerAction extends CAction
{
    public function run()
    {
        $manager_id = Yii::app()->request->getParam('id');
        $role = CManage::searchAllrole();
        if($manager_id)
        {
            $manager_one = CManage::searchManager_one($manager_id);
        }
        if($_POST)
        {
            $managerid = Yii::app()->request->getParam('managerid');
            $manager = Yii::app()->request->getParam('name');
            $password = Yii::app()->request->getParam('userpassword');
            $sex = Yii::app()->request->getParam('sex');
            $phone = Yii::app()->request->getParam('phone');
            $email = Yii::app()->request->getParam('email');
            $role_id = Yii::app()->request->getParam('role');
            $note = Yii::app()->request->getParam('note');
            $create_time = date('Y-m-d H:i:s',time());
            $result = CManage::editManager($managerid,$manager,$password,$sex,$phone,$email,$role_id,$create_time,$note);
            if($result)
            {
                Yii::success("修改成功",Yii::app()->createUrl('manage/list'),"1");die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('editmanager',array('role'=>$role,'manager_one'=>$manager_one));
    }
}