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
        <form action="/product/editpackage" method="post" enctype="multipart/form-data" id="commentForm">
            <input type="hidden" value="<?php echo $packagearr['id']?>" name="package_id">
                <ul class="add_conent" style="margin-top: 0;">
                    <li id="sort" class=" clearfix"><label class="label_name"><i>*</i>套餐名称：</label> <input name="packagename" type="text" value="<?php echo $packagearr['name']?>" class="add_text" /></li>
                    <li id="brandname1" class=" clearfix"><label class="label_name" ><i>*</i>套餐商品：</label>
                        <select name="selected" class="selected1" style="width:163px">
                            <option value="">----选择类别----</option>
                            <?php foreach($list as $key=>$value): ?>
                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                    <option <?php if($model[1]['cate_id']==$value['id']){echo 'selected';}?> value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsname1" class="child1" style="width:123px;">
                            <option value="" >----选择商品----</option>
                            <?php foreach($goodsarr[1] as $key=>$value):?>
                                <option <?php if($value['id'] == $model[1]['goods_id']){echo 'selected';}?>><?php echo $value['name']?></option>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsmodel[]" class="childs1" style="width:123px;">
                            <option value="" >----选择型号----</option>
                            <?php foreach($modelarr[1] as $key=>$value):?>
                                <option value="<?php echo $value['id']?>" <?php if($value['id'] == $model[1]['model_id']){echo 'selected';}?>><?php echo $value['model_number']?></option>
                            <?php endforeach;?>
                        </select>
                        <div class="price1" style="width:30%;display: ;margin-left: 28px;margin-top: 10px;">原&nbsp;&nbsp;&nbsp;价：<input  name="price[]" type="text" value="<?php echo $model[1]['price']?>" style="margin-left: 16px" readonly></div>
                        <div class="goodsnum1"  style="width:30%;display: ;margin-left: 28px;margin-top: 10px;" >数&nbsp;&nbsp;&nbsp;量：<input  name="goodsnum[]" type="text" value="<?php echo $model[1]['quantity']?>" style="margin-left: 16px"></div>
                        <div class="unit_price1" style="width:30%;display: ;margin-left: 28px;margin-top: 10px;"><span style="font-size: 10px;">套餐价：</span><input name="unit_price[]" type="text" value="<?php echo $model[1]['unit_price']?>" style="margin-left: 19px"></div>

                       <!-- <input class="goodsnum1" name="goodsnum[]" type="text" value="<?php /*echo $model[1]['quantity']*/?>" style="width:100px;display: ">
                        <input class="unit_price1" name="unit_price[]" type="text" value="<?php /*echo $model[1]['unit_price']*/?>" style="width:100px;display: ">
                    -->
                    </li>
                    <li id="brandname2" class=" clearfix" style="display: "><label class="label_name" ><i>*</i>套餐商品：</label>
                        <select class="selected2" style="width:163px" name="selected2">
                            <option value="">--选择类别--</option>
                            <?php foreach($list as $key=>$value): ?>
                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                    <option <?php if($model[2]['cate_id']==$value['id']){echo 'selected';}?> value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsname2" class="child2" style="width:123px;display:">
                            <option value="" >----选择商品----</option>
                            <?php foreach($goodsarr[2] as $key=>$value):?>
                                <option <?php if($value['id'] == $model[2]['goods_id']){echo 'selected';}?>><?php echo $value['name']?></option>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsmodel[]" class="childs2" style="width:123px;display:">
                            <option value="" >----选择型号----</option>
                            <?php foreach($modelarr[2] as $key=>$value):?>
                                <option value="<?php echo $value['id']?>" <?php if($value['id'] == $model[2]['model_id']){echo 'selected';}?>><?php echo $value['model_number']?></option>
                            <?php endforeach;?>
                        </select>
                        <div class="price2" style="width:30%;display: ;margin-left: 28px;margin-top: 10px;">原&nbsp;&nbsp;&nbsp;价：<input  name="price[]" type="text" value="<?php echo $model[2]['price']?>" style="margin-left: 16px" readonly></div>
                        <div class="goodsnum2"  style="width:30%;display: ;margin-left: 28px;margin-top: 10px;" >数&nbsp;&nbsp;&nbsp;量：<input  name="goodsnum[]" type="text" value="<?php echo $model[2]['quantity']?>" style="margin-left: 16px"></div>
                        <div class="unit_price2" style="width:30%;display: ;margin-left: 28px;margin-top: 10px;"><span style="font-size: 10px;">套餐价：</span><input name="unit_price[]" type="text" value="<?php echo $model[2]['unit_price']?>" style="margin-left: 19px"></div>

                        <!--<input class="goodsnum2" name="goodsnum[]" type="text" value="<?php /*echo $model[2]['quantity']*/?>" style="width:100px;display: ">
                        <input class="unit_price2" name="unit_price[]" type="text" value="<?php /*echo $model[2]['unit_price']*/?>" style="width:100px;display: ">
                    -->
                    </li>
                    <li id="brandname3" class=" clearfix" style="<?php if(empty($goodsarr[3])){ echo 'display:none';}?>"><label class="label_name" ><i>*</i>套餐商品：</label>
                        <select class="selected3" style="width:163px">
                            <option value="">--选择类别--</option>
                            <?php foreach($list as $key=>$value): ?>
                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                    <option <?php if($model[3]['cate_id']==$value['id']){echo 'selected';}?> value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select>
                        <select name="goodsname3" class="child3" style="width:123px;display:">
                            <option value="" >----选择商品----</option>
                            <?php if($goodsarr[3]):?>
                                <?php foreach($goodsarr[3] as $key=>$value):?>
                                <option <?php if($value['id'] == $model[3]['goods_id']){echo 'selected';}?>><?php echo $value['name']?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                        </select>
                        <select name="goodsmodel[]" class="childs3" style="width:123px;display:">
                            <option value="" >----选择型号----</option>
                            <?php if($modelarr[3]):?>
                            <?php foreach($modelarr[3] as $key=>$value):?>
                                <option value="<?php echo $value['id']?>" <?php if($value['id'] == $model[3]['model_id']){echo 'selected';}?>><?php echo $value['model_number']?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                        </select>
                        <div class="price3" style="width:30%;display: ;margin-left: 28px;margin-top: 10px;">原&nbsp;&nbsp;&nbsp;价：<input  name="price[]" type="text" value="<?php echo $model[3]['price']?>" style="margin-left: 16px" readonly></div>
                        <div class="goodsnum3"  style="width:30%;display: ;margin-left: 28px;margin-top: 10px;" >数&nbsp;&nbsp;&nbsp;量：<input  name="goodsnum[]" type="text" value="<?php echo $model[3]['quantity']?>" style="margin-left: 16px"></div>
                        <div class="unit_price3" style="width:30%;display: ;margin-left: 28px;margin-top: 10px;"><span style="font-size: 10px;">套餐价：</span><input name="unit_price[]" type="text" value="<?php echo $model[3]['unit_price']?>" style="margin-left: 19px"></div>

                        <!--<input class="goodsnum3" name="goodsnum[]" type="text" value="<?php /*echo $model[3]['quantity']*/?>" style="width:100px;display: ">
                        <input class="unit_price3" name="unit_price[]" type="text" value="<?php /*echo $model[3]['unit_price']*/?>" style="width:100px;display: ">
                    -->
                    </li>
                    <!--<li id="sort" class=" clearfix"><label class="label_name"><i>*</i>套餐折扣：</label> <input name="discount" value="<?php /*echo $packagearr['discount']*/?>" type="number" class="add_text"/></li>
                    <li id="sort" class=" clearfix"><label class="label_name"><i>*</i>套餐价格：</label> <input name="package_price" value="<?php /*echo $packagearr['price']*/?>" type="number" class="add_text"/></li>
                    -->
                    <li id="address" class=" clearfix"><label class="label_name"><i>*</i>结束时间：</label> <input id="datetimepicker7" value="<?php echo $packagearr['create_time']?>" name="endtime" type="text" class="add_text" type="text"/></li>
                    <li id="describe" class=" clearfix"><label class="label_name">套餐描述：</label> <textarea id="describe" name="introduce" cols="" rows="" class="textarea"><?php echo $packagearr['introduce']?></textarea>
                    <li class=" clearfix"><label class="label_name"><i>*</i>是否启用：</label>
                        <label><input name="status" <?php if($packagearr['is_delete']==0){echo 'checked';} ?> type="radio" class="ace"  value=0 /><span class="lbl">是</span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label><input name="status" <?php if($packagearr['is_delete']==1){echo 'checked';} ?> type="radio" class="ace"  value=1 /><span class="lbl">否</span></label>
                    </li>
                    <li><input type="submit" id="btn" class="btn btn-warning" value="保存"/><input type="reset" value="取消" class="btn btn-warning"/></li>
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
            var url = '/product/editpackage';
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
            var url = '/product/editpackage';
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
            $('#brandname2').show();
        })
        $('.selected2').change(function(){
            var catid = $(this).val();
            var url = '/product/editpackage';
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
            var url = '/product/editpackage';
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
            $('#brandname3').show();
        })
        $('.selected3').change(function(){
            var catid = $(this).val();
            var url = '/product/editpackage';
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
            var url = '/product/editpackage';
            $.post(url,{goodsid:goodsid},function(data){
                var parsedJson = jQuery.parseJSON(data);
                $(".childs3").find("option").not(":first").remove();
                $.each(parsedJson, function(i, item) {
                    $('.childs3').append('<option value='+item.id+'>'+item.model_number+'</option>');

                });
            })
            $('.childs3').show();
        })
    })
</script>
<script>

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
    });
</script>


