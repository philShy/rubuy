<?php
/**
 * Class CUser
 * auth @phil
 */
class CUser
{
    //查询所有会员
    public static function searchAlluser($where='')
    {
        $result = Yii::app()->db->createCommand("SELECT a.*,b.receive_province,b.receive_city FROM `user` a LEFT JOIN `user_address` b ON a.id=b.user_id WHERE $where a.is_delete=0 AND b.is_delete=0 AND b.is_default=1")->queryAll();
        return $result;
    }
    //更改用户状态
    public static function editUserstate($user_id,$state)
    {
        $result = Yii::app()->db->createCommand('UPDATE `user` SET state=:state WHERE id=:id')
        ->bindParam(':state',$state)->bindParam(':id',$user_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'user','update');
        return $result;
    }
    //删除用户
    public static function deleteUser($user_id,$is_delete)
    {

        $result = Yii::app()->db->createCommand('UPDATE `user` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$user_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'user','delete');
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

}