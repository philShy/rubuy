<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 13:49
 */
class Doc_listAction extends CAction{
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
        $doc_id = Yii::app()->request->getParam('doc_id');
        $state = Yii::app()->request->getParam('state');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $param = Yii::app()->request->getParam('param');
        $cate_arr = CSystem::searchDoc_category();

        $doc_arr = CSystem::searchAll_doc();
        $count_all = count($doc_arr);

        foreach($cate_arr as $key=>$value)
        {
            $result = CSystem::searchDoc_bycateid($value['id']);
            $cate_arr[$key]['count'] = count($result);
            $cate_arr[$key]['doc_category_id'] = $value['id'];
        }

        if($param)
        {
            $doc_arr = CSystem::searchAlldoc_bycate($param);
            $count_where = count($doc_arr);
        }else{
            $doc_arr = CSystem::searchAll_doc();
            $count_where = count($doc_arr);
        }
        if($doc_id && $state)
        {
            if($state == 'sure')
            {
                $state = 0;
            }
            $res = CSystem::editDocstate($doc_id,$state);
            echo $res;die;
        }
        if($doc_id && $is_delete)
        {
            $res = CSystem::deleteDoc($doc_id,$is_delete);
            echo $res;die;
        }
        $this->controller->layout = false;
        $this->controller->render('doc_list',array('cate_arr'=>$cate_arr,'doc_arr'=>$doc_arr,'count_all'=>$count_all,'count_where'=>$count_where));
    }
}