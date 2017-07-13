<?php
class SortAction extends CAction
{
    public function run()
    {
        $article_cateid = Yii::app()->request->getParam('article_cateid');
        $article_cate_id = Yii::app()->request->getParam('article_cate_id');
        $category_id = Yii::app()->request->getParam('category_id');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $cate_name = Yii::app()->request->getParam('cate_name');
        $cate_sort = Yii::app()->request->getParam('cate_sort');
        $introduce = Yii::app()->request->getParam('introduce');
        if($article_cateid)
        {
            $result = CArticle::searchCategor_byid($article_cateid);
            echo json_encode($result,true);die;
        }
        if($article_cate_id)
        {
            $result = CArticle::editcategory_byid($article_cate_id,$cate_name,$introduce,$cate_sort);
            echo $result;die;
        }
        if($cate_name)
        {
            $result =CArticle::addArticle_cate($cate_name,$cate_sort,$introduce);
            echo $result;
        }
        if($category_id&&$is_delete)
        {
            $result =CArticle::deleteArticle_category($category_id,$is_delete);
            echo $result;die;
        }
        $cate_arr = CArticle::searchArticle_cate();
        $this->controller->layout = false;
        $this->controller->render('sort',array('cate_arr'=>$cate_arr));
    }
}