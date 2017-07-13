<?php
class ProductController extends Controller{

   /* public function filters()
    {
        return array('accessControl',);
    }
    public function accessRules(){
        return array(
            array('allow',
                'actions' => array('list','brand','category','add','categoryadd','package'),
                'users' => array('@'),
            ),

            array('deny',
                'actions' => array('list','brand','category','add','categoryadd','package'),
                'users' => array('222'),
            ),
        );
    }*/
    public function actions(){
        return array(
            'list'=>'application.controllers.product.ListAction',
            'brand'=>'application.controllers.product.BrandAction',
            'category'=>'application.controllers.product.CategoryAction',
            'add'=>'application.controllers.product.AddAction',
            'categoryadd'=>'application.controllers.product.CategoryaddAction',
            'addbrand'=>'application.controllers.product.AddbrandAction',
            'docategoryadd'=>'application.controllers.product.DocategoryaddAction',
            'package'=>'application.controllers.product.PackageAction',
            'addpackage'=>'application.controllers.product.AddpackageAction',
            'editbrand'=>'application.controllers.product.EditbrandAction',
            'edit'=>'application.controllers.product.EditAction',
            'editpackage'=>'application.controllers.product.EditpackageAction',
            'addone'=>'application.controllers.product.AddoneAction',
        );
    }
}