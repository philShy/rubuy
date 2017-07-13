<?php
class AddbrandAction extends CAction{
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
        $brandname = Yii::app()->request->getParam('brandname');
        $sort = Yii::app()->request->getParam('sort');
        $address = Yii::app()->request->getParam('address');
        $discribe= Yii::app()->request->getParam('introduce');

        if($_FILES)
        {
            $brandid = CProduct::addBrand($brandname,$sort,$address,$discribe);
            if($brandid)
            {
                $folder1 = Yii::app()->request->hostInfo.'/images/brand/';
                CUploadbrandlogo::uploadbrandlogo($brandid,$images_class_id=2,$folder1);
            }
        }

        if(Yii::app()->request->isAjaxRequest && $brandname){

            if(empty($brandname))
            {
                echo 0;die;
            }
            $result = CProduct::searchBrand($brandname);
            if(!empty($result))
            {
                echo 1;
            }else if(empty($result))
            {
                echo 2;
            }
            die;
        }

        if(Yii::app()->request->isAjaxRequest && $sort){
            if(empty($sort))
            {
                echo 0;die;
            }
            $result = CProduct::searchSort($sort);
            if(!empty($result))
            {
                echo 1;
            }else if(empty($result))
            {
                echo 2;
            }
            die;
        }

        if(Yii::app()->request->isAjaxRequest && $address){
            if(empty($address))
            {
                echo 0;die;
            }
            die;
        }
        $this->controller->layout = false;
        $this->controller->render('addbrand');
    }
}