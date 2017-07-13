<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>添加品牌 - 素材牛模板演示</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <link href="/assets/css/iconfont.css" rel="stylesheet" />
    <link href="/assets/css/fileUpload.css" rel="stylesheet" />
    <link href="/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->

    <script src="/assets/js/jquery.validate.min.js"></script>
    <!--   <script src="/assets/js/jquery-1.9.1.min.js"></script>-->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.queue.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/swfupload.speed.js"></script>
    <script type="text/javascript" src="/Widget/swfupload/handlers.js"></script>
</head>
<style>
    .error{color: red}
</style>
<body>
<div class=" clearfix">
    <div id="add_brand" class="clearfix">
        <form action="/product/editbrand" method="post" enctype="multipart/form-data" id="commentForm">
            <input name="brandid" type="hidden" class="add_text" value="<?php echo $brandarr['id']?>">
                <ul class="add_conent" style="margin-top: 0;">
                        <li id="brandname" class=" clearfix"><label class="label_name" ><i>*</i>品牌名称：</label> <input name="brandname" type="text" class="add_text" value="<?php echo $brandarr['brandname']?>" minlength="2" type="text" required/></li>
                        <li id="sort" class=" clearfix"><label class="label_name"><i>*</i>品牌序号：</label> <input name="sort" type="number" value="<?php echo $brandarr['sort']?>" class="add_text" required/></li>
                        <li>
                            <div id="addCommodityIndex">
                                <!--input-group start-->
                                <div class="input-group row">
                                    <label class="label_name" ><i></i>品牌logo：</label>
                                    <div class="col-sm-9 big-photo" style="position:relative;top:-20px;left:85px;">
                                        <div id="preview" class="add_text" style="cursor:pointer">
                                            <img id="imghead" border="0" src="<?php echo $brandarr['images_url']?>" width="150" onclick="$('#previewImg').click();">
                                        </div>
                                        <input type="file" name=file onchange="previewImage(this)" style="display: none;" id="previewImg">
                                    </div>
                                </div>
                                <!--input-group end-->
                            </div>
                        </li>
                        <li id="address" class=" clearfix"><label class="label_name"><i>*</i>所属地区：</label> <input name="country" value="<?php echo $brandarr['country']?>" class="add_text" minlength="2" type="text" required/></li>
                        <li id="describe" class=" clearfix"><label class="label_name">品牌描述：</label> <textarea id="describe" name="introduce" cols="" rows="" class="textarea""><?php echo $brandarr['introduce']?></textarea></li>
                        <li class=" clearfix"><label class="label_name"><i>*</i>显示状态：</label>
                            <label><input name="state" type="radio" class="ace" <?php  if($brandarr['is_delete'] == '0'){echo "checked"; }?> value="0" /><span class="lbl">启用</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input name="state" type="radio" class="ace" <?php  if($brandarr['is_delete'] == '1'){echo "checked"; }?> value="1"/><span class="lbl">停用</span></label>
                        </li>
                    <li><input type="submit" id="btn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></li>
                </ul>

        </form><!--<input id="uploaderInput" class="uploader__input" style="display: none;" type="file" accept="" multiple="">-->
    </div>
</body>
</html>
<script type="text/javascript">
    $("#signupForm").validate({
        rules: {
            sort: {
                required: true,
                digits:true,
                minlength: 2
            }

            brandname: {
                required: true,
                minlength: 2
            },
            address: {
                required: true,
                minlength: 2
            },

            describe: {
                required: true,
                minlength: 1000
            },
        },
        messages: {
            sort:{
                required: "品牌名称不能为空",
                digits: "必须输入数字",
                minlength: "用户名至少由两个数字组成"
            },
            brandname: {
                required: "品牌名称不能为空",
                minlength: "用户名至少由两个字母组成"
            },
            address: {
                required: "品牌地址不能为空",
                minlength: "用户名至少由两个字母组成"
            },
            describe: {
                required: "品牌描述不能为空",
                minlength: "用户名至少由500汉字组成"
            },
        }
</script>
<script>
    //图片上传预览    IE是用了滤镜。
    function previewImage(file)
    {
        var MAXWIDTH  = 90;
        var MAXHEIGHT = 90;
        var div = document.getElementById('preview');
        if (file.files && file.files[0])
        {
            div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
            var img = document.getElementById('imghead');
            img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
            }
            var reader = new FileReader();
            reader.onload = function(evt){img.src = evt.target.result;}
            reader.readAsDataURL(file.files[0]);
        }
        else //兼容IE
        {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            var src = document.selection.createRange().text;
            div.innerHTML = '<img id=imghead>';
            var img = document.getElementById('imghead');
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
            div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
        }
    }
    function clacImgZoomParam( maxWidth, maxHeight, width, height ){
        var param = {top:0, left:0, width:width, height:height};
        if( width>maxWidth || height>maxHeight ){
            rateWidth = width / maxWidth;
            rateHeight = height / maxHeight;

            if( rateWidth > rateHeight ){
                param.width =  maxWidth;
                param.height = Math.round(height / rateWidth);
            }else{
                param.width = Math.round(width / rateHeight);
                param.height = maxHeight;
            }
        }
        param.left = Math.round((maxWidth - param.width) / 2);
        param.top = Math.round((maxHeight - param.height) / 2);
        return param;
    }
</script>

