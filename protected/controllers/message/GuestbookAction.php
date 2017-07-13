<?php
class GuestbookAction extends CAction{
    public function run()
    {
        $this->controller->layout = false;
        $this->controller->render('guestbook');
    }
}