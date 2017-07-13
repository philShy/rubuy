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
    <link rel="stylesheet" href="/Widget/zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
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
    <script type="text/javascript" src="/Widget/zTree/js/jquery.ztree.all-3.5.min.js"></script>
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <title>产品列表 - 素材牛模板演示</title>
</head>
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
$list = t($catearr);
?>
<style>
    .search_content li{width:20%;float: left}
</style>
<body>
<div class=" page-content clearfix">
    <div id="products_style">
        <div class="search_style">
            <form action="/product/list" method="post">
                <ul class="search_content clearfix">
                    <li><label class="l_f">类别名称</label>&nbsp;<select name="cate" style="width:60%">
                            <option value="0">选择类别</option>
                            <?php foreach($list as $key=>$value): ?>
                                <?php $count = substr_count($value['pth'],',');$str = '&nbsp;';if($count):?>
                                    <option value=<?php echo $value['id']?>><?php echo str_repeat($str,($count)*4).$value['name'];?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select></li>
                    <li><label class="l_f">品牌名称</label>&nbsp;<select name="brand" style="width:60%">
                            <option value="0">选择品牌</option>
                            <?php
                            foreach($brandarr as $key=>$value)
                                echo "<option value=$value[id]>$value[brandname]</option>";
                            ?>
                        </select></li>
                    <li><label class="l_f">商品名称</label><input name="searchName" type="text"   placeholder="输入商品名"  style="width:55%"/></li>
                    <li><label class="l_f">添加时间</label><input name="searchDate" class="inline laydate-icon" id="start" style="width:60%"></li>
                    <li style="width: 5%"><input type="submit" value="查询" class="btn_search"  style="width:50px"></li>
                </ul>
            </form>
        </div>
        <div class="border clearfix">
       <span class="l_f">
        <a href="/product/add" title="添加商品" class="btn btn-warning Order_form"><i class="icon-plus"></i>添加商品</a>
        <!--<a href="javascript:ovid()" class="btn btn-danger"><i class="icon-trash"></i>批量删除</a>-->
       </span>
            <span class="r_f">共：<b><?php echo $goods_num; ?></b>件商品</span>
        </div>
        <!--产品列表展示-->
        <div class="h_products_list clearfix" id="products_list">
            <div id="scrollsidebar" class="left_Treeview">
                <div class="show_btn" id="rightArrow"><span></span></div>
                <div class="widget-box side_content" style="width:0">

                </div>
            </div>
            <div class="table_menu_list" id="testIframe" style="margin-left: 0;">
                <table class="table table-striped table-bordered table-hover" id="sample-table">
                    <thead>
                    <tr>
                        <th width="25px"><label><input type="checkbox" class="ace"><span class="lbl"></span></label></th>
                        <th width="80px">产品编号</th>
                        <th width="250px">产品名称</th>
                        <th width="100px">产品型号</th>
                        <th width="100px">原价格</th>
                        <th width="100px">现价</th>
                        <th width="180px">加入时间</th>
                        <th width="80px">套餐状态</th>
                        <th width="70px">是否上架</th>
                        <th width="200px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($result as $key=>$value):?>
                        <tr>
                        <td width="25px"><label><input type="checkbox" class="ace" ><span class="lbl"></span></label></td>
                        <td class="goods_id" width="80px"><?php echo $value['id']?></td>
                        <td width="250px"><?php echo $value['name']?></td>
                        <td width="100px"><?php echo $value['model_number']?></td>
                        <td width="100px"><?php echo $value['price']?></td>
                        <td width="100px"><?php echo $value['preferential_price']?></td>
                        <td width="180px"><?php echo $value['create_time']?></td>
                        <td class="text-l"><?php if($value['is_package'] === 0 )echo '开启';else echo '关闭'; ?></td>
                        <td class="td-status"><?php if($value['is_publish'] == 0){echo "<span>已上架</span>";}else{echo "<span>已下架</span>";} ?></td>
                        <td class="td-manage">
                            <?php if($value['is_publish'] == 0){echo "<a href='javascript:;' title='下架' class='btn btn-xs btn-success jia'><i class='icon-ok bigger-120'></i></a>";}else{echo "<a href='javascript:;' title='上架' class='btn btn-xs btn-default jia'><i class='icon-ok bigger-120'></i></a>";} ?>
                            <a title="编辑" href="/product/edit?id=<?php echo $value['id']?>"  class="btn btn-xs btn-info" ><i class="icon-edit bigger-120"></i></a>

                            <a title="删除" href="javascript:;"  onclick="member_del(this,'1')" class="btn btn-xs btn-warning" ><i class="icon-trash  bigger-120"></i></a>
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
    jQuery(function($) {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,2,3,4,5,8,9]}// 制定列不参与排序
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
    });
    laydate({
        elem: '#start',
        event: 'focus'
    });
    $(function() {
        $("#products_style").fix({
            float : 'left',
            //minStatue : true,
            skin : 'green',
            durationTime :false,
            spacingw:30,//设置隐藏时的距离
            spacingh:260,//设置显示时间距
        });
    });
