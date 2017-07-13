<?php
class CUploadbrandlogo
{
    public static function uploadbrandlogo($id,$images_class_id,$folder1)
    {
        $isSuc = false;
        $root = YiiBase::getPathOfAlias('webroot').Yii::app()->getBaseUrl();
        $folder = $root.'/images/brand/';
        $desFilePath = '';
        $tmpFilePath = '';
        self::mkDirIfNotExist($folder);
        if ((($_FILES["file"]["type"] == "image/gif")
            || ($_FILES["file"]["type"] == "image/jpeg")
            || ($_FILES["file"]["type"] == "image/png")
            || ($_FILES["file"]["type"] == "image/jpg")
            || ($_FILES["file"]["type"] == "image/pjpeg")))
            //&& ($_FILES["file"]["size"] < 20000))
        {
            if ($_FILES["file"]["error"] > 0)
            {
                $isSuc = false;
            }
            else
            {
                /*echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                echo "Type: " . $_FILES["file"]["type"] . "<br />";
                echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";*/
                $tmpFilePath = $_FILES["file"]["tmp_name"];
                $desFilePath = $folder.$_FILES["file"]["name"];
                $ressult_brand = CProduct::searchBrandbyid($id);
                if($ressult_brand){
                    if (is_file($folder.strrchr($ressult_brand['images_url'],'/'))) {

                        unlink($folder.strrchr($ressult_brand['images_url'],'/'));
                    }
                    move_uploaded_file($tmpFilePath, $desFilePath);
                    $res = CProduct::editBrandlogo($folder1.$_FILES["file"]["name"],$id);
                    if($res){

                        //Yii::success("品牌logo替换成功",Yii::app()->request->urlReferrer,"3");die;
                        Yii::success("修改成功",Yii::app()->createUrl('../product/brand'),"1");die;
                    }

                    else
                    {
                        Yii::error("品牌logo替换失败",Yii::app()->request->urlReferrer,"1");die;
                    }
                }else{

                    $res = CProduct::addBrandlogo($folder1.$_FILES["file"]["name"],$id,$images_class_id);
                    if($res){
                        Yii::success("上传成功",Yii::app()->createUrl('../product/brand'),"1");die;
                    }
                    else
                    {
                        Yii::error("品牌logo上传失败",Yii::app()->request->urlReferrer,"1");die;
                    }
                }

            }
        }
        else
        {
            Yii::error("品牌logo上传失败",Yii::app()->request->urlReferrer,"3");die;
        }

    }
    public static function mkDirIfNotExist($dir)
    {
        if(!is_dir($dir))
        {
            if(!mkdir($dir, 0, true))
            {
                throw new Exception('create folder fail');
                //return false;
            }
            else
            {
                return true;
            }
        }
        return false;
    }
}