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
    <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
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
    i{color:red}
    select{width:162px;margin-left: 10px;}
</style>
<?php
function t($arr,$pid=0,$lev=0){
    static $list = array();
    foreach($arr as $v){
        if($v['pid']==$pid){
            $list[] = $v;
            t($arr,$v['id'],$lev+1);
        }
    }
    return $list;
}
$list = t($result);
?>
<body>
<div class=" clearfix">
    <div id="add_brand" class="clearfix">
        <form action="/product/addpackage" method="post" enctype="multipart/form-data" id="commentForm">
                <ul class="add_conent" style="margin-top: 0;">
                    <li id="sort" class=" clearfix"><label class="label_name"><i>*</i>套餐名称：</label> <input name="packagename" type="text" class="add_text" /></li>
                    <li id="brandname1" class=" clearfix"><label class="label_name" ><i>*</i>选择商品：</label>
                        <select name="selected" class="selected1" style="width:163px">
                            <option value="">----选择类别----</option>
                            <?php foreach($list as $key=>$value): ?>
                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                    <option value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsname1" class="child1" style="width:123px;display:none">
                            <option value="" >----选择商品----</option>
                        </select>
                        <select name="goodsmodel[]" class="childs1" style="width:123px;display:none">
                            <option value="" >----选择型号----</option>
                        </select>

                        <div class="price1" style="width:30%;display: none;margin-left: 28px;margin-top: 10px;">原&nbsp;&nbsp;&nbsp;价：<input  name="price[]" type="text" placeholder="原价" readonly style="margin-left: 16px"></div>
                        <div class="goodsnum1"  style="width:30%;display: none;margin-left: 28px;margin-top: 10px;" >数&nbsp;&nbsp;&nbsp;量：<input  name="goodsnum[]" type="text" placeholder="输入数量" style="margin-left: 16px"></div>
                        <div class="unit_price1" style="width:30%;display: none;margin-left: 28px;margin-top: 10px;"><span style="font-size: 10px;">套餐价：</span><input name="unit_price[]" type="text" placeholder="套餐价" style="margin-left: 19px"></div>

                    </li>
                    <li id="brandname2" class=" clearfix" style="display: none"><label class="label_name" ><i>*</i>选择商品：</label>
                        <select class="selected2" style="width:163px" name="selected2">
                            <option value="">选择类别</option>
                            <?php foreach($list as $key=>$value): ?>
                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                    <option value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsname2" class="child2" style="width:123px;display:none">
                            <option value="" >----选择商品----</option>
                        </select>
                        <select name="goodsmodel[]" class="childs2" style="width:123px;display:none">
                            <option value="" >----选择型号----</option>
                        </select>
                        <div class="price2" style="width:30%;display: none;margin-left: 28px;margin-top: 10px;">原&nbsp;&nbsp;&nbsp;价：<input  name="price[]" type="text" placeholder="原价" style="margin-left: 16px"></div>
                        <div class="goodsnum2"  style="width:30%;display: none;margin-left: 28px;margin-top: 10px;" >数&nbsp;&nbsp;&nbsp;量：<input  name="goodsnum[]" type="text" placeholder="输入数量" style="margin-left: 16px"></div>
                        <div class="unit_price2" style="width:30%;display: none;margin-left: 28px;margin-top: 10px;"><span style="font-size: 10px;">套餐价：</span><input name="unit_price[]" type="text" placeholder="套餐价" style="margin-left: 19px"></div>
                    </li>
                    <li id="brandname3" class=" clearfix" style="display: none"><label class="label_name" ><i>*</i>选择商品：</label>
                        <select class="selected3" style="width:163px">
                            <option value="">选择类别</option>
                            <?php foreach($list as $key=>$value): ?>
                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                    <option value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsname3" class="child3" style="width:123px;display:none">
                            <option value="" >----选择商品----</option>
                        </select>
                        <select name="goodsmodel[]" class="childs3" style="width:123px;display:none">
                            <option value="" >----选择型号----</option>
                        </select>
                        <div class="price3" style="width:30%;display: none;margin-left: 28px;margin-top: 10px;">原&nbsp;&nbsp;&nbsp;价：<input  name="price[]" type="text" placeholder="原价" style="margin-left: 16px"></div>
                        <div class="goodsnum3"  style="width:30%;display: none;margin-left: 28px;margin-top: 10px;" >数&nbsp;&nbsp;&nbsp;量：<input  name="goodsnum[]" type="text" placeholder="输入数量" style="margin-left: 16px"></div>
                        <div class="unit_price3" style="width:30%;display: none;margin-left: 28px;margin-top: 10px;"><span style="font-size: 10px;">套餐价：</span><input name="unit_price[]" type="text" placeholder="套餐价" style="margin-left: 19px"></div>
                    </li>
                    <!--<li id="sort" class=" clearfix"><label class="label_name"><i>*</i>设置折扣：</label> <input name="discount" type="number" class="add_text"/></li>
                    <li id="sort" class=" clearfix"><label class="label_name"><i>*</i>设置价格：</label> <input name="package_price" type="number" class="add_text"/></li>
                    -->
                    <li id="address" class=" clearfix"><label class="label_name"><i></i>结束时间：</label> <input id="datetimepicker7" name="endtime" type="text" class="add_text" type="text"/></li>
                    <li id="describe" class=" clearfix"><label class="label_name">套餐描述：</label> <textarea id="describe" name="introduce" cols="" rows="" class="textarea"></textarea>
                    <li class=" clearfix"><label class="label_name"><i></i>是否启用：</label>
                        <label><input name="status" type="radio" class="ace"  value="1" /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input name="status" type="radio" class="ace" checked="checked" value="0" /><span class="lbl">否</span></label>
                    </li>
                    <li><div class=""><input type="submit" id="btn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></div></li>
                </ul>
        </form>
    </div>
