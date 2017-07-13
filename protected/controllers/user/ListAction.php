<?php
class ListAction extends CAction{
    public function run()
    {
        $user_id = Yii::app()->request->getParam('user_id');
        $state = Yii::app()->request->getParam('state');
        $is_delete = Yii::app()->request->getParam('is_delete');
        $combination = Yii::app()->request->getParam('combination');
        $datetime = Yii::app()->request->getParam('datetime');
        if($combination)
        {
            $combination = trim($combination);
        }
        if($datetime)
        {
            $datetime = trim($datetime);
        }
        $user_arr = CUser::searchAlluser();
        if($user_id && $state)
        {
            if($state == 'sure')
            {
                $state = 0;
            }
            $result = CUser::editUserstate($user_id,$state);
            echo $result;die;
        }
        if($user_id && $is_delete)
        {
            $result = CUser::deleteUser($user_id,$is_delete);
            echo $result;die;
        }
        if($combination && empty($datetime))
        {
            if(preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$combination))
            {
                $where = "a.email = '$combination' AND";
                $user_arr = CUser::searchAlluser($where);

            }else if(preg_match("/^1[34578]{1}\d{9}$/",$combination))
            {
                $where = "a.phone = '$combination' AND";
                $user_arr = CUser::searchAlluser($where);
            }else{
                $where = "a.name = '$combination' AND";
                $user_arr = CUser::searchAlluser($where);
            }
        }
        if($combination && $datetime)
        {
            if(preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$combination))
            {
                $where = "a.email = '$combination' AND a.create_time<'$datetime'";
                $user_arr = CUser::searchAlluser($where);
            }else if(preg_match("/^1[34578]{1}\d{9}$/",$combination))
            {
                $where = "a.phone = '$combination' a.create_time<'$datetime'";
                $user_arr = CUser::searchAlluser($where);
            }else{
                $where = "a.name = '$combination' a.create_time<'$datetime'";
                $user_arr = CUser::searchAlluser($where);
            }
        }
        if(empty($combination) && $datetime)
        {
            $where = "a.create_time<'$datetime' AND";
            $user_arr = CUser::searchAlluser($where);
        }

        $count = count($user_arr);
        $this->controller->layout = false;
        $this->controller->render('list',array('user_arr'=>$user_arr,'count'=>$count));
    }
}