<?php
class AddAction extends CAction
{
    public function run()
    {
        $article_title = Yii::app()->request->getParam('title');
        $introduce = Yii::app()->request->getParam('introduce');
        $author = Yii::app()->request->getParam('author');
        $recommend = Yii::app()->request->getParam('recommend');
        $cate = Yii::app()->request->getParam('cate');
        $content = Yii::app()->request->getParam('content');
        $hit = Yii::app()->request->getParam('hit');
        $thumb = Yii::app()->request->getParam('thumb');

        if($_POST)
        {
            $articleId = CArticle::addArticle($article_title,$introduce,$author,$recommend,$cate,$content,$hit,$thumb);
            if($_FILES)
            {
                $img_url = Yii::app()->request->hostInfo.'/images/article/';
                $img_path = 'images/article';
                /*$_FILES1['down'] = $_FILES['down'];
                $_FILES2['file'] = $_FILES['file'];
                var_dump($_FILES1);
                var_dump($_FILES2);*/
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
            }
        }
        $cate_arr = CArticle::searchArticle_cate();
        $this->controller->layout = false;
        $this->controller->render('add',array('cate_arr'=>$cate_arr));
    }
}