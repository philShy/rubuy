<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <script src="/assets/js/typeahead-bs2.min.js"></script>

    <!-- page specific plugin scripts -->
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="/js/H-ui.js"></script>
    <script type="text/javascript" src="/js/H-ui.admin.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/assets/dist/echarts.js"></script>
    <script src="/js/lrtk.js" type="text/javascript"></script>
    <title>品牌管理 - 素材牛模板演示</title>
</head>

<body>
<div class="page-content clearfix">
    <div id="brand_style">
        <div class="search_style">

            <ul class="search_content clearfix">
                <form action="/product/brand" method="post" id="searchform">
                    <li><label class="l_f">品牌名称</label>&nbsp;&nbsp;
                        <select name="brand_name" style="width:100px">
                            <option value="0">---选择品牌---</option>
                            <?php
                            foreach($brandarr as $key=>$value)
                                echo "<option value=$value[id]>$value[brandname]</option>";
                            ?>
                        </select>
                    </li>
                    <li><label class="l_f">添加时间</label><input name="create_time" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>

                    <li style="width:90px;"><button type="button" class="btn_search"><i class="icon-search"></i>查询</button></li>
                </form>

            </ul>
        </div>
        <div class="border clearfix">
       <span class="l_f">
        <a href="/product/addbrand"  title="添加品牌" class="btn btn-warning Order_form"><i class="icon-plus"></i>添加品牌</a>
        <a style="display:none" href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a>

       </span>
            <span class="r_f">共：<b><?php echo $count;?></b>个品牌</span>
        </div>
        <!--品牌展示-->


            <!--品牌列表-->
            <div class="table_menu_list">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25px"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="80px">ID</th>
                        <th width="50px">排序</th>
                        <th width="120px">品牌LOGO</th>
                        <th width="120px">品牌名称</th>
                        <th width="130px">所属地区/国家</th>
                        <th width="350px">描述</th>
                        <th width="180px">加入时间</th>
                        <th width="70px">状态</th>
                        <th width="200px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($brandarr as $key=>$value):?>
                    <tr>

                        <td width="25px"><label><input type="checkbox" class="ace" ><span class="lbl"></span></label></td>
                        <td  class="brand_id"  width="80px"><?php echo $value['id']?></td>
                        <td width="80px"><?php echo $value['sort']?></td>
                        <td><img src="<?php echo $value['images_url']?>"  width="50"/></td>
                        <td width="80px"><?php echo $value['brandname']?></td>
                        <td><?php echo $value['is_delete']?></td>
                        <td class="text-l"><?php echo $value['id']?></td>
                        <td><?php echo $value['create_time']?></td>
                        <td class="td-status">
                            <?php if($value['state'] == 0):?>
                            <span class="label label-success radius">已启用</span>
                            <?php elseif($value['state'] == 1):?>
                            <span class="label label-success radius">已停用</span>
                            <?php endif;?>
                        </td>
                        <td class="td-manage">
                            <?php if($value['state'] == 0):?>
                            <a onClick="member_stop(this,'<?php echo $value['id']?>')"  href="javascript:;" title="停用"  class="btn btn-xs btn-success"><i class="icon-ok bigger-120"></i></a>
                            <?php elseif($value['state'] == 1):?>
                            <a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,<?php echo $value['id']?>)" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>
                            <?php endif;?>
                            <a title="编辑" onclick="member_edit('编辑','member-add.html','4','','510')" href="javascript:;"  class="btn btn-xs btn-info" ><i class="icon-edit bigger-120"></i></a>
                            <a title="删除" href="javascript:;"  onclick="member_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="icon-trash  bigger-120"></i></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
    </div>
</div>
</body>
</html>
<script>

    jQuery(function($) {
        $('.btn_search').click(function(){
            $('#searchform').submit()
        })

        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,1,3,4,5,6,8,9]}// 制定列不参与排序
            ] } );


    });

    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Order_form ,.brond_name').on('click', function(){
        var cname = $(this).attr("title");
        var cnames = parent.$('.Current_page').html();
        var herf = parent.$("#iframe").attr("src");
        parent.$('#parentIframe span').html(cname);
        parent.$('#parentIframe').css("display","inline-block");
        parent.$('.Current_page').attr("name",herf).css({"color":"#4c8fbd","cursor":"pointer"});
        //parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+">" + cnames + "</a>");
        parent.layer.close(index);

    });
    function generateOrders(id){
        window.location.href = "Brand_detailed.html?="+id;
    };
    /*品牌-查看*/
    function member_show(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*品牌-停用*/
    function member_stop(obj,id){
        var url = "/product/brand";
        var brand_id = id;
        $_id=id;
        layer.confirm('确认要停用吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {brand_id:brand_id,state:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs " onClick="member_start(this,$_id)" href="javascript:;" title="启用"><i class="icon-ok bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
                    $(obj).remove();
                    layer.msg('已停用!',{icon: 5,time:1000});
                }
            });
        });
    }

    /*用户-启用*/
    function member_start(obj,id){
        var url = "/product/brand";
        var brand_id = id;
        $_id=id;
        layer.confirm('确认要启用吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {brand_id:brand_id,state:'sure'},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" class="btn btn-xs btn-success" onClick="member_stop(this,$_id)" href="javascript:;" title="停用"><i class="icon-ok bigger-120"></i></a>');
                    $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                    $(obj).remove();
                    layer.msg('已启用!',{icon: 6,time:1000});
                }
            });
        });
    }
    /*品牌-编辑*/
    function member_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }

    /*品牌-删除*/
    function member_del(obj,id){
        var url = "/product/brand";
        var brand_id = id;
        $_id=id;
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {brand_id:brand_id,is_delete:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }

</script>
<script type="text/javascript">
    require.config({
        paths: {
            echarts: './assets/dist'
        }
    });
    require(
        [
            'echarts',
            'echarts/chart/pie',   // 按需加载所需图表，如需动态类型切换功能，别忘了同时加载相应图表
            'echarts/chart/funnel'
        ],
        function (ec) {
            var myChart = ec.init(document.getElementById('main'));

            option = {
                title : {
                    text: '国内国外品牌比例',
                    subtext: '',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data:['国内品牌','国外品牌']
                },
                toolbox: {
                    show : false,
                    feature : {
                        mark : {show: false},
                        dataView : {show: false, readOnly: false},
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 545
                                }
                            }
                        },
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                series : [
                    {
                        name:'品牌数量',
                        type:'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data:[
                            {value:335, name:'国内品牌'},
                            {value:210, name:'国外品牌'},

                        ]
                    }
                ]
            };
            myChart.setOption(option);
        }
    );
</script>