<?php
class EditbrandAction extends CAction{
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
        $brandid = Yii::app()->request->getParam('id');
        $brandarr = CProduct::searchBrandbyid($brandid);
        $brandname = Yii::app()->request->getParam('brandname');
        $sort = Yii::app()->request->getParam('sort');
        $id = Yii::app()->request->getParam('brandid');
        $state = Yii::app()->request->getParam('state');
        $mark = Yii::app()->request->getParam('mark');
        $brand_id = Yii::app()->request->getParam('brand_id');
        $country = Yii::app()->request->getParam('country');
        $introduce= Yii::app()->request->getParam('introduce');
        $file = $_FILES['file'];
        if(!empty($file['name'])){
            if($id)
            {
                $folder1 = Yii::app()->request->hostInfo.'/images/brand/';
                $result = CProduct::editBrandbyid($id,$brandname,$sort,$country,$introduce,$state);
                CUploadbrandlogo::uploadbrandlogo($id,$images_class_id=2,$folder1);

            }
            die;
        }
        if($mark == 'del'){

            $result = CProduct::delBrandbyid($brand_id);
            echo $result; die;
        }
        if($id){

            $result = CProduct::editBrandbyid($id,$brandname,$sort,$country,$introduce,$state);
            if($result)
            {
                Yii::success("修改成功",Yii::app()->createUrl('product/brand'),"1");die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('editbrand',array('brandarr'=>$brandarr));
    }
}