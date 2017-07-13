<?php

/**
 * Class CProduct
 * @author phil
 */
class CProduct
{
      //类别处理
       public static function foo($id) {
               $result = Yii::app()->db->createCommand("SELECT * FROM `goods_classfiy` WHERE id=:id AND is_delete=0")->bindParam(':id',$id)->queryRow();
               if($result['pid'] != 0)
               {
                       return self::foo($result['pid']);
               }
               else{
                       return $result['id'];
               }
        }

        //查找所有类别
        public static function searchCateall($where='')
        {
                $result = Yii::app()->db->createCommand("SELECT * FROM `goods_classfiy` $where WHERE is_delete=0 ORDER BY sort")->queryAll();
                return $result;
        }
        public static function searchCateall1($where='')
        {
            $result = Yii::app()->db->createCommand("SELECT * FROM `goods_classfiy` $where and is_delete=0 ORDER BY sort")->queryAll();
            return $result;
        }
        //通过cateid 查找类别名称
        public static function searchcate_Byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT name FROM `goods_classfiy` WHERE id=:id AND is_delete=0')->bindParam(':id',$id)->queryRow();
                return $result;
        }
        //直接查找所有类别下的所有商品型号
        public static function searchModelalls()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_classfiy` WHERE is_delete=0 ORDER BY sort')->queryAll();
                return $result;
        }
        public static function getcategoryList()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_classfiy` WHERE is_delete=0 ORDER BY sort')->queryAll();
                return $result;
        }
        //修改商品类别
        public static function editCategory($id,$sort,$name)
        {
                $sql = 'UPDATE goods_classfiy SET sort = :sort,name=:name WHERE id = :id';
                $result = Yii::app()->db->createCommand($sql)->bindValue(':id',$id)->bindValue(':sort',$sort)->bindValue(':name',$name)->execute();//返回受影响行数
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','update');
                }
                return $result;
        }
        //添加商品类别
        public static function addCategory($childName,$childSort,$id,$pth)
        {
                $sql = 'insert into goods_classfiy (`name`,`sort`,`pid`) VALUES (:name,:sort,:pid) ';
                Yii::app()->db->createCommand($sql)->bindValue(':name',$childName)->bindValue(':sort',$childSort)->bindValue(':pid',$id)->execute();
                $eid = Yii::app()->db->getLastInsertID();

                if($eid>=10)
                {
                        $childPth = $pth.$eid.',';
                        $sql2 =  'UPDATE goods_classfiy SET pth = :pth,pid=:pid WHERE id = :id';
                        $result = Yii::app()->db->createCommand($sql2)->bindValue(':id',$eid)->bindValue(':pth',$childPth)->bindValue(':pid',$id)->execute();//返回受影响行数

                        return $result;
                }
                elseif($eid<10)
                {
                        $childPth = $pth.'0'.$eid.',';
                        $sql2 =  'UPDATE goods_classfiy SET pth = :pth,pid=:pid WHERE id = :id';
                        $result = Yii::app()->db->createCommand($sql2)->bindValue(':id',$eid)->bindValue(':pth',$childPth)->bindValue(':pid',$id)->execute();//返回受影响行数
                        if($result)
                        {
                            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','update');
                        }
                        return $result;
                }
                else
                {
                        return false;
                }


        }
        //删除商品类别
        public static function delCategory($id,$pth)
        {
                $res = Yii::app()->db->createCommand('SELECT pth FROM `goods_classfiy` ')->queryColumn();
                static $num =0;
                foreach($res as $k=>$v)
                {
                        if(strpos($v,$pth) !== false)
                        {
                            $num = $num+1;
                        }
                }
                if($num<2)
                {
                        $result = Yii::app()->db->createCommand('UPDATE goods_classfiy SET is_delete=1 WHERE id=:id')->bindParam(':id',$id)->execute();
                        if($result)
                        {
                            $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_classfiy','delete');
                        }
                        return $result;
                }
                else
                {
                        return false;
                }

        }
        //得到商品类别的序号(排序)
        public static function getSort($id)
        {
                $result = Yii::app()->db->createCommand('SELECT sort FROM `goods_classfiy` WHERE id=:id')->bindParam(':id',$id)->queryRow();
                return $result['sort'];
        }
        //得到一个商品的ID
        public static function getOne($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_classfiy` WHERE id=:id')->bindParam(':id',$id)->queryRow();
                return $result;
        }
       /**
        * 品牌处理
        */
        //查找品牌
        public static function searchBrandall()
        {
                $result = Yii::app()->db->createCommand('SELECT a.*,b.images_url FROM `brand` a LEFT JOIN `images` b ON a.id = b.brand_id WHERE a.is_delete=0 and b.is_delete=0')->queryAll();
                return $result;
        }
        //按条件查找品牌
        public static function searchbrand_Bywhere($sql1,$sql2)
        {
                $sql = "SELECT a.*,b.images_url FROM `brand` a LEFT JOIN `images` b ON a.id = b.brand_id WHERE $sql1 $sql2 and a.is_delete=0 and b.is_delete=0";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                return $result;
        }
        public static function searchBrand($brandname)
        {
                $result = Yii::app()->db->createCommand('SELECT  FROM `brand` WHERE brandname=:brandname and is_delete=0')->bindParam(':brandname',$brandname)->queryRow();
                return $result;
        }
        public static function searchBrandbyid($brandid)
        {
                $result = Yii::app()->db->createCommand('SELECT a.sort,a.*,b.images_url FROM `brand` a LEFT JOIN images b ON a.id = b.brand_id WHERE brand_id=:brandid')->bindParam(':brandid',$brandid)->queryRow();
                return $result;
        }
        //修改品牌
        public static function editBrandbyid($id,$brandname,$sort,$country,$introduce,$state)
        {
                $create_time = date("Y-m-d H:i:s",time());
                $sql = "UPDATE brand SET brandname=:brandname,sort=:sort,is_delete=:is_delete,create_time=:create_time,country=:country,introduce=:introduce WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)->bindParam(':id',$id)->bindParam(':brandname',$brandname)
                    ->bindParam(':country',$country)->bindParam(':introduce',$introduce)->bindParam(':create_time',$create_time)
                    ->bindParam(':sort',$sort)->bindParam(':is_delete',$state)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','update');
                }
                return $result;
        }
        //修改品牌状态
        public static function editBrandstatebyid($brand_id,$state)
        {
                $sql = "UPDATE brand SET state=:state WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)->bindParam(':id',$brand_id)->bindParam(':state',$state)->execute();
                if($result)
                {
                     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','update');
                }
                return $result;
        }
        //查找品牌序号
        public static function searchSort($sort)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `brand` WHERE sort=:sort')->bindParam(':sort',$sort)->queryRow();
                return $result;
        }
        //添加品牌
        public static function addBrand($brandname,$sort,$address,$discribe)
        {
                $create_time = date("Y-m-d H:i:s",time());
                $result = Yii::app()->db->createCommand('INSERT INTO `brand` (`brandname`,`sort`,`country`,`introduce`,`create_time`)
                VALUES (:brandname,:sort,:country,:introduce,:create_time)')
                ->bindParam(':brandname',$brandname)->bindParam(':sort',$sort)
                ->bindParam(':country',$address)->bindParam(':introduce',$discribe)->bindParam(':create_time',$create_time)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                /*if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','insert');
                }*/

                return $eid;
        }
        //添加品牌logo
        public static function addBrandlogo($desFilePath,$brand_id,$images_class_id=2)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_url`,`brand_id`,`images_class_id`) VALUES (:images_url,:brand_id,:images_class_id)')->bindParam(':images_url',$desFilePath)->bindParam(':brand_id',$brand_id)->bindParam(':images_class_id',$images_class_id)->execute();

            if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
                }
                return $result;
        }

        //修改品牌logo
        public static function editBrandlogo($images_url,$brand_id)
        {
                $result = Yii::app()->db->createCommand('UPDATE images SET images_url = :images_url WHERE brand_id = :brand_id')->bindParam(':images_url',$images_url)->bindParam(':brand_id',$brand_id)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','update');
                }
                return $result;
        }
        //删除品牌
        public static function delBrandbyid($brand_id,$is_delete)
        {
                $result = Yii::app()->db->createCommand('UPDATE brand SET is_delete=:is_delete WHERE id=:id')
                ->bindParam(':is_delete',$is_delete)->bindParam(':id',$brand_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'brand','update');
                }
                return $result;
        }
        //查找所有商品
        public static function searchGoodsall()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods` where is_delete=0')->queryAll();
                return $result;
        }


        //编辑商品状态
        public static function edit_Goods($goods_id ,$is_publish)
        {
                $result = Yii::app()->db->createCommand('UPDATE `goods` SET is_publish = :is_publish WHERE id=:goods_id')->bindParam(':is_publish',$is_publish)->bindParam(':goods_id',$goods_id)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods','update');
                }
                return $result;
        }
        //根据类别ID查找同一类别下的商品
        public static function searchGoods($catid)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods` WHERE cate = :catid and is_delete=0')->bindParam(':catid',$catid) ->queryAll();
                return $result;
        }
        //根据商品ID查找同一商品下的型号
        public static function searchModels($goodsid)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_model` WHERE goods_id = :goods_id AND is_delete=0')->bindParam(':goods_id',$goodsid) ->queryAll();
                return $result;
        }
        public static function searchModelall()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_model` WHERE is_delete=0')->queryAll();
                return $result;
        }
        public static function searchModels_byid($model_id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods_model` WHERE id = :id AND is_delete=0')->bindParam(':id',$model_id) ->queryRow();
                return $result;
        }
        //根据商品ID查找商品
        public static function searchGoods_byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM `goods` WHERE id = :id')->bindParam(':id',$id) ->queryRow();
                return $result;
        }
        //添加商品返回商品ID
        public static function addGoods($name,$cate,$business_men,$brand,$create_time,$manual,$detail_introduce,$is_comments)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `goods` (`name`,`cate`,`business_men`,`brand`,`create_time`, `manual`,`detail_introduce`,`is_comments`)
                VALUES(:name,:cate,:business_men,:brand,:create_time,:manual,:detail_introduce,:is_comments)')
                ->bindParam(':name',$name)->bindParam(':cate',$cate)->bindParam(':business_men',$business_men)
                ->bindParam(':brand',$brand)->bindParam(':create_time',$create_time)->bindParam(':manual',$manual)
                ->bindParam(':detail_introduce',$detail_introduce)->bindParam(':is_comments',$is_comments)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods','insert');
                }
                return $eid;
        }

        //添加商品图片
        public static function addImg($path,$images_class_id,$modelId,$sort)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `images` (`images_url`,`images_class_id`,`model_id`,`sort`) VALUES (:path,:images_class_id,:modelId,:sort)')->bindParam(':sort',$sort)->bindParam(':images_class_id',$images_class_id)->bindParam(':path',$path)->bindParam(':modelId',$modelId)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','insert');
                }
                return $result;
        }
        //添加商品参数
        public static function addSpecification_packing($model_id,$td_one,$td_two)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `specification_packing` (`model_id`,`td_one`,`td_two`) VALUES (:model_id,:td_one,:td_two)')->bindParam(':model_id',$model_id)->bindParam(':td_one',$td_one)->bindParam(':td_two',$td_two)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','insert');
                }
                return $result;
        }
        /*//修改商品参数
        public static function editSpecification_packing($td_one,$td_two,$model_id)
        {
                $sql = 'UPDATE `specification_packing` SET td_one=:td_one,td_two=:td_two WHERE model_id=:model_id';
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':td_one',$td_one)->bindParam(':td_two',$td_two)->bindParam(':model_id',$model_id)->execute();
                return $result;
        }*/
        //删除商品参数
        public static function delSpecification_packing($model_id)
        {
                $result = Yii::app()->db->createCommand('DELETE FROM specification_packing WHERE model_id=:model_id')
                ->bindParam(':model_id',$model_id)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'specification_packing','update');
                }
                return $result;
        }
        //查找商品图片
        public static function searchImg($goodsmodelid)
        {
                $result = Yii::app()->db->createCommand('SELECT sort FROM images WHERE model_id=:model_id AND is_delete=0')->bindParam(':model_id',$goodsmodelid)->queryAll();
                return $result;
        }

        //添加商品pdf
        public static function addPdf($goodsId,$goods_pdf,$sort)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `pdf` (`goods_id`,`url`,`sort`) VALUES (:goods_id,:url,:sort)')->bindParam(':goods_id',$goodsId)->bindParam(':url',$goods_pdf)->bindParam(':sort',$sort)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'pdf','insert');
                }
                return $result;
        }
        //查找商品pdf
        public static function searchPdf($goodsid)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM pdf WHERE goods_id=:goods_id AND is_delete=0')->bindParam(':goods_id',$goodsid)->queryAll();
                return $result;
        }
        //查找商品Specification_packing规格
        public static function searchSpecification_packing($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM specification_packing WHERE model_id=:model_id')->bindParam(':model_id',$id)->queryAll();
                return $result;
        }
        //添加套餐
        public static function addPackage($packagename,$packageprice,$original_price,$discount,$introduce,$endtime,$status)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `meal` (`name`,`price`,`original_price`,`discount`,`introduce`,`create_time`,`is_delete`)
                VALUES (:name,:price,:original_price,:discount,:introduce,:create_time,:is_delete)')
                ->bindParam(':name',$packagename)->bindParam(':price',$packageprice)->bindParam(':original_price',$original_price)->bindParam(':discount',$discount)
                ->bindParam(':introduce',$introduce)->bindParam(':create_time',$endtime)->bindParam(':is_delete',$status)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($result)
                    {
                        CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','insert');
                    }
                return $eid;
        }
        //添加套餐商品
        public static function addPackage_goodsmodel($packageid,$goods_modelid,$quantity,$unit_price,$endtime,$status)
        {
                $result = Yii::app()->db->createCommand('INSERT INTO `meal_goods` (`meal_id`,`good_model_id`,`quantity`,`unit_price`,`create_time`,`is_delete`)
                VALUES (:meal_id,:good_model_id,:quantity,:unit_price,:create_time,:is_delete)')
                ->bindParam(':meal_id',$packageid)->bindParam(':good_model_id',$goods_modelid)->bindParam(':quantity',$quantity)
                ->bindParam(':unit_price',$unit_price)->bindParam(':create_time',$endtime)->bindParam(':is_delete',$status)->execute();
                if($result)
                {
                   CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal_goods','insert');
                }
                return $result;
        }
        //查询商品数量
        public static function countModel($goods_id)
        {
            $result = Yii::app()->db->createCommand('SELECT count(*) as sort FROM goods_model WHERE goods_id=:goods_id AND is_delete=0')->bindParam(':goods_id',$goods_id)->queryRow();
            return $result;
        }
        //编辑套餐
        public static function editPackage($package_id,$packagename,$packageprice,$original_price,$discount,$introduce,$endtime,$status)
        {
                $sql = 'UPDATE meal SET name=:name,price=:price,original_price=:original_price,discount=:discount,introduce=:introduce,create_time=:create_time,is_delete=:is_delete WHERE id=:id';
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':name',$packagename)->bindParam(':price',$packageprice)->bindParam(':original_price',$original_price)->bindParam(':discount',$discount)
                ->bindParam(':introduce',$introduce)->bindParam(':create_time',$endtime)->bindParam(':is_delete',$status)->bindParam(':id',$package_id)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','update');
                }
                return $result;
        }
        //编辑套餐商品
        public static function editPackage_goodsmodel($id,$goods_modelid,$quantity,$unit_price,$endtime,$status)
        {
                $sql = 'UPDATE meal_goods SET good_model_id=:good_model_id,quantity=:quantity,unit_price=:unit_price,create_time=:create_time,is_delete=:is_delete WHERE id=:id';
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':good_model_id',$goods_modelid)->bindParam(':quantity',$quantity)->bindParam(':unit_price',$unit_price)
                ->bindParam(':create_time',$endtime)->bindParam(':is_delete',$status)->bindParam(':id',$id)->execute();
                if($result)
                {
                     CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal_goods','update');
                }
                return $result;
        }
        //查找套餐id
        public static function searchMeal_goodsid($id)
        {
            $result = Yii::app()->db->createCommand('SELECT id FROM meal_goods WHERE meal_id=:id; AND is_delete=0')->bindParam(':id',$id)->queryAll();
            return $result;
        }
        //编辑套餐chanpin状态
        public static function editPackagestate($meal_goods_id,$state)
        {
                $result = Yii::app()->db->createCommand('UPDATE meal_goods SET state=:state WHERE id=:id')
                ->bindParam(':state',$state)->bindParam(':id',$meal_goods_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','update');
                }
                return $result;
        }

        //删除套餐
        /*public static function delPackage($package_id ,$is_delete=1)
        {
                $result = Yii::app()->db->createCommand('UPDATE meal SET is_delete=1 WHERE id=:id')->bindParam(':id',$package_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal','delete');
                }
                return $result;
        }*/
        //同时也要删除套餐商品类型
        public static function delPackage_model($meal_goods_id)
        {
                $result = Yii::app()->db->createCommand('UPDATE meal_goods SET is_delete=1 WHERE id=:id')->bindParam(':id',$meal_goods_id)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'meal_goods','delete');
                }
                return $result;
        }
        //按条件查找套餐
        public static function searchpackage_Bywhere($sql1,$sql2)
        {
                $sql = "SELECT a.*,b.good_model_id,b.quantity FROM meal a LEFT JOIN meal_goods b ON a.id=b.meal_id WHERE
                $sql1 $sql2 and a.is_delete=0 and b.is_delete=0 ;";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                return $result;
        }
       //查找套餐
        public static function searchPackage()
        {
                $result = Yii::app()->db->createCommand('SELECT a.*,b.id as meal_goods_id,b.good_model_id,b.quantity,b.state,b.unit_price,c.price as goods_model_price FROM meal a LEFT JOIN meal_goods b ON a.id=b.meal_id LEFT JOIN goods_model c on b.good_model_id=c.id WHERE a.is_delete=0 and b.is_delete=0 ;')->queryAll();
            //var_dump($result);die;
            return $result;
        }
        //根据套餐id查找套餐
        public static function searchPackage_byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM meal WHERE id=:id and is_delete=0;')->bindParam(':id',$id)->queryRow();
                return $result;
        }
        //根据套餐id查找套餐商品类型
        public static function searchPackagemodel_byid($id)
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM meal_goods WHERE meal_id=:id and is_delete=0;')->bindParam(':id',$id)->queryAll();
                return $result;
        }
        //类型表插入商品类型
        public static function addgoodsModel($goodsId,$title,$goods_list,$model_number,$stock,$price,$preferential_price,$weights,$sizes,$colors,$is_publish,$is_preferential,$in_storage,$associated,$after_sales,$cate,$sort)
        {
                $date =date('Y-m-d H:i:s',time());
                $result = Yii::app()->db->createCommand('INSERT INTO `goods_model` (`goods_id`,`title`,`goods_list`,`model_number`,`stock`,`price`,`preferential_price`,`weights`,`sizes`,`colors`,`is_publish`,`is_preferential`,`in_storage`,`create_time`,`associated`,`after_sales`,`cate_test`,`sort`)
                VALUES (:goods_id,:title,:goods_list,:model_number,:stock,:price,:preferential_price,:weights,:sizes,:colors,:is_publish,:is_preferential,:in_storage,:create_time,:associated,:after_sales,:cate_test,:sort)')
                ->bindParam(':goods_id',$goodsId)->bindParam(':title',$title)->bindParam(':goods_list',$goods_list)->bindParam(':model_number',$model_number)
                ->bindParam(':stock',$stock)->bindParam(':price',$price)->bindParam(':preferential_price',$preferential_price)
                ->bindParam(':weights',$weights)->bindParam(':sizes',$sizes)->bindParam(':colors',$colors)
                ->bindParam(':is_publish',$is_publish)->bindParam(':is_preferential',$is_preferential)->bindParam(':in_storage',$in_storage)
                ->bindParam(':create_time',$date)->bindParam(':associated',$associated)->bindParam(':after_sales',$after_sales)
                ->bindParam(':cate_test',$cate)->bindParam(':sort',$sort)->execute();
                $eid = Yii::app()->db->getLastInsertID();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','insert');
                }
                return $eid;
        }
    //多条件查询商品（后台搜索）
        public static function search_Bywhere($sql1,$sql2,$sql3,$sql4)
        {
                $sql = "SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where $sql1 $sql2 $sql3 $sql4 AND A.is_delete=0 AND B.is_delete=0";
                //$sql = "SELECT * FROM `goods` WHERE $sql1 $sql2 $sql3 $sql4 and is_delete=0";
                $result = Yii::app()->db->createCommand($sql)->queryAll();
                return $result;
        }
        //查找所有商品型号
        public static function searchGoodsmodelall()
        {
                $result = Yii::app()->db->createCommand('SELECT * FROM goods A RIGHT JOIN goods_model B ON A.id=B.goods_id where A.is_delete=0 AND B.is_delete=0;')->queryAll();
                return $result;
        }
        //根据id查找商品型号
        public static function searchGoodsmodelbyid($id)
        {
            //$result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id LEFT JOIN meal_goods C ON C.good_model_id=B.id WHERE B.id=:id;')->bindParam(':id',$id)->queryAll();
                //$result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id WHERE B.id=:id;')->bindParam(':id',$id)->queryRow();
            $result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id WHERE B.id=:id and A.is_delete=0 AND B.is_delete=0;')->bindParam(':id',$id)->queryRow();
                return $result;
        }
    public static function searchGoodsmodelbyid1($id,$packageid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `goods` A LEFT JOIN `goods_model` B ON A.id=B.goods_id LEFT JOIN `meal_goods` C ON B.id=C.good_model_id WHERE C.good_model_id=:id AND C.meal_id=:meal_id  AND A.is_delete=0 AND B.is_delete=0 AND C.is_delete=0;')->bindParam(':meal_id',$packageid)->bindParam(':id',$id)->queryRow();
        //$result = Yii::app()->db->createCommand('SELECT * FROM goods A LEFT JOIN goods_model B ON A.id=B.goods_id WHERE B.id=:id;')->bindParam(':id',$id)->queryRow();
        //$result = Yii::app()->db->createCommand('SELECT * FROM goods WHERE id=:id;')->bindParam(':id',$id)->queryRow();
        return $result;
    }
        //根据modelid查找商品id
        public static function searchGoodsbyid($modelid)
        {
                $result = Yii::app()->db->createCommand('SELECT goods_id FROM goods_model  WHERE id=:id AND is_delete=0;')->bindParam(':id',$modelid)->queryRow();
                return $result;
        }
        //根据商品型号ID删除商品类型
        public static function delModelbyid($model_id)
        {
                $result = Yii::app()->db->createCommand('UPDATE goods_model SET is_delete=1 WHERE id=:id')->bindParam(':id',$model_id)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','delete');
                }
                return $result;
        }
        //编辑商品类型状态
        public static function edit_Goodsmodel($id,$is_publish)
        {
                $result = Yii::app()->db->createCommand('UPDATE `goods_model` SET is_publish = :is_publish WHERE id=:id')->bindParam(':is_publish',$is_publish)->bindParam(':id',$id)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','update');
                }
                return $result;
        }

        //根据id编辑商品
        public static function editGoodsbyid ($goodsid,$name,$cate,$brand,$business_men,$create_time,$manual,$detail_introduce,$create_time,$is_comments)
        {
                $sql = "UPDATE `goods` SET name=:name,cate=:cate,brand=:brand,business_men=:business_men,create_time=:create_time,manual=:manual,detail_introduce=:detail_introduce,is_comments=:is_comments WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':name',$name)->bindParam(':cate',$cate)->bindParam(':brand',$brand)
                ->bindParam(':business_men',$business_men)->bindParam(':manual',$manual)->bindParam(':detail_introduce',$detail_introduce)
                ->bindParam(':create_time',$create_time)->bindParam(':is_comments',$is_comments)->bindParam(':id',$goodsid)->execute();
                if($result)
                {
                    $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods','update');
                }
                return $result;
        }
        //根据id编辑商品类型
        public static function editGoodsmodelbyid($goodsmodelid, $title,$goods_list,$model_number,$stock,$price,$associated,$preferential_price,$weights,$sizes,$colors,$after_sales,$is_publish,$is_preferential,$create_time,$cateid,$in_storage)
        {
                $sql = "UPDATE `goods_model` SET title=:title,goods_list=:goods_list,model_number=:model_number,stock=:stock,price=:price,associated=:associated,preferential_price=:preferential_price,weights=:weights,sizes=:sizes,colors=:colors,after_sales=:after_sales,is_publish=:is_publish,is_preferential=:is_preferential,create_time=:create_time,cate_test=:cate,in_storage=:in_storage WHERE id=:id";
                $result = Yii::app()->db->createCommand($sql)
                ->bindParam(':title',$title)->bindParam(':goods_list',$goods_list)->bindParam(':model_number',$model_number)
                ->bindParam(':stock',$stock)->bindParam(':price',$price)->bindParam(':create_time',$create_time)
                ->bindParam(':associated',$associated)->bindParam(':preferential_price',$preferential_price)->bindParam(':weights',$weights)
                ->bindParam(':sizes',$sizes)->bindParam(':colors',$colors)->bindParam(':after_sales',$after_sales)
                ->bindParam(':is_publish',$is_publish)->bindParam(':is_preferential',$is_preferential)
                ->bindParam(':in_storage',$in_storage)->bindParam(':cate',$cateid)->bindParam(':id',$goodsmodelid)->execute();
                if($result)
                {
                    CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'goods_model','update');
                }
                return $result;
        }
}






























