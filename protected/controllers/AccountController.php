<?php
class AccountController extends Controller{

    public function actions(){
        return array(
            'covermanagement'=>'application.controllers.account.CovermanagementAction',
            'paymentmethod'=>'application.controllers.account.PaymentmethodAction',
            'paymentconfigure'=>'application.controllers.account.PaymentconfigureAction',

        );
    }
}