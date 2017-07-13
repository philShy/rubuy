<?php
/**
 * @auth Phil
 * @class CTransaction
 */
class CTransaction
{
    //订单查询
    public static function searchAllorder($page=1,$size=2,$where)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order` WHERE $where is_delete=0 ORDER BY id DESC LIMIT :start,:size")
            ->bindValue(':start',(int)($page-1)*$size)
            ->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    public static function searchdDetail_cate($cateid)
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_detail` WHERE cateid=:cateid")
        ->bindParam(':cateid',$cateid)->queryAll();
        return $result;
    }
    public static function searchAlldetail()
    {
        $result = Yii::app()->db->createCommand("SELECT * FROM `order_detail`")->queryAll();
        return $result;
    }
    //单个订单查询
    public static function searchOneorder_detail($order_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `order` WHERE order_id=:order_id')
            ->bindParam(':order_id',$order_id)->queryAll();
        return $result;
    }
    //交易成功订单查询
    public static function success_order($page,$size,$where)
    {
        $result = Yii::app()->db->createCommand("SELECT a.*, b.end_time FROM `order_detail` a LEFT JOIN `order` b ON a.order_id=b.order_id WHERE
        a.state=4 $where ORDER BY a.id DESC LIMIT :start,:size")
        ->bindValue(':start',(int)($page-1)*$size)->bindValue(':size',(int)$size)->queryAll();
        return $result;
    }
    //统计交易金额
    public static function searchAmount($where)
    {
        $result = Yii::app()->db->createCommand("SELECT sum(a.price*a.num) FROM `order_detail` a LEFT JOIN `order` b ON a.order_id=b.order_id WHERE
        a.state=4 $where")->queryRow();
        return $result;
    }
    //统计交易订单数
    public static function searchorderCount($where)
    {
        $result = Yii::app()->db->createCommand("SELECT count(*) FROM `order` $where")->queryRow();
        return $result;
    }
    //统计交易订单(商品)数
    public static function searchCount($where)
    {
        $result = Yii::app()->db->createCommand("SELECT count(a.id) FROM `order_detail` a LEFT JOIN `order` b ON a.order_id=b.order_id WHERE
        a.state=4 $where")->queryRow();
        return $result;
    }
    //订单详情查询
    public static function searchOrderdetail($order_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `order_detail` WHERE order_id=:order_id')->bindParam(':order_id',$order_id)->queryAll();
        return $result;
    }
    //单个订单查询
    public static function searchOneorder($id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `order` WHERE id=:id')->bindParam(':id',$id)->queryRow();
        return $result;
    }
   //订单插入配送方式，物流单号
    public static function updateOrder($orderid,$logistics_num,$is_send=1)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order` SET logistics_num=:logistics_num,is_send=:is_send WHERE id=:id')
        ->bindParam(':logistics_num',$logistics_num)->bindParam(':is_send',$is_send)->bindParam(':id',$orderid)->execute();
        return $result;
    }
    //退款订单查询
    public static function refund()
    {
        $sql = "SELECT a.*,b.*,c.model_number,d.num,d.price,e.name FROM `refund` a
        LEFT JOIN `order` b ON a.order_id=b.order_id
        LEFT JOIN `goods_model` c ON a.refund_pid=c.id
        LEFT JOIN `order_detail` d ON a.order_id =d.order_id
        LEFT JOIN `goods` e ON e.id =c.goods_id WHERE d.state>3 AND d.pid=a.refund_pid";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        return $result;
    }
    //修改退款订单回复
    public static function insertRefund_reply($reply,$orderid,$refund_pid)
    {
        $sql = "INSERT INTO refund (reply) VALUES (:reply) WHERE order_id=:order_id AND refund_pid=:refund_pid";
        $result = Yii::app()->db->createCommand($sql)
        ->bindParam(':reply',$reply)->bindParam(':order_id',$orderid)->bindParam(':refund_pid',$refund_pid)->execute();
        return $result;
    }
    //修改退款订单状态
    public static function editRefund_state($state,$reply='',$orderid,$pid)
    {
        $result = Yii::app()->db->createCommand('UPDATE `refund` SET state=:state,reply=:reply WHERE order_id=:order_id AND refund_pid=:pid')
        ->bindParam(':state',$state)->bindParam(':reply',$reply)->bindParam(':order_id',$orderid)->bindParam(':pid',$pid)->execute();
        return $result;
    }
    //修改订单详情状态
    public static function editDetail_state($detail_state,$orderid,$pid)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order_detail` SET state=:state WHERE order_id=:order_id AND pid=:pid')
            ->bindParam(':state',$detail_state)->bindParam(':order_id',$orderid)->bindParam(':pid',$pid)->execute();
        return $result;
    }
    //退款订单详情
    public static function refundDetail($order_id,$pid)
    {
        $sql = "SELECT a.*,b.*,c.model_number,d.num,d.price,d.pic,e.name FROM `refund` a
        LEFT JOIN `order` b ON a.order_id=b.order_id
        LEFT JOIN `goods_model` c ON a.refund_pid=c.id
        LEFT JOIN `order_detail` d ON a.order_id =d.order_id
        LEFT JOIN `goods` e ON e.id =c.goods_id WHERE d.state>3 AND a.order_id=$order_id AND a.refund_pid=$pid";
        $result = Yii::app()->db->createCommand($sql)->queryRow();
        return $result;
    }

    //删除订单
    public static function deleteOrder_byid($orderid,$is_delete)
    {
        $result = Yii::app()->db->createCommand('UPDATE `order` SET is_delete=:is_delete WHERE id=:id')
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$orderid)->execute();
        return $result;
    }
}