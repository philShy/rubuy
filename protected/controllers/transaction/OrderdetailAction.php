<?php
class OrderdetailAction extends CAction{
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
        $id = Yii::app()->request->getParam('id');
        if($id)
        {
            $orderone = CTransaction::searchOneorder($id);
            /*var_dump($orderone);
            var_dump(json_decode($orderone['goods_details'],true));
            var_dump(json_decode($orderone['invoice'],true));*/
            $orderone['goods_details'] = json_decode($orderone['goods_details'],true);
            $orderone['invoice'] = json_decode($orderone['invoice'],true);

        }

        $this->controller->layout = false;
        $this->controller->render('orderdetail',array('orderone'=>$orderone));
    }
}