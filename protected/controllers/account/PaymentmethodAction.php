<?php
class PaymentmethodAction extends CAction
{
    public function run()
    {
        $this->controller->layout = false;
        $this->controller->render('paymentmethod');
    }
}