<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/3
 * Time: 16:01
 */
class Add_docAction extends CAction
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
        /*$article_title = Yii::app()->request->getParam('title');
        $introduce = Yii::app()->request->getParam('introduce');
        $author = Yii::app()->request->getParam('author');
        $recommend = Yii::app()->request->getParam('recommend');
        $cate = Yii::app()->request->getParam('cate');
        $content = Yii::app()->request->getParam('content');
        $hit = Yii::app()->request->getParam('hit');
        $thumb = Yii::app()->request->getParam('thumb');*/
        if($_POST)
        {
            //var_dump($_POST);die;
            $articleId = CSystem::addDoc($_POST['title'],$_POST['introduce'],$_POST['author'],$_POST['recommend'],$_POST['cate'],$_POST['content'],$_POST['hit'],$_POST['thumb']);
            if($articleId)
            {
                Yii::success("添加文章成功",Yii::app()->createUrl('../system/doc_list'),"1");die;
            }
            /*if($_FILES)
            {
                $img_url = Yii::app()->request->hostInfo.'/images/article/';
                $img_path = 'images/article';
                $path = CUploadimg::uploadFile($img_path);
                if($path)
                {
                    foreach($path as $key=>$value)
                    {
                        $sort=$key+1;
                        $res = CArticle::addImg($img_url.$value['name'],$images_class_id = 3,$articleId,$sort);
                    }
                    $article_cover = CUploadarticleimg::uploadarticleimg($articleId,$images_class_id=2,$img_url);
                    if($res&&$article_cover)
                    {
                        Yii::success("添加文章成功",Yii::app()->createUrl('../article/list'),"1");die;
                    }
                }
            }*/
        }
        $cate_arr = CSystem::searchDoc_category();
        $this->controller->layout = false;
        $this->controller->render('add_doc',array('cate_arr'=>$cate_arr));
    }
}