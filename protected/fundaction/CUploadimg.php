<?php
class CUploadimg
{
    /**
     * 构建上传文件信息
     * @return array
     */
    public static function getExt($filename)
    {
        $arr = explode(".",$filename);
        $end_arr = end($arr);
        return strtolower($end_arr);
    }
    public static function getUniName()
    {
        return md5(uniqid(microtime(true),true));
    }
    public static function buildInfo()
    {
        $i=0;
        if($_FILES['down'])
        {
            $_FILES1['down'] = $_FILES['down'];
            foreach($_FILES1 as $v){
                //单文件
                if(is_string($v['name'])){
                    $files[$i]=$v;
                    $i++;
                }else{
                    //多文件
                    foreach($v['name'] as $key=>$val){
                        $files[$i]['name']=$val;
                        $files[$i]['size']=$v['size'][$key];
                        $files[$i]['tmp_name']=$v['tmp_name'][$key];
                        $files[$i]['error']=$v['error'][$key];
                        $files[$i]['type']=$v['type'][$key];
                        $i++;
                    }
                }
            }
        }else{
            foreach($_FILES as $v){
                //单文件
                if(is_string($v['name'])){
                    $files[$i]=$v;
                    $i++;
                }else{
                    //多文件
                    foreach($v['name'] as $key=>$val){
                        $files[$i]['name']=$val;
                        $files[$i]['size']=$v['size'][$key];
                        $files[$i]['tmp_name']=$v['tmp_name'][$key];
                        $files[$i]['error']=$v['error'][$key];
                        $files[$i]['type']=$v['type'][$key];
                        $i++;
                    }
                }
            }
        }
        return $files;
    }
   public static function buildInfos()
   {
        if(!$_FILES)
        {
            return ;
        }
       foreach($_FILES as $v){
           foreach($v['name'] as $key=>$val){
               foreach($val as $k=>$vv){
                   $files[$key][$k]['name']=$vv;
               }
           }
           foreach($v['tmp_name'] as $key=>$val){
               foreach($val as $k=>$vv){
                   $files[$key][$k]['tmp_name']=$vv;
               }

           }
           foreach($v['size'] as $key=>$val){
               foreach($val as $k=>$vv){
                   $files[$key][$k]['size']=$vv;
               }

           }
           foreach($v['error'] as $key=>$val){
               foreach($val as $k=>$vv){
                   $files[$key][$k]['error']=$vv;
               }

           }
           foreach($v['type'] as $key=>$val){
               foreach($val as $k=>$vv){
                   $files[$key][$k]['type']=$vv;
               }

           }
           return $files;
       }

    }
    //上传图片文件
    public static function uploadFile($img_path="images",$allowExt=array("gif","jpeg","png","jpg","wbmp"),$maxSize=2097152,$imgFlag=true)
    {

        if (!file_exists($img_path)) {
            mkdir($img_path, 0777, true);
        }
        $i = 0;
        $files = self::buildInfo();
        if (!($files && is_array($files))) {
            return;
        }
        foreach ($files as $k => $file) {
                if ($file['error'] === UPLOAD_ERR_OK) {

                    $ext = self::getExt($file['name']);
                    //检测文件的扩展名
                    if (!in_array('png', $allowExt)) {
                        exit("非法文件类型");
                    }
                    //校验是否是一个真正的图片类型
                    if ($imgFlag) {
                        if (!getimagesize($file['tmp_name'])) {
                            exit("不是真正的图片类型");
                        }
                    }
                    //上传文件的大小
                    if ($file['size'] > $maxSize) {
                        exit("上传文件过大");
                    }
                    if (!is_uploaded_file($file['tmp_name'])) {
                        exit("不是通过HTTP POST方式上传上来的");
                    }

                    $filename = self::getUniName() . "." . $ext;
                    $destination = $img_path . "/" . $filename;
                    //echo $filename.'--'.$destination;die;
                    $product_small = 'images/product_50/50'.$filename;
                    if (move_uploaded_file($file['tmp_name'], $destination))
                    {
                        CImages::img_create_small($destination,50,50,$product_small);
                        $file['name'] = $filename;
                        unset($file['tmp_name'], $file['size'], $file['type']);
                        $uploadedFiles[$i] = $file;
                        $i++;
                    }

                } else {
                    switch ($file['error']) {
                        case 1:
                            $mes = "超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                            break;
                        case 2:
                            $mes = "超过了表单设置上传文件的大小";            //UPLOAD_ERR_FORM_SIZE
                            break;
                        case 3:
                            $mes = "文件部分被上传";//UPLOAD_ERR_PARTIAL
                            break;
                        case 4:
                            $mes = "没有文件被上传";//UPLOAD_ERR_NO_FILE
                            break;
                        case 6:
                            $mes = "没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                            break;
                        case 7:
                            $mes = "文件不可写";//UPLOAD_ERR_CANT_WRITE;
                            break;
                        case 8:
                            $mes = "由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
                            break;
                    }
                    echo $mes;
                }
            }

            return $uploadedFiles;
    }
//多维数组上传图片文件
   public static function uploadFiles($img_path="images",$allowExt=array("gif","jpeg","png","jpg","wbmp"),$maxSize=2097152,$imgFlag=true)
   {
        if(!file_exists($img_path)){
            mkdir($img_path,0777,true);
        }
        $files = self::buildInfos();
        if(!($files&&is_array($files))){
            return ;
        }
        foreach($files as $k=>$v){
            foreach($v as $key=>$file){
                if($file['error']===UPLOAD_ERR_OK){
                    $ext=self::getExt($file['name']);
                    //检测文件的扩展名
                    //var_dump($ext);die;
                    if(!in_array('png',$allowExt)){
                        exit("非法文件类型");
                    }
                    //校验是否是一个真正的图片类型
                    if($imgFlag){
                        if(!getimagesize($file['tmp_name'])){
                            exit("不是真正的图片类型");
                        }
                    }
                    //上传文件的大小
                    if($file['size']>$maxSize){
                        exit("上传文件过大");
                    }
                    if(!is_uploaded_file($file['tmp_name'])){
                        exit("不是通过HTTP POST方式上传上来的");
                    }
                    $filename=self::getUniName().".".$ext;
                    $destination=$img_path."/".$filename;
                    $product_small = 'images/product_50/50'.$filename;
                    if(move_uploaded_file($file['tmp_name'], $destination)){
                        CImages::img_create_small($destination,50,50,$product_small);
                        $file['name']=$filename;
                        unset($file['tmp_name'],$file['size'],$file['type'],$file['error']);
                        $uploadedFiles[$k][$key]=$file;
                    }
                }else{
                    switch($file['error']){
                        case 1:
                            $mes="超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                            break;
                        case 2:
                            $mes="超过了表单设置上传文件的大小";			//UPLOAD_ERR_FORM_SIZE
                            break;
                        case 3:
                            $mes="文件部分被上传";//UPLOAD_ERR_PARTIAL
                            break;
                        case 4:
                            $mes="没有文件被上传";//UPLOAD_ERR_NO_FILE
                            break;
                        case 6:
                            $mes="没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                            break;
                        case 7:
                            $mes="文件不可写";//UPLOAD_ERR_CANT_WRITE;
                            break;
                        case 8:
                            $mes="由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
                            break;
                    }
                    echo $mes;
                }
            }
        }
        return $uploadedFiles;
    }

//上传pdf、zip、word文件
    public static function uploadDown($path="uploadsfile",$allowExt=array("pdf","zip","doc","docx","rar"),$maxSize=10485760,$imgFlag=true)
    {
        if(!file_exists($path)){
            mkdir($path,0777,true);
        }
        $i=0;
        $files=self::buildInfo();
        if(!($files&&is_array($files))){
            return ;
        }
        foreach($files as $file){
            if($file['error']===UPLOAD_ERR_OK){
                $ext=self::getExt($file['name']);
                //检测文件的扩展名
                if(!in_array($ext,$allowExt)){
                    exit("非法文件类型");
                }
                //上传文件的大小
                if($file['size']>$maxSize){
                    exit("上传文件过大");
                }
                if(!is_uploaded_file($file['tmp_name'])){
                    exit("不是通过HTTP POST方式上传上来的");
                }
                $destination=$path."/".$file['name'];
                if(move_uploaded_file($file['tmp_name'], iconv("UTF-8","gb2312",$destination))){
                    unset($file['tmp_name'],$file['size'],$file['type']);
                    $uploadedFiles[$i]=$file;
                    $i++;
                }
            }else{
                switch($file['error']){
                    case 1:
                        $mes="超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                        break;
                    case 2:
                        $mes="超过了表单设置上传文件的大小";			//UPLOAD_ERR_FORM_SIZE
                        break;
                    case 3:
                        $mes="文件部分被上传";//UPLOAD_ERR_PARTIAL
                        break;
                    case 4:
                        $mes="没有文件被上传";//UPLOAD_ERR_NO_FILE
                        break;
                    case 6:
                        $mes="没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                        break;
                    case 7:
                        $mes="文件不可写";//UPLOAD_ERR_CANT_WRITE;
                        break;
                    case 8:
                        $mes="由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
                        break;
                }
                echo $mes;
            }
        }
        return $uploadedFiles;
    }


}