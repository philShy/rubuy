<?php
/**
 * Class CImages
 * @auto phil
 */
class CImages
{
    //查找所有图片类
    public static function searchImages()
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images_class` where is_delete=0 ORDER BY id DESC ')->queryAll();
        return $result;
    }

    //添加图片类别
    public static function addImages($name,$introduce,$is_delete)
    {
        $create_time = date('Y-m-d H:i:s',time());
        $result = Yii::app()->db->createCommand('INSERT INTO `images_class` (`name`,`introduce`,`is_delete`,`create_time`)VALUES (:name,:introduce,:is_delete,:create_time)')
        ->bindValue(':name',$name)->bindValue(':introduce',$introduce)->bindValue(':is_delete',$is_delete)->bindValue(':create_time',$create_time)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','insert');
        return $result;
    }

    //通过ID查找类别
    public static function searchImage_byid($id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images_class` WHERE id=:id and is_delete=0')->bindParam(':id',$id)->queryRow();
        return $result;
    }

    //通过ID修改类别
    public static function editImage($class_id,$name,$introduce,$is_delete)
    {
        $sql = "UPDATE `images_class` SET name=:name,introduce=:introduce,is_delete=:is_delete WHERE id=:id";
        $result = Yii::app()->db->createCommand($sql)->bindParam(':name',$name)->bindParam(':introduce',$introduce)
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$class_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','update');
        return $result;
    }
    //通过ID修改类别状态
    public static function editImagestate($image_id,$is_delete)
    {
        $sql = "UPDATE `images_class` SET is_delete=:is_delete WHERE id=:id";
        $result = Yii::app()->db->createCommand($sql)
        ->bindParam(':is_delete',$is_delete)->bindParam(':id',$image_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','update');
        return $result;
    }

    //通过ID删除类别
    public static function delImageclass($image_id)
    {
        $result = Yii::app()->db->createCommand("UPDATE `images_class` SET is_delete=0 WHERE id=:id")->bindParam(':id',$image_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images_class','delete');
        return $result;
    }

    //同时删除images表中相应类别的图片
    public static function delImages($image_id)
    {
        $result = Yii::app()->db->createCommand("UPDATE `images` SET is_delete=0 images_class_id=:id")->bindParam(':id',$image_id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
        return $result;
    }
    //根据类型查询图片表中的图片
    public static function searchImagecate($model_id)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images` WHERE model_id=:model_id and is_delete=0 ORDER BY sort ASC ')->bindParam(':model_id',$model_id)->queryAll();
        return $result;
    }
    //
    public static function searchImagebrand($brandid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images` WHERE brand_id=:brand_id and is_delete=0 ORDER BY sort ASC ')->bindParam(':brand_id',$brandid)->queryRow();
        return $result;
    }
    //根据图片id查询图片详情
    public static function searchimages_Bypicid($picid)
    {
        $result = Yii::app()->db->createCommand('SELECT * FROM `images` WHERE id=:id and is_delete=0 ')->bindParam(':id',$picid)->queryRow();
        return $result;
    }
    //根据model_id查询该类型排序最大的图片
    public static function searchimages_Bymodelid($modelid)
    {
        $result = Yii::app()->db->createCommand("SELECT max(sort) maxArr FROM images WHERE model_id=:model_id and is_delete=0 ")->bindParam(':model_id',$modelid)->queryRow();
        return $result;
    }
    //根据model_id查询图片
    public static function searchimgs_Bymodelid($modelid)
    {
        $result = Yii::app()->db->createCommand("SELECT images_url FROM images WHERE model_id=:model_id and is_delete=0 ")->bindParam(':model_id',$modelid)->queryAll();
        return $result;
    }
    //
    public static function searchOne($modelid)
    {
        $result = Yii::app()->db->createCommand("SELECT images_url FROM images WHERE model_id=:model_id and sort=1 and is_delete=0 ")->bindParam(':model_id',$modelid)->queryRow();
        return $result;
    }
    //根据条件查询符合图片
    public static function searchimages_Bywhere($modelid,$sort)
    {
        $result = Yii::app()->db->createCommand("SELECT id,sort FROM images WHERE model_id=:model_id AND sort>:sort and is_delete=0 ")
        ->bindParam(':model_id',$modelid)->bindParam(':sort',$sort)->queryAll();
        return $result;
    }
    //更新图片顺序
    public static function updateimagesSort($picid,$sort)
    {
        $result = Yii::app()->db->createCommand("UPDATE `images` SET sort=:sort WHERE id=:id ")
        ->bindParam(':id',$picid)->bindParam(':sort',$sort)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','up');
        return $result;
    }
    //根据商品类型model_id 删除图片
    public static function delimages_Bymodelid($id)
    {
        $result = Yii::app()->db->createCommand("UPDATE images SET is_delete=1 WHERE model_id=:model_id ")
        ->bindParam(':model_id',$id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
        return $result;
    }
    //根据图片id 删除图片
    public static function delimages_Bypicid($id)
    {
        $result = Yii::app()->db->createCommand("UPDATE `images` SET is_delete=0 WHERE id=:id ")
        ->bindParam(':id',$id)->execute();
        $log_res = CSystem::opration(Yii::app()->session['manager'],Yii::app()->session['rolr_id'],'images','delete');
        return $result;
    }
    //根据商品类型id，商品类型图片顺序查找他上一个图片
    public static function searchupimages($model_id,$sort)
    {
        $result = Yii::app()->db->createCommand("SELECT id FROM images WHERE model_id=:model_id AND sort=:sort and is_delete=0 ")
        ->bindParam(':model_id',$model_id)->bindParam(':sort',$sort)->queryRow();
        return $result;
    }
    public static function img_create_small($destination, $width, $height, $product_small)//原始大图地址，缩略图宽度，高度，缩略图地址
    {
        $imgage = getimagesize($destination); //得到原始大图片
        switch ($imgage[2]) {            // 图像类型判断
            case 1:
                $im = imagecreatefromgif($destination);
                break;
            case 2:
                $im = imagecreatefromjpeg($destination);
                break;
            case 3:
                $im = imagecreatefrompng($destination);
                break;
        }
        $src_W = $imgage[0]; //获取大图片宽度
        $src_H = $imgage[1]; //获取大图片高度

        $tn = imagecreatetruecolor($width, $height); //创建缩略图
        imagecopyresampled($tn, $im, 0, 0, 0, 0, 50, 50, $src_W, $src_H); //复制图像并改变大小
        imagejpeg($tn, $product_small); //输出图像
    }
}