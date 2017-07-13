<?php
class Editproduct_imagesAction extends CAction
{
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
        $model_id = Yii::app()->request->getParam('model_id');
        $model_number = Yii::app()->request->getParam('model_number');
        $modelid = Yii::app()->request->getParam('modelid');
        $picid = Yii::app()->request->getParam('picid');
        $sort = Yii::app()->request->getParam('sort');
        $mark = Yii::app()->request->getParam('mark');
        if($id){
            if($_FILES['proImg'])
            {
                $img_url = 'http://randn.net/images/product/';
                $img_path = 'images/product';
                $path = CUploadimg::uploadFile($img_path);
                if($path)
                {
                    $imgid =  CProduct::searchImg($id);

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
                            $re[] = CProduct::addImg($img_url.$value['name'],$images_class_id = 1,$id,$sort);
                        }
                        if($re)
                        {
                            Yii::success("修改成功",Yii::app()->createUrl('../images/image_product'),"1");die;
                        }
                    }else{
                        foreach($path as $key=>$value)
                        {
                            $sort = $key+1;
                            $re[] = CProduct::addImg($value['name'],$images_class_id = 1,$id,$sort);
                        }
                        if($re)
                        {
                            Yii::success("修改成功",Yii::app()->createUrl('../images/image_product'),"1");die;
                        }
                    }

                }
            }

        }
        if($model_id){
            $product_images = CImages::searchImagecate($model_id);
        }
        if($mark=='del' && $modelid && $picid)
        {
            $img =  CImages::searchimages_Bypicid($picid);
            $result = CImages::delimages_Bypicid($picid);
            if (file_exists("images/product/" .$img['images_url'])) {
                unlink("images/product/" .$img['images_url']);
            }
            if (file_exists("images/product_50/50" .$img['images_url'])) {
                unlink("images/product_50/50" .$img['images_url']);
            }
            if($result)
            {
                $maxArr = CImages::searchimages_Bymodelid($modelid);
                if($img['sort']<$maxArr)
                {
                    $imgs = CImages::searchimages_Bywhere($modelid,$sort);
                    foreach ($imgs as $_img)
                    {
                        $re[] = CImages::updateimages_Bymodelid($_img['id'],$_img['sort']-1);
                    }
                    var_dump($re);die;
                }
            }
        }
        if($mark=='moveup' && $modelid && $picid && $sort)
        {
            $upsort=$sort-1;
            $upid = CImages::searchupimages($modelid,$upsort)['id'];
            $new1 = CImages::updateimagesSort($picid,$upsort);
            $new2 = CImages::updateimagesSort($upid,$sort);
            if($new1 && $new2)
            {
                 echo 1;die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('editproduct_images',array('model_id'=>$model_id,'model_number'=>$model_number,'product_images'=>$product_images));
    }
}