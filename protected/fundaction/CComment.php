<?php
/**
 * Class CComment
 * auth @phil
 */
class CComment
{
    //查询所有文章评论
    public static function searchArticle_comment($where='')
    {
        $result = Yii::app()->db->createCommand("SELECT a.*,b.name,c.title FROM `article_comment` a LEFT JOIN `user` b ON a.user_id=b.id LEFT JOIN `article` c ON a.article_id = c.id WHERE $where a.is_delete=0 AND c.is_delete=0")->queryAll();
        return $result;
    }
    //更改文章评论状态
    public static function editArticle_commentstate($comment_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `article_comment` SET state=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$comment_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_comment','update');
        return $result;
    }
    //删除文章评论
    public static function deleteArticle_comment($comment_id,$is_delete)
    {

        $result = Yii::app()->db->createCommand('UPDATE `article_comment` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$comment_id)->execute();
        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'article_comment','delete');
        return $result;
    }
    //查询单个用户信息
    public static function seachOneuser($id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user` WHERE id=:id")->bindParam(':id',$id)->queryRow();
        return $result;
    }

    //查询收件人信息
    public static function searchReceiver($user_id)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `user_address` WHERE user_id=:user_id AND is_default=1")
            ->bindParam(':user_id',$user_id)->queryRow();
        return $result;
    }
    //查询符合条件的评论
    public static function Articlecomment_where($article_arr,$datetime)
    {
        $result = Yii::app()->getDb()->createCommand();
        $result->select('a.*,b.name,c.title');
        $result->from('article_comment a');
        $result->join('user b','a.user_id=b.id');
        $result->join('article c','a.article_id=c.id');
        if($article_arr)
        {
            $result->andWhere(array('in','a.article_id', $article_arr));
        }
        if($datetime)
        {
            $result->andWhere("a.create_time<'$datetime'");
        }
        $result ->andWhere('c.is_delete=0');
        $list =$result ->queryAll();
        return $list;
    }

}