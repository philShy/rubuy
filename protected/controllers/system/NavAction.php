<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 15:11
 */
class NavAction extends CAction{
    public function run()
    {
        $nav_name = Yii::app()->request->getParam('nav_name');
        $nav_url = Yii::app()->request->getParam('nav_url');
        $nav_sort = Yii::app()->request->getParam('nav_sort');
        $nav_id = Yii::app()->request->getParam('nav_id');
        $navid = Yii::app()->request->getParam('navid');
        $stadus = Yii::app()->request->getParam('stadus');
        $is_delete = Yii::app()->request->getParam('is_delete');
        if($nav_name&&$nav_url&&$nav_sort&&empty($nav_id))
        {
            $eid = CSystem::addNav($nav_name,$nav_url,$nav_sort);
            if($eid)
            {
                CSystem::order_notice($eid,$operat=0);
            }
            echo $eid;die;
        }
        if($navid)
        {
            $result = CSystem::searchnav_byid($navid);

            echo json_encode($result,true);die;
        }
        if($nav_id && empty($stadus) && empty($is_delete))
        {
            $result = CSystem::editNav_byid($nav_id,$nav_name,$nav_url,$nav_sort);
            echo $result;die;
        }
        if($stadus)
        {
            if($stadus == 'sure')
            {
                $stadus = 0;
            }
            $result = CSystem::editNavstadus_byid($nav_id,$stadus);
            if($result)
            {
                CSystem::order_notice($nav_id,$operat=1);
            }
            echo $result;die;
        }
        if($is_delete)
        {
            $result = CSystem::deleteNav_byid($nav_id,$is_delete);
            echo $result;die;
        }
        $nav = CSystem::searchNav();
        $this->controller->layout = false;
        $this->controller->render('nav',array('nav'=>$nav));
    }
}