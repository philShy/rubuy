<?php
class RefunddetailAction extends CAction{
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
        $order_id=Yii::app()->request->getParam('order_id');
        $pid=Yii::app()->request->getParam('pid');
        $orderid=Yii::app()->request->getParam('orderid');
        $refund_pid=Yii::app()->request->getParam('refund_pid');
        $state=Yii::app()->request->getParam('state');
        $reply=Yii::app()->request->getParam('reply');
        if(empty($state) && $order_id && $pid)
        {
            $refundDetail = CTransaction::refundDetail($order_id,$pid);
        }else if($state==1)
        {
            $detail_state=5;
            $res_refund = CTransaction::editRefund_state($state,$reply='',$orderid,$refund_pid);
            $res_detail = CTransaction::editDetail_state($detail_state,$orderid,$refund_pid);
            if($res_detail && $res_refund)
            {
                echo 1;die;
            }else{
                echo 2;die;
            }

        }else if($state == 2)
        {
            $res_refund = CTransaction::editRefund_state($state,$reply,$orderid,$refund_pid);
            if($res_refund && $reply)
            {
                echo 1;die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('refunddetail',array('refundDetail'=>$refundDetail));
    }
}