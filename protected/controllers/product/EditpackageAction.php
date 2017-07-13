<?php
class EditpackageAction extends CAction{
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
        $packageid = Yii::app()->request->getParam('id');
        $packagearr = CProduct::searchPackage_byid($packageid);
        $packagemodelarr = CProduct::searchPackagemodel_byid($packageid);
        foreach($packagemodelarr as $key=>$value)
        {
            $modelid_arr[$key] = $value['good_model_id'];
        }
        $package_id = Yii::app()->request->getParam('package_id');
        $arr['goodsmodel'] = Yii::app()->request->getParam('goodsmodel');
        $arr['goodsnum'] = Yii::app()->request->getParam('goodsnum');
        $arr['unit_price'] = Yii::app()->request->getParam('unit_price');
        $meal_id = CProduct::searchMeal_goodsid($package_id);
        $mod=array();
        if (!empty($arr['goodsmodel']))
        {
            foreach($meal_id as $k=>$v)
            {
                $arr['meal_id'][$k] = $v['id'];
            }
            $length = count($arr['goodsmodel']);
            $key=0;
            for ($i = 0; $i < $length; $i++)
            {
                if (!empty($arr['goodsmodel'][$i])&&!empty($arr['goodsnum'][$i]))
                {
                    $mod[$key]['goodsmodel'] = $arr['goodsmodel'][$i];
                    $mod[$key]['goodsnum'] = $arr['goodsnum'][$i];
                    $mod[$key]['meal_id'] = $arr['meal_id'][$i];
                    $mod[$key]['unit_price'] = $arr['unit_price'][$i];
                    $key++;
                }
            }
        }
        $packagename = Yii::app()->request->getParam('packagename');
        $endtime = str_replace("/","-",Yii::app()->request->getParam('endtime'));
        //$discount = Yii::app()->request->getParam('discount');
        $introduce = Yii::app()->request->getParam('introduce');
        $status = Yii::app()->request->getParam('status');
        //$package_price = Yii::app()->request->getParam('package_price');

        if($package_id)
        {
            if(empty($endtime))
            {
                $endtime = date('Y-m-d H:i:s',time());
            }
            $updatetime = date('Y-m-d H:i:s',time());
            $price1 = CProduct::searchModels_byid($arr['goodsmodel'][0])['price'];
            $price2 = CProduct::searchModels_byid($arr['goodsmodel'][1])['price'];

            if($arr['goodsmodel'][2])
            {
                $price3 = CProduct::searchModels_byid($arr['goodsmodel'][2])['price'];
            }else{
                $price3 =0;
            }
            $original_price = $price1*$arr['goodsnum'][0]+$price2*$arr['goodsnum'][1]+$price3*$arr['goodsnum'][2];
            foreach($mod as $m_k=>$m_v)
            {
                $sum[$m_k] = $m_v['goodsnum']*$m_v['unit_price'];
            }
            $packageprice = array_sum($sum);
            $discount = round($packageprice/$original_price, 2)*10;
            $tr = Yii::app()->db->beginTransaction();
            try {
                CProduct::editPackage($package_id,$packagename,$packageprice,$original_price,$discount,$introduce,$endtime,$status);
                foreach($mod as $key=>$value)
                {
                    $result = CProduct::editPackage_goodsmodel($value['meal_id'],$value['goodsmodel'],$value['goodsnum'],$value['unit_price'],$updatetime,$status);
                }

                $tr->commit();
            } catch (Exception $e) {
                $tr->rollBack();
            }
            if($result)
            {
                Yii::success("更新套餐成功",Yii::app()->createUrl('../product/package'),"3");die;
            }
        }

        $catid = Yii::app()->request->getParam('catid');
        if(Yii::app()->request->isAjaxRequest && $catid)
        {
          $goodsarr = CProduct::searchGoods($catid);
          echo json_encode($goodsarr);die;
        }
        $goodsid = Yii::app()->request->getParam('goodsid');
        if(Yii::app()->request->isAjaxRequest && $goodsid)
        {
          $modelarr = CProduct::searchModels($goodsid);
          echo json_encode($modelarr);die;
        }

        foreach($modelid_arr as $key=>$value)
        {
            $key+=1;
            $model_arr = CProduct::searchGoodsmodelbyid1($value,$packageid);
            $model[$key]['model_id'] = $value;
            $model[$key]['quantity'] = $model_arr['quantity'];
            $model[$key]['unit_price'] = $model_arr['unit_price'];
            $model[$key]['goods_id'] = $model_arr['goods_id'];
            $model[$key]['cate_id'] = $model_arr['cate'];
            $model[$key]['price'] = $model_arr['price'];
        }

        if($model[1]['cate_id'] && $model[1]['goods_id']){
            $goodsarr[1] = CProduct::searchGoods($model[1]['cate_id']);
            $modelarr[1] = CProduct::searchModels($model[1]['goods_id']);
        }
        if($model[2]['cate_id'] && $model[2]['goods_id']){
            $goodsarr[2] = CProduct::searchGoods($model[2]['cate_id']);
            $modelarr[2] = CProduct::searchModels($model[2]['goods_id']);
        }
        if($model[3]['cate_id'] && $model[3]['goods_id']){
            $goodsarr[3] = CProduct::searchGoods($model[3]['cate_id']);
            $modelarr[3] = CProduct::searchModels($model[3]['goods_id']);
        }
        $result = CProduct::getcategoryList();
        $this->controller->layout = false;
        $this->controller->render('editpackage',array('result'=>$result,'packagearr'=>$packagearr,'model'=>$model,'modelarr'=>$modelarr,'goodsarr'=>$goodsarr));
    }
}