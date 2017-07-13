<?php
/**
 * Specifies the access control rules.
 * This method is used by the 'accessControl' filter.
 * @return array access control rules
 */

class TransactionController extends Controller
{
   /* public function filters(){
        return array('accessControl',);
    }

    public function accessRules(){
        return array(
            array('allow',
                'actions' => array('amounts','orderform','orderhandling','refund','orderdetail','refunddetail'),
                'users' => array('@'),
            ),

            array('deny',
                'users' => array('*'),
            ),
        );
    }*/

    public function actions()
    {
        return array(
            'amounts'=>'application.controllers.transaction.AmountsAction',
            'orderform'=>'application.controllers.transaction.OrderformAction',
            'orderhandling'=>'application.controllers.transaction.OrderhandlingAction',
            'refund'=>'application.controllers.transaction.RefundAction',
            'orderdetail'=>'application.controllers.transaction.OrderdetailAction',
            'refunddetail'=>'application.controllers.transaction.RefunddetailAction',
        );
    }
}