<?php
class DoauthAction extends CAction
{
    public function run()
    {
        $id = Yii::app()->request->getParam('id');
        $pid = Yii::app()->request->getParam('pid');
        $auth_name = $str = preg_replace('/^[\pZ\pC]+|[\pZ\pC]+$/u','',Yii::app()->request->getParam('authName'));
        $contrl = Yii::app()->request->getParam('authContrl');
        $action = Yii::app()->request->getParam('authAction');
        $level = Yii::app()->request->getParam('authLevel');
        if($_POST)
        {
            if(empty($auth_name))
            {
                Yii::error("权限名称不能为空",Yii::app()->createUrl('manage/doauth'),"1");die;
            }
            if($pid == 0)
            {
                $authId = CManage::insertAuth($auth_name,$level);
                if($authId)
                {
                    $path = $authId.',';
                    $res = CManage::updateAuth($path,$authId);
                    if($res)
                    {
                        Yii::error("添加权限成功！",Yii::app()->createUrl('manage/doauth'),"1");die;
                    }
                }
            }else{

                $authId = CManage::insertAuth($auth_name,$contrl,$action,$pid,$path='',$level);
                if($authId)
                {
                    $path = $pid.','.$authId.',';
                    $res = CManage::updateAuth($path,$authId);
                    if($res)
                    {
                        Yii::error("添加权限成功！",Yii::app()->createUrl('manage/doauth'),"1");die;
                    }
                }
            }

        }
        if($id)
        {
            $authOne = CManage::searchAuth_one($id);
            var_dump($authOne);
        }
        $auth = CManage::searchAll_auth();
        $this->controller->layout = false;
        $this->controller->render('doauth',array('auth'=>$auth));
    }
}