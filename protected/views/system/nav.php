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
    <title>系统栏目 - 素材牛模板演示</title>
</head>

<body>
<div class="Columns_style margin">
    <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()"id="add_page" class="btn btn-warning" onclick="add_article_sort()"><i class="fa fa-plus"></i> 添加导航</a>
       </span>
        <span class="r_f">共：<b>5</b>分类</span>
    </div>
    <table class="table table-striped table-bordered table-hover" id="sample-table">
        <thead>
        <tr>
            <th width="80px">ID</th>
            <th width="120px">栏目名称</th>
            <th style="display: none" width="120px">等级</th>
            <th width="250px">链接</th>
            <th width="150px">添加时间</th>
            <th width="80px">排序</th>
            <th width="100px">状态</th>
            <th width="200px">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($nav as $key=>$value):?>
        <tr>
            <td><?php echo $value['id']?></td>
            <td><?php echo $value['nav_name']?></td>
            <td style="display: none" >一级</td>
            <td><?php echo $value['nav_url']?></td>
            <td><?php echo $value['create_time']?></td>
            <td><?php echo $value['nav_sort']?></td>
            <td class="td-status">
                <?php if($value['stadus'] == 0):?>
                <span class="label label-success radius">已启用</span>
                <?php elseif($value['stadus'] == 1):?>
                <span class="label label-defaunt radius">停用</span>
                <?php endif;?>
            </td>
            <td class="td-manage">
                <?php if($value['stadus'] == 0):?>
                    <a onclick="member_stop(this,'<?php echo $value['id']?>')" href="javascript:;" title="启用" class="btn btn-xs btn-success"><i class="fa fa-check  bigger-120"></i></a>
                <?php elseif($value['stadus'] == 1):?>
                    <a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,'<?php echo $value['id']?>')" href="javascript:;" title="启用"><i class="fa fa-close bigger-120"></i></a>
                <?php endif;?>
                <a title="编辑" onclick="member_edit('<?php echo $value['id']?>')" href="javascript:;"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
<!--添加文章分类图层-->
<div id="addsort_style" style="display:none" class="article_style">
    <div class="add_content" id="form-article-add">
        <ul>
            <li class="clearfix Mandatory"><label class="label_name"><i>*</i>导航名称</label>
                <span class="formControls w_txt"><input name="nav-name" type="text" id="form-field-1" class="col-xs-7 col-sm-5  nav-name"></span>
            </li>
            <li class="clearfix Mandatory" style="width: 100%"><label class="label_name">导航链接</label>
                <span class="formControls w_txt"><input style="width: 41.5%" name="nav-url" type="text" id="form-field-1" class="col-xs-7 col-sm-2 nav-url"></span>
            </li>
            <li class="clearfix Mandatory"><label class="label_name">排序</label>
                <span class="formControls w_txt"><input type="number" min="0" name="nav-sort" type="text" id="form-field-1" class="col-xs-7 col-sm-2 nav-sort"></span>
            </li>
        </ul>
    </div>
</div>
</body>
</html>
<script>
    /**添加分类**/
    function add_article_sort(index){
        layer.open({
            type: 1,
            title: '添加导航',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#addsort_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var num=0;
                var str="";
                $(".Mandatory input[type$='text']").each(function(n){
                    if($(this).val()=="")
                    {
                        layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                            title: '提示框',
                            icon:0,
                        });
                        num++;
                        return false;
                    }
                });
                if(num>0){  return false;}
                else{
                    var url = '/system/nav';
                    var nav_name = $('.nav-name').val();
                    var nav_sort = $('.nav-sort').val();
                    var nav_url = $('.nav-url').val();
                    $.post(url,{nav_name:nav_name,nav_url:nav_url,nav_sort:nav_sort},function(data){
                        if(data){
                            layer.alert('添加成功！',{
                                title: '提示框',
                                icon:1,
                            });
                            window.location.href='/system/nav'
                        }
                    })
                    layer.close(index);
                }
            }
        })
    }
    //编辑文章分类
    function member_edit(iid){
        var url = '/system/nav';
        if(iid){
            $.post(url,{navid:iid},function(data){
                var dataObj=eval("("+data+")");
                if(data){
                    $('.nav-name').val(dataObj['nav_name']);
                    $('.nav-sort').val(dataObj['nav_sort']);
                    $('.nav-url').val(dataObj['nav_url']);
                }
            })
        }
        layer.open({
            type: 1,
            title: '编辑导航',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area : ['600px' , ''],
            content:$('#addsort_style'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var num=0;
                var str="";
                $(".Mandatory input[type$='text']").each(function(n){
                    if($(this).val()=="")
                    {
                        layer.alert(str+=""+$(this).attr("name")+"不能为空！\r\n",{
                            title: '提示框',
                            icon:0,
                        });
                        num++;
                        return false;
                    }
                });
                if(num>0){  return false;}
                else{
                    //var url = '/article/sort';
                    var nav_name = $('.nav-name').val();
                    var nav_sort = $('.nav-sort').val();
                    var nav_url = $('.nav-url').val();
                    $.post(url,{nav_id:iid,nav_name:nav_name,nav_sort:nav_sort,nav_url:nav_url},function(data){
                        console.log(data)
                        if(data){
                            layer.alert(
                                '修改成功！',
                                {title: '提示框', icon:1,},
                                function(index){
                                    window.location.href='/system/nav'
                                });
                        }
                    })
                    layer.close(index);
                }
            }
        })
    }
</script>
<script>
    $(function() {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [],//默认第几个排序
            "bStateSave": false,//状态保存
            //"dom": 't',
            "bFilter":false,
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,1,2,3,4,5,6,7]}// 制定列不参与排序
            ] } );
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
        });
    })
    /*栏目-停用*/
    function member_stop(obj,id){
        $_id = id;
        var url = '/system/nav';
        layer.confirm('确认要停用该栏目吗？',function(index){
            $.ajax({
                type:'POST',
                url:url,
                data:{nav_id:id,stadus:1},
                dataType: "json",
                success:function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,$_id)" href="javascript:;" title="启用"><i class="fa fa-close bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">停用</span>');
                    $(obj).remove();
                    layer.msg('停用!',{icon: 5,time:1000});
                }
            })
        });
    }
    /*栏目-启用*/
    function member_start(obj,id){
        var url = '/system/nav';
        $_id = id;
        layer.confirm('确认要启用该栏目吗？',function(index){
            $.ajax({
                type:'POST',
                url:url,
                data:{nav_id:id,stadus:'sure'},
                dataType: "json",
                success:function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success" onClick="member_stop(this, $_id)" href="javascript:;" title="停用"><i class="fa fa-check bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">启用</span>');
                    $(obj).remove();
                    layer.msg('启用!',{icon: 6,time:1000});
                }
            })
        });
    }
    /*店铺-删除*/
    function member_del(obj,id){
        var url = '/system/nav';
        layer.confirm('确认要删除吗？',{icon:0,},function(index){
            $.ajax({
                type:'POST',
                url:url,
                data:{nav_id:id,is_delete:1},
                dataType: "json",
                success:function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            })
        });
    }
</script>
