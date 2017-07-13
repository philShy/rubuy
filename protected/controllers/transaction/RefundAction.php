<?php
class RefundAction extends CAction{
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
        $state = Yii::app()->request->getParam('state');
        $orderid=Yii::app()->request->getParam('orderid');
        $pid=Yii::app()->request->getParam('pid');
        if($state ==1 && $pid)
        {
            $detail_state=5;
            $res_refund = CTransaction::editRefund_state($state,$orderid,$pid);
            $res_detail = CTransaction::editDetail_state($detail_state,$orderid,$pid);
            if($res_detail && $res_refund)
            {
                echo 1;
            }else{
                echo 2;
            }
            die;
        }
        $refund_arr = CTransaction::refund();
        $this->controller->layout = false;
        $this->controller->render('refund',array('refund_arr'=>$refund_arr));
    }
}