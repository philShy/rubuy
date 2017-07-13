<?php
class EditAction extends CAction
{
    public function run()
    {
        $article_id = Yii::app()->request->getParam('id');
        $article_title = Yii::app()->request->getParam('title');
        $introduce = Yii::app()->request->getParam('introduce');
        $author = Yii::app()->request->getParam('author');
        $recommend = Yii::app()->request->getParam('recommend');
        $cate = Yii::app()->request->getParam('cate');
        $content = Yii::app()->request->getParam('content');
        $hit = Yii::app()->request->getParam('hit');
        $thumb = Yii::app()->request->getParam('thumb');
        if($article_id)
        {
            $article_one = CArticle::searchArticle_byid($article_id);
        }
        if($_POST)
        {
            $res=$articleId = CArticle::editArticle($article_id,$article_title,$introduce,$author,$recommend,$cate,$content,$hit,$thumb);
            if($res)
            {
                  Yii::success("修改文章成功",Yii::app()->createUrl('../article/list'),"1");die;
            }
        }
        $cate_arr = CArticle::searchArticle_cate();
        $this->controller->layout = false;
        $this->controller->render('edit',array('article_one'=>$article_one,'cate_arr'=>$cate_arr));
    }
}