</script>
<script type="text/javascript">
    //初始化宽度、高度
    $(".widget-box").height($(window).height()-215);
    $(".table_menu_list").width($(window).width());
    $(".table_menu_list").height($(window).height()-215);
    //当文档窗口发生改变时 触发
    $(window).resize(function(){
        $(".widget-box").height($(window).height()-215);
        $(".table_menu_list").width($(window).width());
        $(".table_menu_list").height($(window).height()-215);
    })

    function showCode(str) {
        if (!code) code = $("#code");
        code.empty();
        code.append("<li>"+str+"</li>");
    }

    $(document).ready(function(){
        var t = $("#treeDemo");
        t = $.fn.zTree.init(t, setting, zNodes);
        demoIframe = $("#testIframe");
        demoIframe.bind("load", loadReady);
        var zTree = $.fn.zTree.getZTreeObj("tree");
        zTree.selectNode(zTree.getNodeByParam("id",'11'));
    });
    /*产品-停用*/

    $('.td-manage .jia').click(function(){
        var title = $(this).parent("td").parent("tr").find(".td-status").text();
        var goods_id = $(this).parent("td").parent("tr").find(".goods_id").text();
        var  url = "/product/list";
        var obj = $(this).parent('td');
        if(title == '已下架'){
            layer.confirm('确认要上架吗？',function(index){
                $.post(url,{is_publish:0,goods_id:goods_id},function(data){
                    $(obj).parent("tr").find(".td-status span").attr("class","label label-success radius");
                    $(obj).find('.jia').attr('class','btn btn-xs btn-success')
                    $(obj).parent("tr").find(".td-status").text('已上架');
                    layer.msg('已上架!',{icon: 6,time:1000});
                    window.location.href='/product/list'
                })
            });
        }else if(title == '已上架'){
            layer.confirm('确认要下架吗？',function(index){
                $.post(url,{is_publish:1,goods_id:goods_id},function(data){
                    $(obj).parent("tr").find(".td-status span").attr("class","label label-default radius");
                    $(obj).find('.jia').attr('class','btn btn-xs ')
                    $(obj).parent("tr").find(".td-status").text('已下架');
                    layer.msg('已下架!',{icon: 5,time:1000});
                    window.location.href='/product/list'
                })
            });
        }
    })
    /*产品-删除*/
    function member_del(obj,id){
        var model_id = $(obj).parents("tr").find(".goods_id").text();
        var  url = "/product/edit";
        layer.confirm('确认要删除吗？',function(index){
            $.post(url,{model_id:model_id,mark:'del'},function(data){
                if(data){
                    window.location.href="/product/list";
                }
            })
        });
    }
    //面包屑返回值
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.iframeAuto(index);
    $('.Order_form').on('click', function(){
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
</script>
