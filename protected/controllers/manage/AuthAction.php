<?php
class AuthAction extends CAction
{
    public function run()
    {
        $page = Yii::app()->request->getParam('page');
        if(empty($page))
        {
            $page = 1;
        }
        $auth = CManage::searchAll_authpage($page,$size=10);
        $count = count(CManage::searchAll_auth());
        $this->controller->layout = false;
        $this->controller->render('auth',array('auth'=>$auth,'count'=>$count,'page'=>$page));
    }
}