<?php
class IndexAction extends CAction{
    public function run()
    {
        //Yii::app()->user->logout();
        //var_dump(Yii::app()->user->isGuest);die;
        $action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $userid = Yii::app()->user->id;
        $auth_arr = CManage::searchAuth_Byadminid($userid);
        $auth_join = array_filter(explode(',',$auth_arr['auth_join']));
        if($auth_arr['role_id'] == 1)
        {
            $result0 = CManage::searchAdmin_auth();

        }
        elseif(!in_array($the_join,$auth_join))
        {
            Yii::error("没有访问权限",Yii::app()->createUrl('../login/index'),"1");die;
        }
        else{
            $authid_arr = trim($auth_arr['auth_id'],',');
            $result0 = CManage::searchAuth0_Byauthid($authid_arr);
        }
        $code = Yii::app()->request->getParam('code');
        if($code == 1)
        {
            $order_notice = CAdmin::searchOrder_notice();
            $order_notice_arr = array();
            foreach($order_notice as $key=>$value)
            {
                if($value['operat'] == 0)
                {
                    $order_notice_arr[$key] = '订单号：'.'【'.$value['order_id'].'】'.'新下单';
                }
                if($value['operat'] == 1)
                {
                    $order_notice_arr[$key] = '订单号：'.'【'.$value['order_id'].'】'.'已付款';
                }
                if($value['operat'] == 2)
                {
                    $order_notice_arr[$key] = '订单号：'.'【'.$value['order_id'].'】'.'申请退款';
                }
            }

            echo json_encode($order_notice_arr);die;
        }
        elseif($code == 2)
        {
            $res = CAdmin::updateNotice($state=1,$create_time='');
            return $res;die;
        }


        $this->controller->layout = false;
        $this->controller->render("index",array('result0'=>$result0,'authid_arr'=>$authid_arr));
    }
}