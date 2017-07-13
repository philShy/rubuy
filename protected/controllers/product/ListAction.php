<?php
class ListAction extends CAction{
    public function run()
    {
        $action = $this->getId();
        $controller = Yii::app()->controller->id;
        $the_join = $controller.'/'.$action;
        $userid = Yii::app()->user->id;
        $auth_arr = CManage::searchAuth_Byadminid($userid);
        $auth_join = array_filter(explode(',',$auth_arr['auth_join']));
        if(!empty($auth_join))
        {
            if(!in_array($the_join,$auth_join))
            {

                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }else{
            if($auth_arr['role_id'] != 1)
            {
                Yii::error("没有访问权限",Yii::app()->createUrl('home/index'),"1");die;
            }
        }
        $searchCate = Yii::app()->request->getParam('cate');
        $searchBrand = Yii::app()->request->getParam('brand');
        $searchName = Yii::app()->request->getParam('searchName');
        $searchDate = Yii::app()->request->getParam('searchDate');
        $is_publish =Yii::app()->request->getParam('is_publish');
        $id =Yii::app()->request->getParam('goods_id');

        if($id)
        {
                if($is_publish == 1)
                {
                        $result = CProduct::edit_Goodsmodel($id,$is_publish);

                        echo $result;

                }
                if($is_publish == 0)
                {
                        $result = CProduct::edit_Goodsmodel($id,$is_publish);
                        echo $result;
                }
                die;
        }
        if($searchCate && (!empty($searchBrand) || !empty($searchName) || !empty($searchDate)) )
        {
            $sql1 = "A.cate = $searchCate AND";
        }else if($searchCate && empty($searchBrand) && empty($searchName) && empty($searchDate)){
            $sql1 = "A.cate = $searchCate";
        }else{
            $sql1 = "";
        }
        if($searchBrand && (!empty($searchName) || !empty($searchDate)))
        {
            $sql2 = "A.brand = $searchBrand AND";
        }else if($searchBrand && empty($searchName) && empty($searchDate)){
            $sql2 = "A.brand = $searchBrand";
        }else{
            $sql2 = '';
        }
        if($searchName && !empty($searchDate))
        {
            $sql3 = "A.name LIKE '%$searchName%' AND";
        }else if($searchName && empty($searchDate)){
            $sql3 = "A.name LIKE '%$searchName%'";
        }else{
            $sql3 = "";
        }
        if($searchDate)
        {
            $sql4 = "A.create_time >$searchDate";
        }else{
            $sql4 = '';
        }
        if($searchName || $searchCate || $searchBrand || $searchDate)
        {
                $searchArr = CProduct::search_Bywhere($sql1,$sql2,$sql3,$sql4);
                $goods_num = count($searchArr);

        }elseif(empty($searchCate)   && empty($searchBrand) && empty($searchName) && empty($searchDate)){
                $searchArr = CProduct::searchGoodsmodelall();
                $goods_num = count($searchArr);
        }
        $catearr = CProduct::searchCateall();
        $brandarr = CProduct::searchBrandall();
        $this->controller->layout = false;
        $this->controller->render('list',array('result'=>$searchArr,'goods_num' =>$goods_num ,'catearr'=>$catearr,'brandarr'=>$brandarr));
    }
}