<?php
class EditauthAction extends CAction
{
    public function run()
    {
        $id = Yii::app()->request->getParam('id');
        $auth_name = $str = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',Yii::app()->request->getParam('authName'));
        $contrl = Yii::app()->request->getParam('authContrl');
        $action = Yii::app()->request->getParam('authAction');
        $level = Yii::app()->request->getParam('authLevel');
        if($id)
        {
            $authOne = CManage::searchAuth_one($id);
        }
        if($_POST)
        {
            $res = CManage::updateAuth_byid($id,$auth_name,$contrl,$action,$level);
            if($res)
            {
                Yii::error("修改权限成功！",Yii::app()->createUrl('manage/auth'),"1");die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('editauth',array('authOne'=>$authOne));
    }
}