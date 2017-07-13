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
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <title>退款详细 - 素材牛模板演示</title>
</head>
<style>
    button{color:#fff;border:1px solid #2a8bcc;background: #2a8bcc;border-radius:2px; width:60px;height:30px;}
</style>
<body>
<div class="margin clearfix">
    <div class="Refund_detailed">
        <div class="Numbering">订单编号:<b><?php echo $refundDetail['order_id']?></b></div>
        <div class="detailed_style">
            <!--退款信息-->
            <div class="Receiver_style">
                <div class="title_name">退款信息</div>
                <div class="Info_style clearfix">
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款人姓名： </label>
                        <div class="o_content"><?php echo $refundDetail['consignee']?></div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款人电话： </label>
                        <div class="o_content"><?php echo $refundDetail['consignee_tel']?></div>
                    </div>
                    <!--<div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款方式：</label>
                        <div class="o_content">银联</div>
                    </div>-->
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款数量：</label>
                        <div class="o_content"><?php echo $refundDetail['num']?></div>
                    </div>
                    <!--<div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 快递名称：</label>
                        <div class="o_content">圆通</div>
                    </div>-->
                    <!--<div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 快递单号：</label>
                        <div class="o_content">3456789090</div>
                    </div>-->
                    <!--<div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款账户：</label>
                        <div class="o_content">招商储蓄卡</div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款账号：</label>
                        <div class="o_content">345678*****5678</div>
                    </div>-->
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款金额：</label>
                        <div class="o_content"><?php echo $refundDetail['num']*$refundDetail['price']?>元</div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 退款日期：</label>
                        <div class="o_content">2016-7-29</div>
                    </div>
                    <div class="col-xs-3">
                        <label class="label_name" for="form-field-2"> 状态：</label>
                        <div class="o_content">
                            <?php if($refundDetail['state'] == 0):?>
                                审核中
                            <?php elseif($refundDetail['state'] == 1):?>
                                退款成功
                            <?php else:?>
                                不同意
                            <?php endif?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Receiver_style">
                <div class="title_name">退款说明</div>
                <div class="reund_content">
                    <?php echo $refundDetail['reason']?>
                </div>
            </div>

            <!--产品信息-->
            <div class="product_style">
                <div class="title_name">产品信息</div>
                <div class="Info_style clearfix">
                    <div class="product_info clearfix">
                        <a href="#" class="img_link"><img src="/images/product/<?php echo $refundDetail['pic']?>"></a>
                          <span>
                          <p><?php echo $refundDetail['name'].'【'.$refundDetail['model_number'].'】'?></p>
                          <p>规格：500g/斤</p>
                          <p>数量：<?php echo $refundDetail['num']?></p>
                          <p>价格：<b class="price"><i>￥</i><?php echo $refundDetail['price']?></b></p>
                          <?php if($refundDetail['state'] == 0):?>
                          <p class="status">审核中</p>
                          <?php elseif($refundDetail['state'] == 1):?>
                          <p class="status">退款成功</p>
                          <?php else:?>
                          <p class="status">不同意</p>
                          <?php endif?>
                          </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div id="reply" style=" display:none ">
            <textarea style="margin-left: 0px;width:37%;" class="reply"  rows="5" cols="0"><?php echo $refundDetail['reply']?></textarea>
            <div><span style="color:red"> *</span><span style="color:#ccc">如果不同意请填写理由</span></div>
        </div>
        <div style="margin-top:10px;">
            <span>是否同意退款：</span>
            <input type="radio" value="1" name="isagree" checked="checked">是
            <input type="radio" value="2" name="isagree">否<br/><br/>
            <button id="agree">提交</button>
            <input class="pid" type="hidden" value="<?php echo $refundDetail['refund_pid']?>">
            <input class="orderid" type="hidden" value="<?php echo $refundDetail['order_id']?>">
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function(){
        $('input[type=radio][name=isagree]').change(function() {
            if (this.value == 2) {
                $('#reply').show();
            }else{
                $('#reply').hide();
            }
        });
        $('#agree').click(function(){
            var isagree = $("input[name='isagree']:checked").val();
            var url = '/transaction/refunddetail';
            var orderid = $('.orderid').val();
            var pid = $('.pid').val();
            var reply = $('.reply').val()
            if(isagree==1){
                $.post(url,{state:1,orderid:orderid,refund_pid:pid},function(data){
                    if(data == 1) {
                        alert('退款成功！')
                        window.location.href='/transaction/refund';
                    }else{
                        alert('同意退款失败！')
                    }
                })
            }else if(isagree==2){
                $.post(url,{state:2,orderid:orderid,refund_pid:pid,reply:reply},function(data){
                    if(data == 1) {
                        alert('OK')
                        window.location.href='/transaction/refund';
                    }
                })
            }
        })
    })

    /*$(function(){
        $('#agree').click(function(){
            var url = '/transaction/refunddetail';
            var orderid = $('.orderid').val();
            var pid = $('.pid').val();
            $.post(url,{state:1,orderid:orderid,refund_pid:pid},function(data){
                if(data == 1) {
                    alert('退款成功！')
                    window.location.href='/transaction/refund';
                }else{
                    alert('同意退款失败！')
                }
            })
        })
        $('#notagree').click(function(){
            var url = '/transaction/refunddetail';
            var orderid = $('.orderid').val();
            var pid = $('.pid').val();
            var reply = $('.reply').val()
            alert(reply);
            $.post(url,{state:2,orderid:orderid,refund_pid:pid,reply:reply},function(data){
                if(data == 1) {
                    alert('OK')
                    window.location.href='/transaction/refund';
                }
            })
        })
    })*/
</script>
