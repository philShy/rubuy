<?php
class BrandAction extends CAction{
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
        $brand = Yii::app()->request->getParam('brand_name');
        $create_time = Yii::app()->request->getParam('create_time');
        $brand_id = Yii::app()->request->getParam('brand_id');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $state = Yii::app()->request->getParam('state');
        if($state)
        {
            if($state == 'sure')
            {
                $state = 0;
            }
            $code = CProduct::editBrandstatebyid($brand_id,$state);
            echo $code;die;
        }
        if($is_delete)
        {
            $code = CProduct::delBrandbyid($brand_id,$is_delete);
            echo $code;die;
        }

        if($brand && !empty($create_time))
        {
            $sql1 = "a.id = $brand AND";
        }else if($brand && empty($create_time)){
            $sql1 = "a.id = $brand";
        }else{
            $sql1 = "";
        }
        if($create_time)
        {
            $sql2 = "a.create_time >$create_time";
        }else{
            $sql2 = '';
        }
        if($brand || $create_time)
        {
            $brandarr = CProduct::searchbrand_Bywhere($sql1,$sql2);
            $count = count($brandarr);

        }elseif(empty($brand) && empty($create_time)){

            $brandarr = CProduct::searchBrandall();
            $count = count($brandarr);
        }
        $this->controller->layout = false;
        $this->controller->render('brand',array('brandarr'=>$brandarr,'count'=>$count));
    }
}