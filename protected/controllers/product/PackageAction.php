<?php
class PackageAction extends CAction{
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
        $is_delete = Yii::app()->request->getParam('is_delete');
        $state = Yii::app()->request->getParam('state');
        $meal_goods_id = Yii::app()->request->getParam('meal_goods_id');
        $package_id = Yii::app()->request->getParam('package_id');
        $packagename = Yii::app()->request->getParam('packagename');
        $create_time = Yii::app()->request->getParam('create_time');
        if($packagename && !empty($create_time))
        {
            $sql1 = "a.name LIKE '%$packagename%' AND";
        }else if($packagename && empty($create_time))
        {
            $sql1 = "a.name LIKE '%$packagename%'";
        }else{
            $sql1 = "";
        }
        if($create_time)
        {
            $sql2 = "a.create_time >$create_time";
        }else{
            $sql2 = '';
        }
        if($packagename || $create_time)
        {
            $packagearr = CProduct::searchpackage_Bywhere($sql1,$sql2);
            $count = count($packagearr);

        }elseif(empty($searchCate)   && empty($searchBrand) && empty($searchName) && empty($searchDate))
        {
            $packagearr = CProduct::searchpackage();

            foreach($packagearr as $key=>$value)
            {
                $modelid_arr = explode(',',$value['good_model_id']);
                foreach($modelid_arr as $k=>$v)
                {
                    $model = CProduct::searchGoodsmodelbyid($v);
                    if($model)
                    {
                        $one_model[$k] = $model['name'].'【'.$model['model_number'].'】';
                    }
                }
                //var_dump($packagearr);
                //var_dump(count($one_model));//统计套餐内商品的个数
                $modelid_str = implode('&nbsp;',$one_model);
                $packagearr[$key]['good_model_name']=$modelid_str;
            }
            $count = count($packagearr);
        }
        if($state)
        {
            if($state == 'sure')
            {
                $state = 0;
            }
            $result = CProduct::editPackagestate($meal_goods_id,$state);
            echo $result;die;
        }
        if($is_delete)
        {
            $result = CProduct::delPackage_model($meal_goods_id);
            /*$tr = Yii::app()->db->beginTransaction();
            try {
                $result1 = CProduct::delPackage($meal_goods_id,$is_delete);
                $result2 = CProduct::delPackage_model($meal_goods_id,$is_delete);
                $tr->commit();
            } catch (Exception $e) {
                $tr->rollBack();
            }
            if($result1&&$result2){
                echo 1;
            }*/
            echo $result;die;
        }

        $this->controller->layout = false;
        $this->controller->render('package',array('packagearr'=>$packagearr,'count'=>$count));
    }
}