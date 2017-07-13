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
    <script type="text/javascript" src="/js/H-ui.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <script src="/assets/js/jquery.easy-pie-chart.min.js"></script>
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <title>订单管理 - 素材牛模板演示</title>
</head>
<style>
    .table_order {border:1px; border-collapse:collapse; width:100%; height:100%;}
    .table_order td{border:solid 1px #ccc;text-align:center;height: }
    .table_order table td{ border:0;text-align:left;padding:3px;}
    ul li{float:left}
    .list_right_style{margin-left: 0 !important;}
    #page .page_right a{text-decoration:none;display:inline-block;
        width:40px; height: 25px;font-size: 14px;color: #fff;background: #6fb3e0;
        margin-left: 3px;line-height: 25px;}
    #page .page_right a:hover{background: #2a8bcc}
</style>
<body>
<div class="margin clearfix">
    <div class="cover_style" id="cover_style">
        <div class="top_style Order_form" id="Order_form_style">
            <div class="type_title">购物产品比例
            </div>
            <!--<div class="hide_style clearfix">
                <?php /*foreach( $cate_array as $key=>$value):*/?>
                <div class="proportion"> <div class="easy-pie-chart percentage" data-percent="<?php /*echo $value['percentage']*/?>" data-color="#D15B47"><span class="percent"><?php /*echo $value['percentage']*/?></span>%</div><span class="name"><?php /*echo $value['name']*/?></span></div>
                <?php /*endforeach;*/?>
            </div>-->
        </div>
        <!--内容-->
        <div class="centent_style" id="centent_style">
            <div class="search_style">
                <form action="/transaction/orderform" method="post">
                    <ul class="search_content clearfix">
                        <li><label class="l_f">订单编号</label><input name="order_id" type="text" class="text_add" placeholder="订单订单编号" style=" width:250px"></li>
                        <li><label class="l_f">开始时间</label><input class="inline laydate-icon" name="starttime" id="starttime" style=" margin-left:10px;"></li>
                        <li><label class="l_f">结束时间</label><input class="inline laydate-icon" name="endtime" id="endtime" style=" margin-left:10px;"></li>
                        <li style="width:90px;"><input type="submit" class="btn_search"></li>
                    </ul>
                </form>

            </div>
                    <!--订单列表展示-->
            <table class="table_order" width="100%" cellspacing="0" >
                <thead>
                <tr>
                    <td width="130px">订单编号</td>
                    <td width="500px" >
                        <div>商品详情</div>
                        <ul>
                            <li style="width:150px;">&nbsp;</li>
                            <li style="width:180px;text-align:left">商品名</li>
                            <li style="width:90px;text-align:left">单价</li>
                            <li style="width:90px;text-align:left">数量</li>
                        </ul>
                    </td>
                    <td width="100px">总价</td>
                    <td width="180px">订单时间</td>
                    <td width="100px">发票类型</td>
                    <td width="120px">订单状态</td>
                    <td width="200px">操作</td>
                </tr>
                <tr></tr>
                </thead>
                <tbody>
                <?php foreach($order_arr as $key=>$value):?>
                <tr>
                    <td><?php echo $value['id']?></td>
                    <td>
                        <table class="order_detail" width="100%" cellpadding="4" cellspacing="0" border="0" style="border: none; ">
                            <tr>
                                <td width="150px"></td>
                                <td width="150px"></td>
                                <td width="100px"></td>
                                <td width="100px"></td>
                            </tr>
                            <?php if($value['brand_order']):?>
                            <?php foreach($value['brand_order'] as $brand_k=>$brand_v):?>
                            <?php if(!empty($brand_v['brand_id'])):?>
                            <tr>
                                <td colspan="5" style="background: #eee">品牌：<span style="color: #ccc"><?php $brand_name =CProduct::searchBrandbyid($brand_v['brand_id']); echo $brand_name['brandname']?></span></td>
                            </tr>
                            <?php foreach($brand_v['data'] as $b_k=>$b_v):?>
                            <?php $one_detail = CProduct::searchGoodsmodelbyid($b_v['model_id']);$img = CImages::searchOne($b_v['model_id']);?>
                            <tr>
                                <td >
                                    <div>
                                        <img src="<?php echo $img['images_url']?>" style="width:100px;height: 100px">
                                    </div>
                                </td>
                                <td>
                                    <div  style="width: 180px;overflow: hidden">
                                        <?php echo $one_detail['name']; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $one_detail['price']; ?>
                                </td>
                                <td>
                                    <?php echo $b_v['num']?>
                                </td>
                            </tr>
                                            <tr>
                                                <td colspan="5" style="border-bottom: 1px dashed #eee"></td>
                                            </tr>
                            <?php endforeach;?>
                            <?php endif;?>
                        <?php endforeach;?>
                        <?php endif;?>
                        <?php if($value['meal_order']):?>
                            <tr>
                                <td colspan="5" style="background: #eee">套餐商品</td>
                            </tr>
                            <?php foreach($value['meal_order'] as $meal_k=>$meal_v):?>
                            <?php foreach($meal_v as $m_k=>$m_v):?>
                            <?php $meal_detail = CProduct::searchGoodsmodelbyid($m_v['good_model_id']);$meal_img = CImages::searchOne($m_v['good_model_id']);?>
                            <tr>
                                <td >
                                    <div>
                                        <img src="<?php echo $meal_img['images_url']?>" style="width:100px;height:100px">
                                    </div>
                                </td>
                                <td>
                                    <div  style="width: 180px;overflow: hidden">
                                        <?php echo $meal_detail['name']; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php echo $m_v['unit_price']; ?>
                                </td>
                                <td>
                                    <?php echo $m_v['quantity']?>
                                </td>
                            </tr>
                                    <tr>
                                        <td colspan="5" style="border-bottom: 1px dashed #eee"></td>
                                    </tr>
                            <?php endforeach;?>
                            <?php endforeach;?>
                        <?php endif;?>
                        </table>
                    </td>
                    <td><?php echo $value['price']?></td>
                    <td><?php echo $value['create_time']?></td>
                    <td>
                        <?php if($value['invoice']['invoice_type'] == 1):?>
                            个人发票
                        <?php elseif($value['invoice']['invoice_type'] == 2):?>
                            增值发票
                        <?php else:?>
                            电子发票
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if($value['is_send'] == 0):?>
                            未发货<br/>
                        <?php else:?>
                            已发货<br/>
                        <?php endif;?>
                        <?php if($value['status'] == 0):?>
                            <span style="color: white;background: #438eb9">已取消</span>
                        <?php elseif($value['status'] == 1):?>
                            <span style="color: white;background: #438eb9">未支付</span>
                        <?php else:?>
                            <span style="color: white;background: #438eb9">已支付</span>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if($value['status'] != 0): ?>
                            <a href='javascript:;' orderid='<?php echo $value['id']?>' title='发货'  class='btn btn-xs btn-success Delivery_stop1'><i class='fa fa-cubes bigger-120'></i></a>
                        <?php endif;?>
                        <a title="订单详细"  href="/transaction/orderdetail?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info order_detailed" ><i class="fa fa-list bigger-120"></i></a>
                        <a title="删除" href="javascript:;"  onclick="Order_form_del(this,'<?php echo $value['id']?>')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
                        <!--<tr>
                            <td colspan="8">
                                <div id="page">
                                    <div class=page_left style="float: left">当前第：<?php /*if($current){echo $current.'/'.ceil($count/2);}
                                        else{echo $page.'/'.ceil($count/2);}*/?>页</div>
                                    <div class=page_right style="float: right">
                                        <?php
