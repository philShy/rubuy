<?php
class FeedbackAction extends CAction{
    public function run()
    {
        $this->controller->layout = false;
        $this->controller->render('feedback');
    }
}