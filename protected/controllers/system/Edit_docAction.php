<?php
class Edit_docAction extends CAction
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
        $doc_id = Yii::app()->request->getParam('id');
        $doc_title = Yii::app()->request->getParam('title');
        $introduce = Yii::app()->request->getParam('introduce');
        $author = Yii::app()->request->getParam('author');
        $recommend = Yii::app()->request->getParam('recommend');
        $cate = Yii::app()->request->getParam('cate');
        $content = Yii::app()->request->getParam('content');
        $hit = Yii::app()->request->getParam('hit');
        $thumb = Yii::app()->request->getParam('thumb');
        if($doc_id)
        {
            $doc_one = CSystem::searchDoc_byid($doc_id);
        }
        if($_POST)
        {
            $res=$articleId = CSystem::editDoc($doc_id,$doc_title,$introduce,$author,$recommend,$cate,$content,$hit,$thumb);
            if($res)
            {
                Yii::success("修改文章成功",Yii::app()->createUrl('../system/doc_list'),"1");die;
            }
        }
        $cate_arr = CSystem::searchDoc_category();
        $this->controller->layout = false;
        $this->controller->render('edit_doc',array('doc_one'=>$doc_one,'cate_arr'=>$cate_arr));
    }
}