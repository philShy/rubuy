<?php
class PaymentconfigureAction extends CAction
{
    public function run()
    {
        $this->controller->layout = false;
        $this->controller->render('paymentconfigure');
    }
}