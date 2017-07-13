<?php
class MessageController extends Controller
{
    public function actions()
    {
        return array(
            'guestbook'=>'application.controllers.message.GuestbookAction',
            'feedback'=>'application.controllers.message.FeedbackAction',
        );
    }
}