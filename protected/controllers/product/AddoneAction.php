<?php
class AddoneAction extends CAction{
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
        $goods_id = Yii::app()->request->getParam('goods_id');
        $cate_id = Yii::app()->request->getParam('cate_id');
        $cateid = CProduct::foo($cate_id);
        $title = Yii::app()->request->getParam('title');
        $goods_list = Yii::app()->request->getParam('goods_list');
        $model_number = Yii::app()->request->getParam('model_number');
        $stock = Yii::app()->request->getParam('stock');
        $price = Yii::app()->request->getParam('price');
        $preferential_price = Yii::app()->request->getParam('preferential_price');
        $weights = Yii::app()->request->getParam('weights');
        $sizes = Yii::app()->request->getParam('sizes');
        $colors = Yii::app()->request->getParam('colors');
        $associated = Yii::app()->request->getParam('associated');
        $after_sales = Yii::app()->request->getParam('after_sales');
        $is_publish = Yii::app()->request->getParam('is_publish');
        $is_preferential = Yii::app()->request->getParam('is_preferential');
        $in_storage = Yii::app()->request->getParam('in_storage');
        $jssn = Yii::app()->request->getParam('jssn');

        if($goods_id)
        {
            $sort = CProduct::countModel($goods_id)['sort'];
        }
        if($_POST)
        {
            $img_url = Yii::app()->request->hostInfo.'/images/product/';
            $img_path = 'images/product';
            $path = CUploadimg::uploadFile($img_path);
            if(empty($path))
            {
                Yii::error("请选择图片",Yii::app()->request->urlReferrer,"1");die;
            }

            $modelId = CProduct::addgoodsModel($goods_id,$title,$goods_list,$model_number,$stock,$price,$preferential_price,$weights,$sizes,$colors,$is_publish,$is_preferential,$in_storage,$associated,$after_sales,$cateid,$sort);

            if($modelId)
            {
                if(!empty($jssn))
                {
                    $json_arr = explode('`',$jssn);
                    if(count($json_arr)>=1)
                    {
                        foreach($json_arr as $k1=>$v1)
                        {
                            $td_one = json_decode($v1,true)['type'];
                            $td_two = json_encode(json_decode($v1,true)['prop']);

                            CProduct::addSpecification_packing($modelId,$td_one,$td_two);
                        }
                    }
                }
                foreach( $path as $k=>$v)
                {
                    $sort=$k+1;
                    CProduct::addImg($img_url.$v['name'],$images_class_id = 1,$modelId,$sort);
                }
                Yii::success("添加商品成功",Yii::app()->createUrl('product/addone'),"1");die;
            }
        }
        $modelarr = CProduct::searchModelall();
        $this->controller->layout = false;
        $this->controller->render('addone',array('modelarr'=>$modelarr,'goods_id'=>$goods_id));
    }
}