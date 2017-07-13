<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 15:09
 */
class SettingAction extends CAction{
    public function run()
    {

        $this->controller->layout = false;
        $this->controller->render('setting');
    }
}
