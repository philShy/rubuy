<?php
class AddpackageAction extends CAction{
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
        $arr['goodsmodel'] = Yii::app()->request->getParam('goodsmodel');
        $arr['goodsnum'] = Yii::app()->request->getParam('goodsnum');
        $arr['unit_price'] = Yii::app()->request->getParam('unit_price');
        $mod=array();
        if (!empty($arr['goodsmodel']))
        {
            $length = count($arr['goodsmodel']);
            $key=0;
            for ($i = 0; $i < $length; $i++)
            {
                if (!empty($arr['goodsmodel'][$i])&&!empty($arr['goodsnum'][$i]))
                {
                    $mod[$key]['goodsmodel'] = $arr['goodsmodel'][$i];
                    $mod[$key]['goodsnum'] = $arr['goodsnum'][$i];
                    $mod[$key]['unit_price'] = $arr['unit_price'][$i];
                    $key++;
                }
            }
        }

        $packagename = Yii::app()->request->getParam('packagename');
        $endtime = str_replace("/","-",Yii::app()->request->getParam('endtime'));
        $introduce = Yii::app()->request->getParam('introduce');
        $status = Yii::app()->request->getParam('status');
        //$discount = Yii::app()->request->getParam('discount');
        //$package_price = Yii::app()->request->getParam('package_price');

        if($packagename)
        {
            if(empty($endtime))
            {
                $endtime = date('Y-m-d H:i:s',time());
            }
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
                $packageid = CProduct::addPackage($packagename,$packageprice,$original_price,$discount,$introduce,$endtime,$status);

                foreach($mod as $key=>$value)
                {
                    $result = CProduct::addPackage_goodsmodel($packageid,$value['goodsmodel'],$value['goodsnum'],$value['unit_price'],$endtime,$status);
                }

                $tr->commit();
            } catch (Exception $e) {
                $tr->rollBack();
            }
            if($result)
            {
                Yii::success("创建套餐成功",Yii::app()->createUrl('../product/package'),"3");die;
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
        $modelid = Yii::app()->request->getParam('modelid');
        if(Yii::app()->request->isAjaxRequest && $modelid)
        {
            $modelone = CProduct::searchModels_byid($modelid);
            echo $modelone['price'];die;
        }
        $result = CProduct::getcategoryList();
        $this->controller->layout = false;
        $this->controller->render('addpackage',array('result'=>$result));
    }
}