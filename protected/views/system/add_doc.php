<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <title>添加文章</title>
</head>
<style>
    #down{display: inline-block;color:#fff;background:#438eb9;margin-left:20px !important;text-decoration: none;border-radius:3px;}
    .attachItem .right a {display:block;width:16px;height:16px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }
    .downItem{width:130px;height:130px;background: #eee;float:left;border-radius: 3px;margin-left:5px;margin-top: 5px}
    .downItem .right a {display:block;width:15px;height:15px;overflow: hidden;text-indent:-9999px;background:url(/images/delete.png);  }
    .left{width:150px;height:24px;line-height:25px;float:left}
    .right{float:right;margin-top: -128px;}
    #pic{width:100px; height:100px; margin:15px;  cursor: pointer;}
    .error{color:red}
</style>
<body>
<div class="margin clearfix">
    <div class="article_style">
        <form action="/system/add_doc" method="post" id="add-article" enctype="multipart/form-data">
            <div class="add_content" id="form-article-add">
                <ul>
                    <li class="clearfix Mandatory">
                        <label class="label_name"><i>*</i>文章标题</label><span class="formControls col-10"><input name="title" type="text" style="width:500px" ></span>
                    </li>
                    <li class="clearfix Mandatory"><label class="label_name"><i>*</i>文章简介</label>
                        <span class="formControls col-10"><input name="introduce" type="text" style="width:500px" ></span>
                    </li>
                    <li class="clearfix"><label class="label_name"><i>*</i>所属分类</label>
                   <span class="formControls col-4"><select name="cate" class="form-control" id="form-field-select-1">
                           <?php foreach($cate_arr as $key=>$value):?>
                               <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                           <?php endforeach;?>
                       </select>
                   </span>
                    </li>
                    <li class="clearfix"><label class="label_name">文章作者</label>
                        <span class="formControls col-10"><input name="author" type="text" id="form-field-1" style="width:91px"></span>
                    </li>
                    <li class="clearfix"><label class="label_name">点击量</label>
                        <span class="formControls col-10"><input name="hit" type="number" id="form-field-1" style="width:91px"></span>
                    </li>
                    <li class="clearfix"><label class="label_name">点赞数</label>
                        <span class="formControls col-10"><input name="thumb" type="number" id="form-field-1" style="width:91px"></span>
                    </li>
                    <li class="clearfix"><label class="label_name">是否推荐</label>
                    <span class="formControls col-4">
                        <select name="recommend" class="form-control" id="form-field-select-1" style="width:91px">
                            <option value="0">不推荐</option>
                            <option value="1">推荐</option>
                            <option value="2">主推</option>
                        </select>
                    </span></li>
                    <!--<li>
                        <div id="addCommodityIndex">
                            <div class="input-group row">
                                <label class="label_name" ><i></i>封面图片</label>
                                <div class="col-sm-9 big-photo" style="position:relative;top:-20px;left:85px;">
                                    <div id="preview" class="add_text" style="cursor:pointer">
                                        <img id="imghead" border="0" src="/images/photo_icon.png" width="100" height="100" onclick="$('#previewImg').click();">
                                    </div>
                                    <input type="file" name=file onchange="previewImage(this)" style="display: none;" id="previewImg">
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="clearfix addimg" ><label class="label_name">文章图片</label>
                        <a href="javascript:void(0)" id="down" style="margin-left: 10px">上传附件</a>
                        <div class="down-list-container" style="display: none;width:1062px;margin-left:92px;">
                            <div class="downList clear"></div>
                        </div>
                    </li>-->
                    <li class="clearfix"><label class="label_name">文章内容</label>
                        <span class="formControls col-10"><script id="content" name="content" type="text/plain" style="width:100%;height:400px; margin-left:10px;"></script> </span>
                    </li>
                </ul>
                <div class="Button_operation">
                    <input type="button" value="提交" class="btn btn-primary radius">
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Widget/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    //图片上传预览    IE是用了滤镜。
    /*function previewImage(file)
    {
        var MAXWIDTH  = 90;
        var MAXHEIGHT = 90;
        var div = document.getElementById('preview');
        if (file.files && file.files[0])
        {
            div.innerHTML ='<img width=100px; id=imghead onclick=$("#previewImg").click()>';
            var img = document.getElementById('imghead');
            img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
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
    $(function() {
        $("#pic").click(function () {
            $("#upload").click(); //隐藏了input:file样式后，点击头像就可以本地上传
            $("#upload").on("change",function(){
                var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
                if (objUrl) {
                    $("#pic").attr("src", objUrl) ; //将图片路径存入src中，显示出图片
                }
            });
        });
    });

    $(function(){
        $("#add-article").on('click','#down',function(){
            $(this).parent().find('.down-list-container').show()
            $fileField = $("<input type='file' name='down[]'/>");
            $fileField.hide();
            $(this).parent().find(".downList").append($fileField);
            $fileField.trigger("click");
            $fileField.change(function(){
                var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $downItem = $("<div class='downItem'><img id='pic' src="+objUrl+" ><div class='right'><a href='#' title='删除附件'>删除</a></div></div>");
                $downItem.find(".left").html($filename);
                $(this).parent().append($downItem);
            });
        });
        $("#add-article").on('click','.downItem a',function(obj,i){
            $(this).parents('.downItem').prev('input').remove();
            $(this).parents('.downItem').remove();
        });
    })

    //建立一個可存取到該file的url
    function getObjectURL(file){
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }*/

    $(function(){
        var aa = $('#add-article').serialize()
        $('.btn').click(function(){
            $('#add-article').submit()
        })
    })
    $(function(){
        var ue = UE.getEditor('content');
    });
    $(function(){
        $("#add-article").validate({
            rules: {
                title: {
                    required: true,
                    rangelength:[0,20]
                },
                introduce: {
                    required: true,
                    rangelength:[0,50]
                }
            },
            messages: {
                title: {
                    required: "&nbsp;&nbsp;必填",
                    maxlength: "&nbsp;&nbsp;标题字数介于0-20之间"
                },
                introduce: {
                    required: "&nbsp;&nbsp;必填",
                    minlength:'&nbsp;&nbsp;简介字数介于0-50之间'
                }
            }
        })
    })

</script>
