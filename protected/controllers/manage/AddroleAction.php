<?php
class AddroleAction extends CAction
{
    public function run()
    {
        $auth_arr0 = CManage::searchAll_auth0();
        $role_name = Yii::app()->request->getParam('role-name');
        $role_introduce = Yii::app()->request->getParam('role-introduce');
        $checkAll = Yii::app()->request->getParam('checkAll');
        $subBox = Yii::app()->request->getParam('subBox');
        $auth_id_arr = array();
        $auth_join_arr = array();
        if($subBox)
        {
            foreach($subBox as $key=>$value)
            {
                foreach($value as $k=>$v)
                {
                    $auth_id_arr[] = $v;
                    $auth = CManage::searchAction($v);
                    $auth_join_arr[] = $auth['contrl'].'/'.$auth['action'];
                }
            }
            $authAll_id_arr = array_merge($checkAll,$auth_id_arr);
            $auth_id = implode(',',$authAll_id_arr);
            $auth_join = 'admin/index,'.implode(',',$auth_join_arr);

            $result = CManage::insertRole($role_name,$auth_id,$auth_join,$role_introduce);
            if($result)
            {
                Yii::success("添加角色成功",Yii::app()->createUrl('manage/role'),"1");die;
            }
        }
        $this->controller->layout = false;
        $this->controller->render('addrole',array('auth_arr0'=>$auth_arr0));
    }
}