<?php
class EditAction extends CAction
{
    public function run()
    {
        $this->controller->layout = false;
        $this->controller->render('edit');
    }
}