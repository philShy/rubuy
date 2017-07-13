<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 13:49
 */
class Doc_categoryAction extends CAction{
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
        $doc_cateid = Yii::app()->request->getParam('doc_cateid');
        $doc_cate_id = Yii::app()->request->getParam('doc_cate_id');
        $category_id = Yii::app()->request->getParam('category_id');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $cate_name = Yii::app()->request->getParam('cate_name');
        $cate_sort = Yii::app()->request->getParam('cate_sort');
        $introduce = Yii::app()->request->getParam('introduce');
        if($doc_cateid)
        {
            $result = CSystem::searchCategor_byid($doc_cateid);
            echo json_encode($result,true);die;
        }
        if($doc_cate_id)
        {
            $result = CSystem::editcategory_byid($doc_cate_id,$cate_name,$introduce,$cate_sort);
            echo $result;die;
        }
        if($cate_name && empty($doc_cateid) && empty($doc_cate_id))
        {
            $result =CSystem::addDoc_category($cate_name,$cate_sort,$introduce);
            echo $result;
        }
        if($category_id&&$is_delete)
        {
            $result =CSystem::deletedoc_category($category_id,$is_delete);
            echo $result;die;
        }
        $doc_category = CSystem::searchDoc_category ();
        $this->controller->layout = false;
        $this->controller->render('doc_category',array('doc_category'=>$doc_category));
    }
}