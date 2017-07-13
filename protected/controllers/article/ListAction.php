<?php
class ListAction extends CAction
{
    public function run()
    {

        $article_id = Yii::app()->request->getParam('article_id');
        $state = Yii::app()->request->getParam('state');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $param = Yii::app()->request->getParam('param');
        $cate_arr = CArticle::searchArticle_cate();
        $article_arr = CArticle::searchAll_article();
        $count_all = count($article_arr);

        foreach($cate_arr as $key=>$value)
        {
            $result = CArticle::searchArticle_bycateid($value['id']);
            $cate_arr[$key]['count'] = count($result);
            $cate_arr[$key]['article_category_id'] = $value['id'];
        }
        if($param)
        {
            $article_arr = CArticle::searchAllarticle_bycate($param);
            $count_where = count($article_arr);
        }else{
            $article_arr = CArticle::searchAll_article();
            $count_where = count($article_arr);
        }
        if($article_id && $state)
        {
            if($state == 'sure')
            {
                $state = 0;
            }
            $res = CArticle::editArticlestate($article_id,$state);
            echo $res;die;
        }
        if($article_id && $is_delete)
        {
            $res = CArticle::deleteArticle($article_id,$is_delete);
            echo $res;die;
        }
        $this->controller->layout = false;
        $this->controller->render('list',array('cate_arr'=>$cate_arr,'article_arr'=>$article_arr,'count_all'=>$count_all,'count_where'=>$count_where));
    }
}