<?php
class UploadbrandlogoController extends Controller
{
    public function actionUploadbrandlogo()
    {
        $isSuc = false;
        $root = YiiBase::getPathOfAlias('webroot').Yii::app()->getBaseUrl();
        $folder = $root.'/upload/brandlogo/';
        $desFilePath = '';
        $tmpFilePath = '';

        $this->mkDirIfNotExist($folder);

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
                if (file_exists($desFilePath))
                {
                    unlink($desFilePath);
                    //echo $_FILES["file"]["name"] . " already exists. ";
                }
                else
                {
                    move_uploaded_file($tmpFilePath, $desFilePath);
                    $isSuc = true;
                }

                $res = CProduct::addBrandlogo($desFilePath);
                if($res)
                    Yii::success("品牌logo上传成功",Yii::app()->request->urlReferrer,"3");
                else
                    Yii::error("品牌logo上传失败",Yii::app()->request->urlReferrer,"3");
            }
        }
        else
        {
            Yii::error("品牌logo上传失败",Yii::app()->request->urlReferrer,"3");
        }

    }

    function mkDirIfNotExist($dir)
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