<?php
class ImagesclassAction extends CAction
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
        $name = Yii::app()->request->getParam('name');
        $introduce = Yii::app()->request->getParam('introduce');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $image_id = Yii::app()->request->getParam('image_id');
        $mark = Yii::app()->request->getParam('mark');
        if(Yii::app()->request->isAjaxRequest && $image_id && $is_delete == 0 && empty($mark))
        {
            $result = CImages::editImagestate($image_id,$is_delete);
            echo $result;
            die;
        }
        if(Yii::app()->request->isAjaxRequest && $image_id && $is_delete == 1 && empty($mark))
        {
            $result = CImages::editImagestate($image_id,$is_delete);
            echo $result;
            die;
        }
        if(Yii::app()->request->isAjaxRequest && $image_id && !empty($mark))
        {
            $tr = Yii::app()->db->beginTransaction();
            try {
                $result1 = CImages::delImageclass($image_id);
                $result2 = CImages::delImages($image_id);
                $tr->commit();
            } catch (Exception $e) {
                $tr->rollBack();
            }
            if($result1&&$result2){
                echo 1;
            }
            die;
        }
        if($name && $introduce)
        {
            $result = CImages::addImages($name,$introduce,$is_delete);
            echo $result;die;
        }
        $result = CImages::searchImages();
        $count = count($result);
        $this->controller->layout = false;
        $this->controller->render('imagesclass',array('result'=>$result,'count'=>$count));
    }
}