<?php
class ImagesController extends Controller{

    public function actions(){
        return array(
            'list'=>'application.controllers.images.ListAction',
            'imagesclass'=>'application.controllers.images.ImagesclassAction',
            'editimagesclass'=>'application.controllers.images.EditimagesclassAction',
            'image_product'=>'application.controllers.images.Image_productAction',
            'editproduct_images'=>'application.controllers.images.Editproduct_imagesAction',
            'image_brand'=>'application.controllers.images.Image_brandAction',
        );
    }
}