/*                                        echo CPage::newsPage($page,ceil($count/2),$where,$url);
                                        */?>
                                    </div>
                                </div>
                            </td>
                        </tr>-->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--发货-->
<div id="Delivery_stop" style=" display:none">
    <div class="">
        <div class="content_style">
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">快递公司 </label>
                <div class="col-sm-9"><select class="form-control" id="form-field-select-1">
                        <option value="">--选择快递--</option>
                        <option value="天天快递">天天快递</option>
                        <option value="圆通快递">圆通快递</option>
                        <option value="中通快递">中通快递</option>
                        <option value="顺丰快递">顺丰快递</option>
                        <option value="申通快递">申通快递</option>
                        <option value="邮政EMS">邮政EMS</option>
                        <option value="邮政小包">邮政小包</option>
                        <option value="韵达快递">韵达快递</option>
                    </select></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 快递号 </label>
                <div class="col-sm-9"><input type="text" id="form-field-1" placeholder="快递号" class="col-xs-10 col-sm-5" style="margin-left:0px;"></div>
            </div>
            <div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="form-field-1">货到付款 </label>
                <div class="col-sm-9"><label><input name="checkbox" type="checkbox" class="ace" id="checkbox"><span class="lbl"></span></label></div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function(){
        $('.order_product_name').find('.fa-plus:last').hide()
        $('.order_product_catename').find('.catename:last').hide()
    })
    /**发货**/
    $(function () {
        $('.Delivery_stop1').click(function(){
            $_this = $(this);
            var orderid = $(this).attr('orderid');
            layer.open({
                type: 1,
                title: '发货',
                maxmin: true,
                shadeClose:false,
                area : ['500px' , ''],
                content:$('#Delivery_stop'),
                btn:['确定','取消'],
                yes: function(index, layero){
                    var url = '/transaction/orderform';
                    var logistics_num = $('#form-field-1').val();
                    //var send_method = $('#form-field-select-1').val();
                    if($('#form-field-1').val()==""){
                        layer.alert('快递号不能为空！',{
                            title: '提示框',
                            icon:0,
                        })
                    }else{
                        layer.confirm('提交成功！',function(index){
                            $.post(url,{order_id:orderid,logistics_num:logistics_num},function(data){
                                if(data){
                                    $_this.parents("tr").find(".td-manage").prepend('<a style=" display:none" class="btn btn-xs btn-success" onClick="member_stop(this,id)" href="javascript:;" title="已发货"><i class="fa fa-cubes bigger-120"></i></a>');
                                    $_this.parents("tr").find(".td-status").html('<span>已发货</span>');
                                    $_this.remove();
                                    layer.msg('已发货!',{icon: 6,time:1000});
                                }
                            })
                        });
                        layer.close(index);
                    }
                }
            })
        })
    })

    //时间选择
    laydate({
        elem: '#starttime',
        event: 'focus'
    });
    laydate({
        elem: '#endtime',
        event: 'focus'
    });
    /*订单-删除*/
    function Order_form_del(obj,id){
        var url = '/transaction/orderform';
        var orderid = id;
        layer.confirm('确认要删除吗？',{icon:0,},function(index){
            $.ajax({
                type: "POST",
                url: url,
                data: {order_id:orderid,is_delete:1},
                dataType: "json",
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                }
            });
        });
    }

    var oldie = /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase());
    $('.easy-pie-chart.percentage').each(function(){
        $(this).easyPieChart({
            barColor: $(this).data('color'),
            trackColor: '#EEEEEE',
            scaleColor: false,
            lineCap: 'butt',
            lineWidth: 10,
            animate: oldie ? false : 1000,
            size:103
        }).css('color', $(this).data('color'));
    });

    $('[data-rel=tooltip]').tooltip();
    $('[data-rel=popover]').popover({html:true});
</script>
