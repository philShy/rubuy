<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css"/>
    <link href="assets/css/codemirror.css" rel="stylesheet">
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
    <script src="/assets/dist/echarts.js"></script>
    <title>交易金额 - 素材牛模板演示</title>
</head>
<style>
    #page .page_right a{text-decoration:none;display:inline-block;
        width:40px; height: 25px;font-size: 14px;color: #fff;background: #6fb3e0;
        margin-left: 3px;line-height: 25px;}
    #page .page_right a:hover{background: #438eb9}
</style>
<body>
<div class="margin clearfix">
    <div class="amounts_style">
        <div class="transaction_Money clearfix">
            <div class="Money"><span >成交总额：<em>￥</em><?php echo ($amount_arr) ;?>元
                </span><p style="font-size: 10px;"><?php if($starttime && $endtime){echo '统计时间：'.$starttime.'至'.$endtime;}else{echo '最新统计时间：'.date('Y-m-d',(time()));}?></p></div>
            <div class="Money"><span ><em>￥</em><?php echo $amount_today;?>元</span><p style="font-size: 10px;">当天成交额</p></div>
        </div>
        <div class="border clearfix">
      <span class="l_f">
      <a id="all_order" href="/transaction/amounts?code=2" class="btn btn-info">全部订单</a>
      <a id="today" href="/transaction/amounts?code=1" class="btn btn-danger">当天订单</a>
      <form action="" method="post" id="choose_time" style="float: right">
          <input class="inline laydate-icon" placeholder=" 开始时间" id="startdata" name="starttime" style=" margin-left:10px;">
          <input class="inline laydate-icon" placeholder=" 结束时间" id="enddata" name="endtime" style=" margin-left:10px;">
          <input type="submit" value="提交" class="btn btn-danger" />
      </form>

       </span>
            <span class="r_f">共：<b><?php echo $count;?></b>笔</span>
        </div>
        <div class="Record_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="100px">序号</th>
                    <th width="200px">订单编号</th>
                    <th width="180px">成交时间</th>
                    <th width="120px">成交金额(元)</th>
                    <th width="180px">状态</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($success_order as $key=>$value):?>
                <tr>
                    <td><?php echo $value['id'];?></td>
                    <td><?php echo $value['order_id'];?></td>
                    <td><?php echo $value['end_time'];?></td>
                    <td><?php echo $value['price']*$value['num'];?></td>
                    <td><?php if($value['state']==4)echo '交易成功';?></td>
                </tr>
                <?php endforeach;?>
                <tr>
                    <td colspan="5">

                        <div id="page">
                            <div class=page_left style="float: left">当前第：<?php if($current){echo $current.'/'.ceil($count/2);}
                                else{echo $page.'/'.ceil($count/2);}?>页</div>
                            <div class=page_right style="float: right">
                                <?php
                                    echo CPage::newsPage($page,ceil($count/2),$where,$url);
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="Statistics" style="display:none">
    <div id="main" style="height:400px; overflow:hidden; width:1000px; overflow:auto" ></div>
</div>
</body>
</html>
<script>

    $(function() {
        /*var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [],//默认第几个排序
            "bStateSave": false,//状态保存
            //"dom": 't',
            "bFilter":false,
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[1,2,3,4]}// 制定列不参与排序
            ] } );
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });*/
    })
    //时间选择
    laydate({
        elem: '#startdata',
        event: 'focus'
    });

    laydate({
        elem: '#enddata',
        event: 'focus'
    });
</script>
