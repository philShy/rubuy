<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <link href="/Widget/icheck/icheck.css" rel="stylesheet" type="text/css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <title>添加产品分类 - 素材牛模板演示</title>
</head>
<body>
<div class="type_style">
    <div class="type_title">产品类型信息</div>
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
    <div class="type_content">
        <div class="Operate_btn" style="width:400px">
            <a href="javascript:ovid()" class="btn  btn-warning" id="increase"><i class="icon-edit align-top bigger-125" ></i>新增子类型</a>
            <a href="javascript:ovid()" class="btn  btn-danger" id="del"><i class="icon-trash   align-top bigger-125"></i>删除该类型</a>
        </div>
        <form action="" method="post" class="form form-horizontal" id="form-user-add">
            <div class="Operate_cont clearfix">
                <label class="form-label"><span class="c-red">*</span>选择类别：</label>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="id" id="selected" style="width:163px">
                    <option value="0">顶级分类</option>
                    <?php foreach($list as $key=>$value): ?>
                        <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                            <option value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                        <?php endif?>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="Operate_cont clearfix">
                <label class="form-label"><span class="c-red">*</span>修改名称：</label>
                <div class="formControls ">
                    <input type="text" class="input-text" value="" placeholder="" id="name" name="name">
                </div>
            </div>
            <div class="Operate_cont clearfix">
                <label class="form-label"><span class="c-red">*</span>修改排序：</label>
                <div class="formControls ">
                    <input type="text" class="input-text" value="" placeholder="" id="sort" name="sort">

                    <input type="hidden" value="" id="pth" name="pth">
                </div>
            </div>
            <div class="Operate_cont clearfix child">
                <label class="form-label"><span class="c-red">*</span>子类名称：</label>
                <div class="formControls ">
                    <input type="text" class="input-text" value="" placeholder="" id="childName" name="childName">
                </div>
            </div><div class="Operate_cont clearfix child">
                <label class="form-label"><span class="c-red">*</span>子类排序：</label>
                <div class="formControls ">
                    <input type="text" class="input-text" value="" placeholder="" id="childSort" name="childSort">
                </div>
            </div>
            <div class="" >
                <div class="" style=" text-align:center; float:left;margin-left: 110px;">
                    <!--<input class="btn btn-primary radius" type="submit" value="提交">-->
                    <a class="btn btn-primary radius" href="javascript:void(0)" id="submit">提交</a>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript" src="/Widget/icheck/jquery.icheck.min.js"></script>
<script type="text/javascript" src="/Widget/Validform/5.3.2/Validform.min.js"></script>
<script type="text/javascript" src="/assets/layer/layer.js"></script>
<script type="text/javascript" src="/js/H-ui.js"></script>
<script type="text/javascript" src="/js/H-ui.admin.js"></script>
<script type="text/javascript">

    $(function(){

        $(".child").hide();
        $('#increase').click(function(){
            $('.child').toggle()
        })


        $("#selected").change(function(){
            var id = $('#selected').val()
           $.post("/product/categoryadd",{id:id},function(data)
           {
               var myobj=eval('('+data+')');
               $('#sort').val(myobj.sort);
               $('#name').val(myobj.name);
               $('#pth').val(myobj.pth);
           })
        });

        $("#del").click(function(){
            var id = $('#selected').val();
            var pth = $('#pth').val();
            if(id == 0){
                layer.alert('顶级分类不能删除');
                return false;
            }
            $.post("/product/categoryadd",{id:id,mark:'del',pth:pth},function(data)
            {

                if(data==''){
                    layer.alert('请先删除子类别');
                    return false;
                }else{
                    layer.alert('删除类别成功');
                    setInterval(function(){
                        window.parent.location.href="/product/category";
                    },3000)

                }

            })
        });


        $("#submit").click(function(){
            var id = $('#selected').val();
            var name = $('#name').val();
            var sort = $('#sort').val();
            var childName = $('#childName').val();
            var childSort = $('#childSort').val();
            var pth = $('#pth').val();
            if(id == 0 && (childName==''|| childSort==''))
            {
                layer.alert('不好意思,顶级分类不能修改');
                return false
            }else
            {
                $.post("/product/categoryadd",
                    {id:id,name:name,sort:sort,pth:pth,childName:childName,childSort:childSort,mark:'submit'},
                    function(data)
                    {layer.alert('操作成功！');
                        setInterval(function(){
                            window.parent.location.href="/product/category";
                        },3000)
                    })
                return false;
            }
            if(name == '' || sort == ''){
                layer.alert('类别名称或类别顺序不能为空');
                return false;
            }
            if(childName){
                if(childSort == '')
                layer.alert('子类别顺序不能为空');
                return false;
            }
            if(childSort){
                if(childName == '')
                    layer.alert('子类别名称不能为空');
                return false;
            }

                /*layer.alert('操作成功！');
                $.post("/product/categoryadd",
                 {id:id,name:name,sort:sort,pth:pth,childName:childName,childSort:childSort,mark:'submit'},
                 function(data)
                 {
                     setInterval(function(){
                         window.parent.location.href="/product/category";
                     },3000)
                 })*/


        });


    });
</script>
</body>
</html>