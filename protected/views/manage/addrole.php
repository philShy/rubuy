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
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/js/dragDivResize.js" type="text/javascript"></script>
    <title></title>
</head>
<style>
    ul{float:left;width:600px;padding: 10px;border:1px solid #eee;margin-top: 5px;margin-left: 5px;}
   .li0{height:30px;line-height: 30px;padding-left: 5px;font-size: 16px;}
    .li1{float:left;margin-top: 5px;}
    input[type=checkbox] {  vertical-align: middle;  width: 18px;  height: 18px;  margin-left: 5px;  margin-top: -3px;}
</style>
<body>
<div class="Competence_add_style clearfix">
    <form action="" method="post" id="iform">
    <div class="left_Competence_add">
        <div class="title_name">添加角色</div>
        <div class="Competence_add">
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 角色名称 </label>
                <div class="col-sm-9"><input type="text" id="form-field-1" placeholder=""  name="role-name" class="col-xs-10 col-sm-5"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 角色描述 </label>
                <div class="col-sm-9"><textarea name="role-introduce" class="form-control" id="form_textarea" placeholder="" onkeyup="checkLength(this);"></textarea><span class="wordage">剩余字数：<span id="sy" style="color:Red;">200</span>字</span></div>
            </div>
            <!--按钮操作-->
            <div class="Button_operation">
                <input type="submit" value="提交" class="btn btn-primary radius"  >
            </div>
        </div>
    </div>
    <!--权限分配-->
    <div class="Assign_style">
        <div class="title_name">权限分配</div>
            <?php foreach($auth_arr0 as $key=>$value):?>
                <?php $auth_arr1 = CManage::searchAll_auth1($value['id']);?>
                 <ul>
                     <li class="li0">
                         <?php echo $value['auth_name'];?><input name="checkAll[]" class="checkAll checkAll<?php echo $value['id'];?>" type="checkbox" value="<?php echo $value['id'];?>">
                     </li>
                     <?php foreach($auth_arr1 as $key1=>$value1):?>
                         <li class="li1">&nbsp;&nbsp; &nbsp;&nbsp;<?php echo $value1['auth_name'];?><input name="subBox[<?php echo $value['id'];?>][]" class="subBox subBox<?php echo $value['id'];?>" type="checkbox" pid="<?php echo $value1['pid'];?>" value="<?php echo $value1['id'];?>"></li>
                     <?php endforeach;?>
                </ul>
            <?php endforeach;?>
    </div>
    </form>
</div>

</body>
</html>
<script type="text/javascript">
    //初始化宽度、高度
    $(".left_Competence_add,.Competence_add_style").height($(window).height()).val();;
    $(".Assign_style").width($(window).width()-500).height($(window).height()).val();
    $(".Select_Competence").width($(window).width()-500).height($(window).height()-40).val();
    //当文档窗口发生改变时 触发
    $(window).resize(function(){

        $(".Assign_style").width($(window).width()-500).height($(window).height()).val();
        $(".Select_Competence").width($(window).width()-500).height($(window).height()-40).val();
        $(".left_Competence_add,.Competence_add_style").height($(window).height()).val();;
    });
    /*字数限制*/
    function checkLength(which) {
        var maxChars = 200; //
        if(which.value.length > maxChars){
            layer.open({
                icon:2,
                title:'提示框',
                content:'您出入的字数超多限制!',
            });
            // 超过限制的字数了就将 文本框中的内容按规定的字数 截取
            which.value = which.value.substring(0,maxChars);
            return false;
        }else{
            var curr = maxChars - which.value.length; //250 减去 当前输入的
            document.getElementById("sy").innerHTML = curr.toString();
            return true;
        }
    };
    /*按钮选择*/
    $(function(){
        $(".checkAll").click(function(){
            var mark = $(this).val();
            $(".subBox"+mark).prop("checked",this.checked);
        });
        $(".subBox").click(function(){
            var $isChecked = $(this).is(":checked");
            var mark = $(this).attr('pid');
            var lg = $(".subBox"+mark+":checked").length;
            if($isChecked){
                $(".checkAll"+mark).prop("checked","checked");
            }else if(lg == 0){
                $(".checkAll"+mark).prop("checked",false);
            }
        })
    });

</script>
