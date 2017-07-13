<?php
class CAdmin
{
    //查询订单消息表
    public static function searchOrder_notice()
    {
        $create_time = date('Y-m-d H:i:s',strtotime('-10 seconds'));
        $result = Yii::app()->db->createCommand("SELECT order_id,operat FROM `order_notice` WHERE state=0 ORDER BY create_time DESC ")
        ->bindParam(':create_time',$create_time)->queryAll();
        return $result;
    }
    //改变订单消息通知的状态
    public static function updateNotice($state=1,$create_time='')
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('UPDATE `order_notice` SET state=:state WHERE create_time<:create_time')
        ->bindParam(':create_time',$create_time)->bindParam(':state',$state)->execute();
        return $result;
    }
}