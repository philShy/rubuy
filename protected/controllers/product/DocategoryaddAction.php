<?php
class DocategoryaddAction extends CAction{
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
        $pth = Yii::app()->request->getParam('pth');
        $id = Yii::app()->request->getParam('id');
        $sort = Yii::app()->request->getParam('sort');
        $childName = Yii::app()->request->getParam('childName');
        $childSort = Yii::app()->request->getParam('childSort');

        if($childName)
        {
            $result = CProduct::addCategory($childName,$childSort,$id,$pth);
            if($result)
            {
                $this->controller->layout = false;
                $this->controller->render('category',array('result'=>$result));
                exit;
            }
        }
        $result = CProduct::editcategory($id,$sort);
        if($result)
        {
            $this->controller->layout = false;
            header('Location:http://rubuy.cn');
        }

    }
}