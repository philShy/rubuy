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
    <link href="/assets/css/codemirror.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/font/css/font-awesome.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/assets/css/ace-ie.min.css" />
    <![endif]-->
    <script src="/js/jquery-1.9.1.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <title>分类管理 - 素材牛模板演示</title>
</head>

<body>
<div class="page-content clearfix">
    <div class="sort_style">
        <div class="border clearfix">
       <span class="l_f">
        <a href="javascript:ovid()" id="sort_add" class="btn btn-warning"><i class="fa fa-plus"></i> 添加分类</a>
            <a style="display: none" href="javascript:ovid()" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>
       </span>
            <span class="r_f">共：<b><?php echo $count;?></b>类</span>
        </div>
        <div class="sort_list">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="25px" style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                    <th width="60px">ID</th>
                    <th width="100px">分类名称</th>
                    <th width="60px">数量</th>
                    <th width="350px">描述</th>
                    <th width="180px">加入时间</th>
                    <th width="70px">状态</th>
                    <th width="250px">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($result as $key=>$value):?>
                <tr>
                    <td style="display: none"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></td>
                    <td class="image_id"><?php echo $value['id']?></td>
                    <td><?php echo $value['name']?></td>
                    <td><?php echo $value['id']?></td>
                    <td><?php echo $value['introduce']?></td>
                    <td><?php echo $value['create_time']?></td>
                    <td class="td-status" width='80px'><?php if($value['is_delete'] == 0){echo "<span width='80px'>已启用</span>";}else{echo "<span width='80px'>已停用</span>";} ?></td>
                    <td class="td-manage">
                        <?php if($value['is_delete'] == 0){echo "<a href='javascript:;' title='停用' class='btn btn-xs btn-success jia'><i class='fa fa-check  bigger-120'></i></a>";}else{echo "<a href='javascript:;' title='启用' class='btn btn-xs btn-default jia'><i class='fa fa-check  bigger-120'></i></a>";} ?>
                        <a title="编辑"  href="/images/editimagesclass?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="fa fa-edit bigger-120"></i></a>
                        <a title="删除" href="javascript:;"  onclick="member_del(this,'1')" class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></i></a>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--添加分类-->
<div class="sort_style_add margin" id="sort_style_add" style="display:none">
    <div class="">
        <ul>
            <li><label class="label_name">分类名称</label><div class="col-sm-9"><input name="分类名称" type="text" id="form-field-1" placeholder="" class="col-xs-10 col-sm-5"></div></li>
            <li><label class="label_name">分类说明</label><div class="col-sm-9"><textarea name="分类说明" class="form-control" id="form-field-8" placeholder="" onkeyup="checkLength(this);"></textarea><span class="wordage">剩余字数：<span id="sy" style="color:Red;">200</span>字</span></div></li>
            <li><label class="label_name">分类状态</label>
      <span class="add_content"> &nbsp;&nbsp;<label><input name="form-field-radio1" type="radio" checked="checked" value="0" class="ace"><span class="lbl">显示</span></label>&nbsp;&nbsp;&nbsp;
     <label><input name="form-field-radio1" type="radio" value="1" class="ace"><span class="lbl">隐藏</span></label></span>
            </li>
        </ul>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    $('#sort_add').on('click', function(){
        layer.open({
            type: 1,
            title: '添加分类',
            maxmin: true,
            shadeClose: false, //点击遮罩关闭层
            area : ['750px' , ''],
            content:$('#sort_style_add'),
            btn:['提交','取消'],
            yes:function(index,layero){
                var num=0;
                var str="";
                var url = "/images/imagesclass";
                var name = $('#form-field-1').val();
                var introduce = $('#form-field-8').val();
                var is_delete = $('input:radio[name="form-field-radio1"]:checked').val();

                $(".sort_style_add input[type$='text']").each(function(n){
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
                    $.post(url,{name:name,introduce:introduce,is_delete:is_delete},function(data){
                        if(data == 1){
                            layer.alert('添加成功！',{
                                title: '提示框',
                                icon:1,
                            });
                            layer.close(index,2);
                            setInterval(function(){window.location.href = '/images/imagesclass'},1000)

                        }
                    });
                }
            }
        });
    })


    function checkLength(which) {
        var maxChars = 200; //
        if(which.value.length > maxChars){
            layer.open({
                icon:2,
                title:'提示框',
                content:'您出入的字数超多限制!',
            });
            // 超过限制的字数了就将 文本框中的内容按规定的字数 截取
            which.value = which.value.substring(0,maxChars);
            return false;
        }else{
            var curr = maxChars - which.value.length; //250 减去 当前输入的
            document.getElementById("sy").innerHTML = curr.toString();
            return true;
        }
    };
    $('.td-manage .jia').click(function(){
        var title = $(this).parent("td").parent("tr").find(".td-status").text();
        var image_id = $(this).parent("td").parent("tr").find(".image_id").text();
        var url = "/images/imagesclass";
        var obj = $(this).parent('td');
        if(title == '已停用'){

                    layer.confirm('确认要启用吗？',function(index){
                        $.post(url,{is_delete:0,image_id:image_id},function(data){
                            if(data==1){
                             //$(obj).parent("tr").find(".td-status span").attr("class","label label-success radius");
                             $(obj).find('.jia').attr('class','btn btn-xs btn-success')
                             $(obj).parent("tr").find(".td-status").text('已启用');
                             layer.msg('已启用!',{icon: 6,time:1000});
                             window.location.href="/images/imagesclass";
                             }
                        })
                    });

        }else if(title == '已启用'){
                    layer.confirm('确认要停用吗？',function(index){
                        $.post(url,{is_delete:1,image_id:image_id},function(data){
                            if(data==1){
                                    //$(obj).parent("tr").find(".td-status span").attr("class","label label-default radius");
                                    $(obj).find('.jia').attr('class','btn btn-xs ')
                                    $(obj).parent("tr").find(".td-status").text('已停用');
                                    layer.msg('已停用!',{icon: 5,time:1000});
                                    window.location.href="/images/imagesclass";
                            }
                        })
                    });
        }
    })
    /*广告图片-删除*/
    function member_del(obj,id){
        var image_id = $(obj).parents("tr").find(".image_id").text();
        var url = "/images/imagesclass";
        layer.confirm('确认要删除吗？',function(index){
            $.post(url,{image_id:image_id,mark:'del'},function(data){
                if(data==1){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                    window.location.href="/images/imagesclass";
                }
            })
        });
    }

    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Order_form ,.ads_link').on('click', function(){
        var cname = $(this).attr("title");
        var cnames = parent.$('.Current_page').html();
        var herf = parent.$("#iframe").attr("src");
        parent.$('#parentIframe span').html(cname);
        parent.$('#parentIframe').css("display","inline-block");
        parent.$('.Current_page').attr("name",herf).css({"color":"#4c8fbd","cursor":"pointer"});
        //parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+">" + cnames + "</a>");
        parent.layer.close(index);

    });
    function AdlistOrders(id){
        window.location.href = "Ads_list.html?="+id;
    };
</script>
<script type="text/javascript">
    jQuery(function($) {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,4,6,7,]}// 制定列不参与排序
            ] } );
        $('table th input:checkbox').on('click' , function(){
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });
        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
        }
    })
</script>