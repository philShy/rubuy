<?php
class AddAction extends CAction{
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
        $arr['title'] = Yii::app()->request->getParam('title');
        $arr['goods_list'] = Yii::app()->request->getParam('goods_list');
        $arr['model_number'] = Yii::app()->request->getParam('model_number');
        $arr['stock'] = Yii::app()->request->getParam('stock');
        $arr['price'] = Yii::app()->request->getParam('price');
        $arr['preferential_price'] = Yii::app()->request->getParam('preferential_price');
        $arr['jssn'] = Yii::app()->request->getParam('jssn');
        $arr['associated'] = Yii::app()->request->getParam('associated');
        $arr['after_sales'] = Yii::app()->request->getParam('after_sales');
        $arr['create_time'] = Yii::app()->request->getParam('create_time')?str_replace("/","-",Yii::app()->request->getParam('create_time')):date('Y-m-d H:i:s',time());
        $arr['mark'] = Yii::app()->request->getParam('mark');
        $arr['weights'] = Yii::app()->request->getParam('weights');
        $arr['sizes'] = Yii::app()->request->getParam('sizes');
        $arr['colors'] = Yii::app()->request->getParam('colors');
        $mod = array();
        //交换数组键值
        if (!empty($arr['model_number']))
        {
            $length = count($arr['model_number']);
            $key=0;
            for ($i = 0; $i < $length; $i++)
            {
                if (!empty($arr['model_number'][$i])&&!empty($arr['title'][$i]))
                {
                    $mod[$key]['title'] = $arr['title'][$i];
                    $mod[$key]['goods_list'] = $arr['goods_list'][$i];
                    $mod[$key]['model_number'] = $arr['model_number'][$i];
                    $mod[$key]['stock'] = $arr['stock'][$i];
                    $mod[$key]['price'] = $arr['price'][$i];
                    $mod[$key]['preferential_price'] = $arr['preferential_price'][$i];
                    $mod[$key]['jssn'] = $arr['jssn'][$i];
                    $mod[$key]['associated'] = $arr['associated'][$i];
                    $mod[$key]['after_sales'] = $arr['after_sales'][$i];
                    $mod[$key]['weights'] = $arr['weights'][$i];
                    $mod[$key]['sizes'] = $arr['sizes'][$i];
                    $mod[$key]['colors'] = $arr['colors'][$i];
                    $mod[$key]['mark'] = $arr['mark'][$i];

                    $key++;
                }
            }
        }

        $name = Yii::app()->request->getParam('name');
        $cate = Yii::app()->request->getParam('cate');
        $brand = Yii::app()->request->getParam('brand');
        $business_men = Yii::app()->request->getParam('business_men');
        $create_time = Yii::app()->request->getParam('create_time')?str_replace("/","-",Yii::app()->request->getParam('create_time')):date('Y-m-d H:i:s',time());
        $manual = Yii::app()->request->getParam('manual');
        $detail_introduce = Yii::app()->request->getParam('detail_introduce');
        $is_comments = Yii::app()->request->getParam('is_comments');

        if($name && $cate && $brand)
        {
            if(empty($arr['jssn']))
            {
                Yii::error("请填写规格参数",Yii::app()->createUrl('product/list'),"1");die;
            }
            //类型表插入商品类型
            /*$transaction= Yii::app()->db->beginTransaction();//创建事务
            try{  */    $img_url = Yii::app()->request->hostInfo.'/images/product/';
            $img_path = 'images/product';
            $file_url = Yii::app()->request->hostInfo.'/images/uploadsfile/';
            $path = CUploadimg::uploadFiles($img_path);
            $goods_pdf = CUploadimg::uploadDown();
            if(empty($path))
            {
                Yii::error("请选择图片",Yii::app()->request->urlReferrer,"3");die;
            }

            if(empty($goods_pdf))
            {
                Yii::error("请选择文件",Yii::app()->request->urlReferrer,"3");die;
            }

            $goodsId = CProduct::addGoods($name,$cate,$business_men,$brand,$create_time,$manual,$detail_introduce,$is_comments);
            if($goodsId)
            {
                foreach($goods_pdf as $key=>$value)
                {
                    CProduct::addPdf($goodsId,$file_url.$value['name'],$key);
                }

                //类型表插入商品类型
                $ee=1;

                foreach($mod as $key=>$value)
                {
                    $mark_str = $value['mark'];
                    $mark=explode(',',$mark_str);

                    $cateid = CProduct::foo($cate);
                    $json_arr = explode('`',$value['jssn']);
                    $modelId = CProduct::addgoodsModel($goodsId,$value['title'],$value['goods_list'],$value['model_number'],$value['stock'],$value['price'],$value['preferential_price'],$value['weights'],$value['sizes'],$value['colors'],$mark[0],$mark[1],$mark[2],$value['associated'],$value['after_sales'],$cateid,$key);

                    if(!empty($json_arr)&&count($json_arr)>=1)
                    {
                        foreach($json_arr as $k1=>$v1)
                        {

                            $td_one = json_decode($v1,true)['type'];
                            $td_two = json_encode(json_decode($v1,true)['prop']);
                            /*var_dump($modelId);
                            var_dump($td_one);
                            var_dump($td_two);
                            echo '<hr>';*/
                            $res1 = CProduct::addSpecification_packing($modelId,$td_one,$td_two);
                        }

                    }
                    foreach( $path[$ee] as $k=>$v)
                    {
                        $sort=$k+1;
                        $res = CProduct::addImg($img_url.$v['name'],$images_class_id = 1,$modelId,$sort);
                    }
                    $ee++;
                }
                if($res)
                {
                    Yii::success("添加商品成功",Yii::app()->createUrl('product/list'),"1");die;
                }
            }


            /*        $transaction->commit();//提交事务会真正的执行数据库操作
            }catch (Exception $e) {
                    $transaction->rollback();//如果操作失败, 数据回滚

            }*/

        }
        $modelarr = CProduct::searchModelall();
        $catearr = CProduct::searchCateall();
        $brandarr = CProduct::searchBrandall();
        $this->controller->layout = false;
        $this->controller->render('add',array('catearr'=>$catearr,'brandarr'=>$brandarr,'modelarr'=>$modelarr));
    }
}