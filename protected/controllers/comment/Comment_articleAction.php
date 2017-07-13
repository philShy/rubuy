<?php
class Comment_articleAction extends CAction
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
        $comment_id = Yii::app()->request->getParam('comment_id');
        $state = Yii::app()->request->getParam('state');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $article = Yii::app()->request->getParam('article');
        //$user = Yii::app()->request->getParam('user');
        $datetime = Yii::app()->request->getParam('datetime');
        if($article)
        {
            $article_arr = CArticle::dimArticle($article);
            foreach ($article_arr as $key=>$value)
            {
                $article_arr[$key] = $value['id'];
            }
        }
        if($state)
        {
            if($state == 'sure')
            {
                $state = 0;
            }
            $result = CComment::editArticle_commentstate($comment_id,$state);
            echo $result;die;
        }
        if($is_delete)
        {
            $result = CComment::deleteArticle_comment($comment_id,$is_delete);
            echo $result;die;
        }
        if($article && $datetime)
        {
            $article_comment = CComment::Articlecomment_where($article_arr,$datetime);
        }elseif($article && empty($datetime))
        {
            $article_comment = CComment::Articlecomment_where($article_arr,$datetime);

        }elseif(empty($article) && $datetime)
        {
            $article_comment = CComment::Articlecomment_where($article_arr,$datetime);
        }else{
            $article_comment = CComment::searchArticle_comment();
        }

        $count = count($article_comment);
        $this->controller->layout = false;
        $this->controller->render('comment_article',array('article_comment'=>$article_comment,'count'=>$count));
    }
}