<?php
class CovermanagementAction extends CAction
{
    public function run()
    {
        $this->controller->layout = false;
        $this->controller->render('covermanagement');
    }
}