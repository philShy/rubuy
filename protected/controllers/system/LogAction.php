<?php
class LogAction extends CAction{
    public function run()
    {
        $action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $userid = Yii::app()->user->id;
        $auth_arr = CManage::searchAuth_Byadminid($userid);
        $auth_join = array_filter(explode(',',$auth_arr['auth_join']));
        if(!empty($auth_join))
        {
            if(!in_array($the_join,$auth_join))
            {

                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }else{
            if($auth_arr['role_id'] != 1)
            {
                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }

        $manager = Yii::app()->request->getParam('manager');
        $datetime = Yii::app()->request->getParam('datetime');
        if($manager && $datetime)
        {
            $log_arr = CSystem::log_where($manager,$datetime);
        }elseif($manager && empty($datetime))
        {
            $log_arr = CSystem::log_where($manager,$datetime);

        }elseif(empty($manager) && $datetime)
        {
            $log_arr = CSystem::log_where($manager,$datetime);
        }else{
            $log_arr = CSystem::searchSystem_log();
        }

        $this->controller->layout = false;
        $this->controller->render('log',array('log_arr'=>$log_arr));
    }
}