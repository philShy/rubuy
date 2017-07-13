<?php
/**
 * Class CArticle
 * @auth phil
 */
class CArticle
{
    //查找所有文章类别
    public static function searchArticle_cate()
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article_category` WHERE is_delete=0 ')->queryAll();
        return $result;
    }
    //添加文章类别
    public static function addArticle_cate($name,$cate_sort,$introduce)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('INSERT INTO `article_category` (`name`,`sort`,`introduce`,`create_time`)VALUES (:name,:sort,:introduce,:create_time)')
        ->bindValue(':name',$name)->bindValue(':sort',$cate_sort)->bindValue(':introduce',$introduce)->bindValue(':create_time',$create_time)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','insert');
        return $result;
    }
    //添加文章
    public static function addArticle($article_title,$introduce,$author='',$recommend=0,$cate,$content,$hit=0,$thumb=0)
    {
        $create_time = date('Y-m-d H:i:s',time());
        Yii::app()->db->createCommand('INSERT INTO `article` (`title`,`introduce`,`author`,`is_recommend`,`article_category_id`,`content`,`create_time`,`hit`,`thumb`)VALUES (:title,:introduce,:author,:recommend,:article_category_id,:content,:create_time,:hit,:thumb)')
        ->bindValue(':title',$article_title)->bindValue(':introduce',$introduce)->bindValue(':author',$author)
        ->bindValue(':recommend',$recommend)->bindValue(':article_category_id',$cate)->bindValue(':content',$content)
        ->bindValue(':hit',$hit)->bindValue(':thumb',$thumb)->bindValue(':create_time',$create_time)->execute();
        $eid = Yii::app()->db->getLastInsertID();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','insert');
        return $eid;
    }
    //添加文章图片
    public static function addImg($path,$images_class_id,$articleId,$sort)
    {
        $result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_url`,`images_class_id`,`article_id`,`sort`) VALUES (:path,:images_class_id,:article_id,:sort)')->bindParam(':sort',$sort)->bindParam(':images_class_id',$images_class_id)->bindParam(':path',$path)->bindParam(':article_id',$articleId)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
        return $result;
    }
    //添加文章封面图
    public static function addArticleimg($desFilePath,$article_id,$images_class_id=4,$article_cover=1)
    {
        $result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_url`,`article_id`,`images_class_id`,`article_cover`) VALUES (:images_url,:article_id,:images_class_id,:article_cover)')
            ->bindParam(':images_url',$desFilePath)->bindParam(':article_id',$article_id)
            ->bindParam(':images_class_id',$images_class_id)->bindParam(':article_cover',$article_cover)->execute();
        if($result)
        {
            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
        }
        return $result;
    }
    public static function addBrandlogo($desFilePath,$brand_id,$images_class_id=2)
    {

    }
    //查找所有文章
    public static function searchAll_article()
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article` WHERE is_delete=0')->queryAll();
        return $result;
    }
    public static function searchAllarticle_bycate($param)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article` WHERE article_category_id=:article_category_id AND is_delete=0')
        ->bindValue(':article_category_id',$param)->queryAll();
        return $result;
    }

    //查找不同类别下的文章通过文章类别id
    public static function searchArticle_bycateid($cate_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article` WHERE is_delete=0 AND article_category_id=:article_category_id')
        ->bindValue(':article_category_id',$cate_id)->queryAll();
        return $result;
    }
    //修改文章状态
    public static function editArticlestate($article_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article` SET states=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$article_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','update');
        return $result;
    }
    //删除文章
    public static function deleteArticle($article_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$article_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','update');
        return $result;
    }
    //通过ID查找文章信息
    public static function searchArticle_byid($article_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article` WHERE id=:id AND is_delete=0')
        ->bindparam(':id',$article_id)->queryRow();
        return $result;
    }
    //通过文章类别ID删除文章类别
    public static function deleteArticle_category($category_id,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article_category` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$category_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','delete');
        return $result;
    }
    public static function searchCategor_byid($article_cateid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `article_category` WHERE id=:id AND is_delete=0')
        ->bindparam(':id',$article_cateid)->queryRow();
        return $result;
    }
    //修改文章类别
    public static function editcategory_byid($article_cate_id,$cate_name,$introduce,$cate_sort)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article_category` SET name=:name,introduce=:introduce,sort=:sort WHERE id=:id')
        ->bindParam(':name',$cate_name)->bindParam(':introduce',$introduce)
        ->bindParam(':sort',$cate_sort)->bindParam(':id',$article_cate_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_category','update');
        return $result;
    }
    //修改文章
    public static function editArticle($article_id,$article_title,$introduce,$author,$recommend,$cate,$content,$hit,$thumb)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `article` SET title=:title,introduce=:introduce,author=:author,is_recommend=:is_recommend,article_category_id=:article_category_id,content=:content,create_time=:create_time,hit=:hit,thumb=:thumb WHERE id=:id')
        ->bindParam(':title',$article_title)->bindParam(':introduce',$introduce)->bindParam(':author',$author)
        ->bindParam(':is_recommend',$recommend)->bindParam(':article_category_id',$cate)->bindParam(':content',$content)
        ->bindParam(':create_time',$create_time)->bindParam(':id',$article_id)
        ->bindParam(':hit',$hit)->bindParam(':thumb',$thumb)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article','update');
        return $result;
    }
    //模糊查询文章标题id
    public static function dimArticle($article_title)
    {
        $result = Yii::app()->db->createCommand()->select('id')->from('article')->where(array('like','title',"%$article_title%"))->queryAll();
        return $result;
    }
}