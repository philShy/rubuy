<?php
class CategoryaddAction extends CAction{
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
        $pth = Yii::app()->request->getParam('pth');
        $id = Yii::app()->request->getParam('id');
        $sort = Yii::app()->request->getParam('sort');
        $childName = Yii::app()->request->getParam('childName');
        $childSort = Yii::app()->request->getParam('childSort');
        $mark = Yii::app()->request->getParam('mark');
        if(Yii::app()->request->isAjaxRequest && $mark!='del' && $mark!='submit')
        {
            $id =  Yii::app()->request->getParam('id');
            $result = CProduct::getOne($id);
            echo json_encode($result);die;
        }

        if(Yii::app()->request->isAjaxRequest && $mark=='del')
        {

            $result = CProduct::delCategory($id,$pth);
            print_r($result) ;die;
        }

        if(Yii::app()->request->isAjaxRequest && $mark=='submit' && empty($childName))
        {
            $result = CProduct::editCategory($id,$sort,$name);
            echo $result;die;
        }

        if(Yii::app()->request->isAjaxRequest && $mark=='submit' && $childName)
        {
            $result = CProduct::addCategory($childName,$childSort,$id,$pth);
            echo $result;die;
        }

        $result = CProduct::getcategoryList();
        $this->controller->layout = false;
        $this->controller->render('categoryadd',array('result'=>$result));
    }
}