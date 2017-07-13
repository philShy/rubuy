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
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/js/displayPart.js" type="text/javascript"></script>
    <title>文章管理</title>
</head>

<body>
<div class="clearfix">
    <div class="article_style" id="article_style">
        <div id="scrollsidebar" class="left_Treeview">
            <div class="show_btn" id="rightArrow"><span></span></div>
            <div class="widget-box side_content" >
                <div class="side_title"><a title="隐藏" class="close_btn"><span></span></a></div>
                <div class="side_list">
                    <div class="widget-header header-color-green2">
                        <h4 class="lighter smaller">所属文档分类</h4>
                    </div>
                    <div class="widget-body">
                        <ul class="b_P_Sort_list">
                            <li><i class="orange  fa fa-list "></i><a style="text-decoration: none" href="/system/doc_list?param=0">全部(<?php echo $count_all?>)</a></li>
                            <?php foreach($cate_arr as $key=>$value):?>
                                <li><i class="fa fa-newspaper-o pink "></i> <a style="text-decoration: none" href="/system/doc_list?param=<?php echo $value['doc_category_id']?>"><?php echo $value['name'].'('.$value['count'].')'?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--文章列表-->
        <div class="Ads_list">
            <div class="border clearfix">
       <span class="l_f">
        <a href="/system/add_doc"  title="添加文档" id="add_page" class="btn btn-warning"><i class="fa fa-plus"></i> 添加文档</a>
           <!-- <a href="javascript:ovid()" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>-->
       </span>
                <span class="r_f">共：<b><?php echo $count_where?></b>条文档</span>
            </div>
            <div class="article_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="80px">ID</th>
                        <th width="100px">是否推荐</th>
                        <th style="display: none">所属分类</th>
                        <th width="220px">标题</th>
                        <th width="">简介</th>
                        <th width="160px">添加时间</th>
                        <th width="80px">状态</th>
                        <th width="200px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($doc_arr as $key=>$value):?>
                        <tr>
                            <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                            <td><?php echo $value['id']?></td>
                            <td><?php if($value['is_recommend'] ==0 ){echo '正常';}else if($value['is_recommend'] ==1){echo '推荐';}else if($value['is_recommend'] ==2){echo '主推';}?></td>
                            <td style="display: none"><?php echo $value['article_category_id']?></td>
                            <td><?php echo $value['title']?></td>
                            <td><?php echo $value['introduce']?></td>
                            <td><?php echo $value['create_time']?></td>
                            <td class="td-status">
                                <?php if($value['states'] == 0):?>
                                    <span class="label label-success radius">已发布</span>
                                <?php elseif($value['states'] == 1):?>
                                    <span class="label label-defaunt radius">未发布</span>
                                <?php endif;?>
                            </td>
                            <td class="td-manage">
                                <?php if($value['states'] == 0):?>
                                    <a onClick="member_stop(this,'<?php echo $value['id']?>')"  href="javascript:;" title="取消发布" class="btn btn-xs btn-success"><i class="fa fa-check  bigger-120"></i></a>
                                <?php elseif($value['states'] == 1):?>
                                    <a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,'<?php echo $value['id']?>')" href="javascript:;" title="发布"><i class="fa fa-close bigger-120"></i></a>
                                <?php endif;?>
                                <a title="编辑"  href="/system/edit_doc?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                                <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        $(".displayPart").displayPart();
    });
    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('#add_page').on('click', function(){
        var cname = $(this).attr("title");
        var chref = $(this).attr("href");
        var cnames = parent.$('.Current_page').html();
        var herf = parent.$("#iframe").attr("src");
        parent.$('#parentIframe').html(cname);
        parent.$('#iframe').attr("src",chref).ready();;
        parent.$('#parentIframe').css("display","inline-block");
        parent.$('.Current_page').attr({"name":herf,"href":"javascript:void(0)"}).css({"color":"#4c8fbd","cursor":"pointer"});
        //parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+" class='iframeurl'>" + cnames + "</a>");
        parent.layer.close(index);

    });
    $(function() {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,3,4,5,7,8]}// 制定列不参与排序
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

    $(function() {
        $("#article_style").fix({
            float : 'left',
            //minStatue : true,
            skin : 'green',
            durationTime :false,
            stylewidth:'220',
            spacingw:30,//设置隐藏时的距离
            spacingh:250,//设置显示时间距
            set_scrollsidebar:'.Ads_style',
            table_menu:'.Ads_list'
        });
    });
    //初始化宽度、高度
    $(".widget-box").height($(window).height());
    $(".Ads_list").width($(window).width()-220);
    //当文档窗口发生改变时 触发
    $(window).resize(function(){
        $(".widget-box").height($(window).height());
        $(".Ads_list").width($(window).width()-220);
    });
    /*用户-停用*/
    function member_stop(obj,id){
        var url = "/system/doc_list";
        var doc_id = id;
        layer.confirm('确认取消发布吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {doc_id:doc_id,state:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,id)" href="javascript:;" title="发布"><i class="fa fa-close bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">未发布</span>');
                    $(obj).remove();
                    layer.msg('未发布!',{icon: 5,time:1000});
                }
            });
        });
    }
    /*用户-启用*/
    function member_start(obj,id){
        var url = "/system/doc_list";
        var doc_id = id;
        layer.confirm('确认要发布吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {doc_id:doc_id,state:'sure'},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success" onClick="member_stop(this,id)" href="javascript:;" title="取消发布"><i class="fa fa-check  bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已发布</span>');
                    $(obj).remove();
                    layer.msg('已发布!',{icon: 6,time:1000});
                }
            });
        });
    }
    /*文档-删除*/
    function member_del(obj,id){
        var url = "/system/doc_list";
        var doc_id = id;
        layer.confirm('确认要删除吗？',{icon:0,},function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {doc_id:doc_id,is_delete:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }

</script>
