<?php
class EditAction extends CAction{
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
        $id = Yii::app()->request->getParam('id');
        $mark = Yii::app()->request->getParam('mark');
        $delmodeid = Yii::app()->request->getParam('delmodeid');
        $goodsmodelarr = CProduct::searchGoodsmodelbyid($id);
        $goodsmodelid = Yii::app()->request->getParam('goodsmodelid');
        $name = Yii::app()->request->getParam('name');
        $cate = Yii::app()->request->getParam('cate');
        $cateid = CProduct::foo($cate);
        $brand = Yii::app()->request->getParam('brand');
        $business_men = Yii::app()->request->getParam('business_men');
        //$create_time = Yii::app()->request->getParam('create_time');
        $create_time = date("Y-m-d ", time());
        $title = Yii::app()->request->getParam('title');
        $goods_list = Yii::app()->request->getParam('goods_list');
        $model_number = Yii::app()->request->getParam('model_number');
        $stock = Yii::app()->request->getParam('stock');
        $price = Yii::app()->request->getParam('price');
        $preferential_price = Yii::app()->request->getParam('preferential_price');
        $weights = Yii::app()->request->getParam('weights');
        $sizes = Yii::app()->request->getParam('sizes');
        $colors = Yii::app()->request->getParam('colors');
        $is_publish = Yii::app()->request->getParam('is_publish');
        $is_preferential = Yii::app()->request->getParam('is_preferential');
        $in_storage = Yii::app()->request->getParam('in_storage');
        $is_comments = Yii::app()->request->getParam('is_comments');
        $manual = Yii::app()->request->getParam('manual');
        $detail_introduce = Yii::app()->request->getParam('detail_introduce');
        $model_id = Yii::app()->request->getParam('model_id');
        $associated = Yii::app()->request->getParam('associated');
        $after_sales = Yii::app()->request->getParam('after_sales');
        $jssn = Yii::app()->request->getParam('jssn');

        if($delmodeid)
        {
            $del = CProduct::delSpecification_packing($delmodeid);
            echo $del;die;
        }
        if($goodsmodelarr['id']){
            $specification = CProduct::searchSpecification_packing($goodsmodelarr['id']);
            foreach($specification as $k=>$v)
            {
                $aa = json_decode($v['td_two'],true);
                $specification[$k]['prop'] = $aa;
            }
        }
        if($mark)
        {
            $imgs_url = CImages::searchimgs_Bymodelid($model_id);
            $result_pic = CImages::delimages_Bymodelid($model_id);//删除商品图片
            $result = CProduct::delModelbyid($model_id);//删除商品类型*/
            if($result || $result_pic)
            {
                if($imgs_url)
                {
                    foreach($imgs_url as $img)
                    {
                        if (file_exists("images/product/" .$img['images_url'])) {
                            unlink("images/product/" .$img['images_url']);
                        }
                        if (file_exists("images/product_50/50" .$img['images_url'])) {
                            unlink("images/product_50/50" .$img['images_url']);
                        }
                    }
                }
                $data = array('message'=>'删除成功！','code'=>1);
                echo json_encode($data);die;
            }
        }

        if($goodsmodelid)
        {
            $img_url = Yii::app()->request->hostInfo.'/images/product/';
            $file_url = Yii::app()->request->hostInfo.'/images/uploadsfile/';
            if(isset($jssn))
            {
                $json_arr = explode('`',$jssn);
                if(count($json_arr)>=1){
                    foreach($json_arr as $k1=>$v1)
                    {
                        $td_one = json_decode($v1,true)['type'];
                        $td_two = json_encode(json_decode($v1,true)['prop']);
                        $w1 = CProduct::addSpecification_packing($goodsmodelid,$td_one,$td_two);
                    }
                }
            }

            if($_FILES['proImg'])
            {
                $img_path = 'images/product';
                $path = CUploadimg::uploadFile($img_path);
            }
            if($_FILES['down'])
            {
                $goods_pdf = CUploadimg::uploadDown();
            }

            $goodsid = CProduct::searchGoodsbyid($goodsmodelid)['goods_id'];
            if($path)
            {
                $imgid =  CProduct::searchImg($goodsmodelid);
                if(!empty($imgid))
                {
                    foreach($imgid as $k=>$v)
                    {
                        $arr[] = $v['sort'];
                    };
                    $max_id = array_search(max($arr), $arr);
                    foreach($path as $key=>$value)
                    {
                        $sort = $key+$arr[$max_id]+1;
                        CProduct::addImg($value['name'],$images_class_id = 1,$goodsmodelid,$sort);
                    }
                }else
                {
                    foreach($path as $key=>$value)
                    {
                        $sort = $key+1;
                        CProduct::addImg($img_url.$value['name'],$images_class_id = 1,$goodsmodelid,$sort);
                    }
                }

            }
            if($goods_pdf)
            {
                $pdfid =  CProduct::searchPdf($goodsid);
                foreach($pdfid as $k=>$v){
                    $arr[] = $v['sort'];
                };
                $max_id = array_search(max($arr),$arr);
                foreach($goods_pdf as $key=>$value)
                {
                    $sort = $key+$arr[$max_id]+1;
                    CProduct::addPdf($goodsid,$file_url.$value['name'],$sort);
                }
            }

            $w2 = CProduct::editGoodsbyid($goodsid,$name,$cate,$brand,$business_men,$create_time,$manual,$detail_introduce,$create_time, $is_comments);
            $w3 = CProduct::editGoodsmodelbyid($goodsmodelid, $title,$goods_list,$model_number,$stock,$price,$associated,$preferential_price,$weights,$sizes,$colors,$after_sales,$is_publish,$is_preferential,$create_time,$cateid,$in_storage);

            if($w1 || $w2 || $w3)
            {
                Yii::success("修改成功",Yii::app()->createUrl('../product/list'),"1");die;
            }
        }
        $modelarr = CProduct::searchModelall();
        $catearr = CProduct::searchCateall();
        $brandarr = CProduct::searchBrandall();
        $this->controller->layout = false;

        $this->controller->render('edit',array('catearr'=>$catearr,'brandarr'=>$brandarr,'goodsmodelarr'=>$goodsmodelarr,'modelarr'=>$modelarr,'specification'=>$specification));
    }
}