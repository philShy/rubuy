<?php
class AmountsAction extends CAction{
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
        $code = Yii::app()->request->getParam('code');
        $page = Yii::app()->request->getParam('page');
        $where = Yii::app()->request->getParam('where');
        $starttime = Yii::app()->request->getParam('starttime');
        $endtime = Yii::app()->request->getParam('endtime');
        if(empty($page))
        {
            $page = 1;
        }
        if($where)
        {
            $where = base64_decode($where);
            $success_order = CTransaction::success_order($page,$size=2,$where);
            $amount_arr = CTransaction::searchAmount($where)['sum(a.price*a.num)'];
            $count = CTransaction::searchCount($where)['count(a.id)'];
        }
        else if($code == 1)
        {
            $todayTime = date('Y-m-d',mktime(0,0,0));
            $where = " AND '$todayTime'<b.end_time ";
            $success_order = CTransaction::success_order($page,$size=2,$where);
            $amount_arr = CTransaction::searchAmount($where)['sum(a.price*a.num)'];
            $count = CTransaction::searchCount($where)['count(a.id)'];
        }
        else if($starttime && $endtime)
        {
            $endtime = date('Y-m-d', strtotime ("+1 day", strtotime($endtime)));
            $where = " AND '$starttime'<b.end_time AND b.end_time<'$endtime'";
            $success_order = CTransaction::success_order($page,$size=2,$where);
            $amount_arr = CTransaction::searchAmount($where)['sum(a.price*a.num)'];
            $count = CTransaction::searchCount($where)['count(a.id)'];
        }
        else{

            $success_order = CTransaction::success_order($page,$size=2,$where='');
            $amount_arr = CTransaction::searchAmount($where)['sum(a.price*a.num)'];
            $count = CTransaction::searchCount($where)['count(a.id)'];

        }
        $todayTime = date('Y-m-d',mktime(0,0,0));
        $where_today = " AND '$todayTime'<b.end_time ";
        $amount_today = CTransaction::searchAmount($where_today)['sum(a.price*a.num)'];
        $this->controller->layout = false;
        $this->controller->render('amounts',array('count'=>$count,'success_order'=>$success_order,
            'amount_arr'=>$amount_arr,'amount_today'=>$amount_today,'starttime'=>$starttime,
            'endtime'=>$endtime,'page'=>$page,'where'=>$where,'get_where'=>$get_where));
    }
}