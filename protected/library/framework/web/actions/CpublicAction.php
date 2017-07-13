<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/6
 * Time: 17:00
 */
abstract class CpublicAction extends CAction{
    public function __construct()
    {
        parent::__construct();
        /*$action = $this->getId();
        $controller = Yii::app()->controller->id;
        echo $controller.'--'.$action;*/
        /*$now_ac = CONTROLLER_NAME.'-'.ACTION_NAME;
        $where['game_admin_id'] = session('admin_id');
        $admin = M('Admin');
        $admin_arr = $admin->where($where)->find();
        $map['role_id'] = $admin_arr['game_role_id'];
        $role = M('Role');
        $role_arr = $role->where($map)->find();
        $m = strpos($role_arr['role_auth_ac'],$now_ac);
        $allow_ac = array('Index-index','Index-login');
        if($m === false && !in_array($now_ac,$allow_ac) && $where['game_admin_id']!=1){
            $this->error('你没有权限访问');
        }*/
    }

}