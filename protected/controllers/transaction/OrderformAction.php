<?php
class OrderformAction extends CAction{
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
        $order_id = Yii::app()->request->getParam('order_id');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $logistics_num = Yii::app()->request->getParam('logistics_num');
        $order_arr = CTransaction::searchAllorder($page=1,$size=10,$where='');
        foreach($order_arr as $key=>$value)
        {
            $order_details = json_decode($value['goods_details'],true);
            $invoice_all = json_decode($value['invoice'],true);
            $brand_order = $order_details['goods_model'];
            $meal_order = $order_details['meal'];
            foreach($brand_order as $brand_k=>$brand_v)
            {
                $brand_order[$brand_k] = $brand_v;
            }
            foreach($meal_order as $meal_k=>$meal_v)
            {
                $meal_order[$meal_k] = $meal_v['goods_model_ids'];
                unset($meal_order[$meal_k]['meal']);
                unset($meal_order[$meal_k]['num']);
                unset($meal_order[$meal_k]['goods_model_ids']);
            }
            $order_arr[$key]['invoice'] = $invoice_all;
            $order_arr[$key]['brand_order'] = $brand_order;
            $order_arr[$key]['meal_order'] = $meal_order;
            unset($order_arr[$key]['goods_details']);
        }
        if($logistics_num && $order_id)
        {
            $result = CTransaction::updateOrder($order_id,$logistics_num,$is_send=1);
            echo $result;
            die;
        }
        if($is_delete && $order_id)
        {
            $result = CTransaction::deleteOrder_byid($order_id,$is_delete);
            echo $result;
            die;
        }
        /*foreach($order_arr as $key=>$value)
        {
            //var_dump($value['meal_order']);
            foreach($value['meal_order'] as $meal_k=>$meal_v)
            {
                //var_dump($meal_v);
                foreach($meal_v as $k=>$v)
                {
                    var_dump($v);
                }
            }
        }die;*/

        $this->controller->layout = false;
        $this->controller->render('orderform',array('order_arr'=>$order_arr));
    }
}