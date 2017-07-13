<?php
class EditimagesclassAction extends CAction{
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
        $class_id = Yii::app()->request->getParam('class_id');
        $name = Yii::app()->request->getParam('name');
        $introduce = Yii::app()->request->getParam('introduce');
        $is_delete = Yii::app()->request->getParam('is_delete');
        if($id)
        {
            $result = CImages::searchImage_byid($id);
            $count = count($result);
        }
        if($class_id)
        {
            $result = CImages::editImage($class_id,$name,$introduce,$is_delete);
            if($result)
            {
                Yii::success("修改成功",Yii::app()->createUrl('../images/imagesclass'),"1");die;
            }
            $count = count($result);
        }
        $this->controller->layout = false;
        $this->controller->render('editimagesclass',array('result'=>$result,'count'=>$count));
    }
}