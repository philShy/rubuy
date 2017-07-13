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
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>

    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <title>退款管理 - 素材牛模板演示</title>
</head>

<body>
<div class="margin clearfix">
    <div id="refund_style">
        <div class="search_style">

            <ul class="search_content clearfix">
                <li><label class="l_f">订单号</label><input name="" type="text" class="text_add" placeholder="输入订单号" style=" width:250px"></li>
                <li><label class="l_f">退款时间</label><input placeholder="开始时间" class="inline laydate-icon" name="startdate" id="startdate" style=" margin-left:10px;">
                <input placeholder="截止时间" class="inline laydate-icon" name="enddate" id="enddate" style=" margin-left:10px;"></li>
                <li style="width:90px;"><button type="button" class="btn_search"><i class="fa fa-search"></i>查询</button></li>
            </ul>
        </div>
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" class="btn btn-success Order_form"><i class="fa fa-check-square-o"></i>&nbsp;已退款订单</a>
        <a href="javascript:ovid()" class="btn btn-warning Order_form"><i class="fa fa-close"></i>&nbsp;未退款订单</a>

       </span>
            <span class="r_f">共：<b>2334</b>笔</span>
        </div>
        <!--退款列表-->
        <div class="refund_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="25px"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="120px">订单编号</th>
                    <th width="250px">产品名称</th>
                    <th width="100px" style="display: none">交易金额</th>
                    <th width="180px">交易时间</th>
                    <th width="100px">退款金额</th>
                    <th width="80px">退款数量</th>
                    <th width="70px">状态</th>
                    <th width="200px">说明</th>
                    <th width="200px">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($refund_arr as $key=>$value):?>
                <tr>
                    <td><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                    <td class="orderid"><?php echo $value['order_id']?></td>
                    <td class="order_product_name">
                        <a href="#"><?php echo $value['name'].'【'.$value['model_number'].'】'?></a>
                    </td>
                    <td style="display: none"></td>
                    <td><?php echo $value['create_time']?></td>
                    <td><?php echo $value['price']?></td>
                    <td><?php echo $value['num']?></td>
                    <td class="td-status">
                        <span>
                            <?php
                            if($value['state'] ==0) {echo '审核中';}
                            elseif($value['state'] ==1){echo '已退款';}
                            else{echo '不同意';}
                            ?>
                        </span></td>
                    <td><?php echo $value['reason']?></td>
                    <td>
                        <?php if($value['state'] !=1):?>
                        <a href="javascript:;" orderid="<?php echo $value['order_id']?>" pid="<?php echo $value['refund_pid']?>" title="退款"  class="btn btn-xs btn-success btn_ref">退款</a>
                        <?php endif;?>
                        <a title="退款订单详细"  href="/transaction/refunddetail?pid=<?php echo $value['refund_pid']?>&order_id=<?php echo $value['order_id']?>"  class="btn btn-xs btn-info Refund_detailed" >详细</a>
                        <a title="删除" href="javascript:;"  onclick="Order_form_del(this,'1')" class="btn btn-xs btn-warning" >删除</a>
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
    //订单列表
    jQuery(function($) {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,3,4,5,6,8,9]}// 制定列不参与排序
            ] } );
        //全选操作
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });
    });
    $(function(){
        $('.btn_ref').click(function(){
            $_this = $(this);
            var url = '/transaction/refund';
            var orderid = $(this).attr('orderid');
            var pid = $(this).attr('pid');
            layer.confirm('是否同意退款！',function(index){
                $.post(url,{state:1,orderid:orderid,pid:pid},function(data){
                    if(data == 1){
                        $_this.parents("tr").find(".td-manage").prepend('<a style=" display:none" class="btn btn-xs btn-success" onClick="member_stop(this,id)" href="javascript:;" title="已退款">退款</a>');
                        $_this.parents("tr").find(".td-status").html('<span>已退款</span>');
                        $_this.remove();
                    }
                })
                window.location.href='/transaction/refund';
            });
        })
    })



    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Refund_detailed').on('click', function(){
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
    laydate({
        elem: '#startdate',
        event: 'focus'
    });

    laydate({
        elem: '#enddate',
        event: 'focus'
    });
</script>