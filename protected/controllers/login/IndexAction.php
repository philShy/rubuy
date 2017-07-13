<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/2
 * Time: 15:36
 */
class IndexAction extends CAction
{
    public function run()
    {
        if($_POST['LoginForm'])
        {
            $mm=new UserIdentity;
            $mm->authenticate($_POST['LoginForm']);
            $m=Yii::app()->user->login($mm,8640);
            if($m)
            {
                Yii::success("登录成功",Yii::app()->createUrl('admin/index'),"1");die;

            }else{
                Yii::error("登录失败",Yii::app()->createUrl('login/index'),"1");die;
            }
        }

        $this->controller->layout = false;
        $this->controller->render('index');
    }

}