</div>
</body>
</html>
<script src="/assets/js/jquery.validate.js"></script>
<script src="/js/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
$(function(){
    var logic = function( currentDateTime ){
        if (currentDateTime && currentDateTime.getDay() == 6){
            this.setOptions({
                minTime:'11:00'
            });
        }else
            this.setOptions({
                minTime:'8:00'
            });
    };
    $('#datetimepicker7').datetimepicker({
        onChangeDateTime:logic,
        onShow:logic
    });

    $('.selected1').change(function(){
        var catid = $(this).val();
        var url = '/product/addpackage';
        $.post(url,{catid:catid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $(".child1").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('.child1').append('<option value='+item.id+'>'+item.name+'</option>');

            });
        })
        $('.child1').show();
    })

    $('.child1').change(function(){
        var goodsid = $(this).val();
        var url = '/product/addpackage';
        $.post(url,{goodsid:goodsid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $(".childs1").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('.childs1').append('<option value='+item.id+'>'+item.model_number+'</option>');

            });
        })
        $('.childs1').show();
    })

    $('.childs1').change(function(){
        var modelid = $(this).val();
        var url = '/product/addpackage';
        $('.price1').show();
        $('.goodsnum1').show();
        $('.unit_price1').show();
        $('#brandname2').show();
        $.post(url,{modelid:modelid},function(data){
            if(data)
            {
                $('.price1 input').val(data);
            }
        });
    })
    $('.selected2').change(function(){
        var catid = $(this).val();
        var url = '/product/addpackage';
        $.post(url,{catid:catid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $(".child2").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('.child2').append('<option value='+item.id+'>'+item.name+'</option>');
            });
        })
        $('.child2').show();
    })

    $('.child2').change(function(){
        var goodsid = $(this).val();
        var url = '/product/addpackage';
        $.post(url,{goodsid:goodsid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $(".childs2").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('.childs2').append('<option value='+item.id+'>'+item.model_number+'</option>');

            });
        })
        $('.childs2').show();
    })
    $('.childs2').change(function(){
        var modelid = $(this).val();
        var url = '/product/addpackage';
        $('.price2').show();
        $('.goodsnum2').show();
        $('.unit_price2').show();
        $('#brandname3').show();
        $.post(url,{modelid:modelid},function(data){
            if(data)
            {
                $('.price2 input').val(data);
            }
        });
    })
    $('.selected3').change(function(){
        var catid = $(this).val();
        var url = '/product/addpackage';
        $.post(url,{catid:catid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $(".child3").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('.child3').append('<option value='+item.id+'>'+item.name+'</option>');
            });
        })
        $('.child3').show();
    })
    $('.child3').change(function(){
        var goodsid = $(this).val();
        var url = '/product/addpackage';
        $.post(url,{goodsid:goodsid},function(data){
            var parsedJson = jQuery.parseJSON(data);
            $(".childs3").find("option").not(":first").remove();
            $.each(parsedJson, function(i, item) {
                $('.childs3').append('<option value='+item.id+'>'+item.model_number+'</option>');

            });
        })
        $('.childs3').show();
    })
    $('.childs3').change(function(){
        var modelid = $(this).val();
        var url = '/product/addpackage';
        $('.price3').show();
        $('.goodsnum3').show();
        $('.unit_price3').show();
        $.post(url,{modelid:modelid},function(data){
            if(data)
            {
                $('.price3 input').val(data);
            }
        });
    })
})
</script>
<script>
/*
    $(function() {
// 在键盘按下并释放及提交后验证提交表单
        $("#commentForm").validate({
            rules: {
                selected: {
                    required: true,
                },
                selected2: {
                    required: true,
                },
                goodsname1:{
                    required:true,
                },
                goodsname2:{
                    required:true,
                },
                discount:{
                    required: true,
                    min:0,
                },
                packagename: {
                    required: true,
                    minlength: 2
                },
            },
            messages: {
                selected:{
                    required:"必选",
                },
                selected2:{
                    required:"必选",
                },
                goodsname1:{
                    required:"必选",
                },
                goodsname2:{
                    required:"必选",
                },
                packagename: {
                    required: "请输入商品名称",
                    minlength: "名称大于两个字"
                },
                discount:{
                    required: "商品价格必须输入",
                    min: "价格不能小于0",
                },
            }
        });
    });*/
</script>


