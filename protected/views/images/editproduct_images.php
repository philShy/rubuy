<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="./styles/global.css"  rel="stylesheet"  type="text/css" media="all" />
    <script type="text/javascript" src="./scripts/jquery-1.6.4.js"></script>
    <title>Insert title here</title>
</head>
<style>
    #selectFileBtn{background: #438eb9;border-radius: 3px;color:white ;margin-left: 5px;}
    a{text-decoration: none}
    .btn{margin-left: 10px;display: inline-block;background: #438eb9;border-radius: 2px;width:43px;color:#fff}
    .attachItem{width:180px;background: #ccc;float: left;border-radius: 3px;margin-left: 5px;margin-top: 5px;}
    .left{float:left}
    .right{float:right}
    .right a{display:block;margin-top:3px;width:16px;height:16px;overflow: hidden;text-indent:-9999px; background:url(/images/delete.png); }
    table tr:nth-child(odd){background:#eee;}
    table tr:hover{background:#eee;}
    .smt{background: #ffb752;border:1px solid #ffb752;border-radius: 3px;width:50px;height:30px;color:#fff;cursor: pointer}
</style>
<body>
<h3>修改产品图片</h3>
<form action="/images/editproduct_images" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $model_id;?>">
    <table width="70%" cellpadding="5" rules="all" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd">
        <tr height="30px;">
            <td align="right">商品名称</td>
            <td><?php echo $model_number;?></td>
        </tr>
        <tr>
            <td align="right">商品图片操作</td>
            <td>
                <ul style="margin:0;padding:0;">
                    <?php foreach ( $product_images as $img ):?>
                    <li style="width:120px;height:130px;float:left;list-style:none;">
                        <div align="center"><img style="height:100px;width:100px;" src="<?php echo 'product/'.$img['images_url'];?>" alt="" /></div>
                        <div>
                            <a href="javascript:void (0)" class="btn del" sort=<?php echo $img['sort'];?> picid = <?php echo $img['id'];?>>&nbsp;删除</a>
                            <?php if($img['sort']!=1):?>
                            <a href='javascript:void (0)' class='btn moveup' sort=<?php echo $img['sort'];?> picid = <?php echo $img['id'];?>>&nbsp;上移</a>
                            <?php endif;?>
                        </div>
                    </li>
                </ul>
                <?php endforeach;?>
            </td>
        </tr>
        <tr>
            <td align="right">商品图像添加</td>
            <td>
                <a href="javascript:void(0)" id="selectFileBtn">添加图片</a>
                <div id="attachList" class="clear"></div>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input class="smt" type="submit"  value="提交"/></td>
        </tr>
    </table>
</form>
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $('.del').click(function(){
            var url ='/images/editproduct_images';
            var modelid = <?php echo $model_id?>;
            var picid  = $(this).attr('picid');
            layer.confirm("您确认要删除吗？添加一次不容易",function(){
                $.post(url,{mark:'del',modelid:modelid,picid:picid},function(data){
                    if(data){
                        window.location.href = "/images/editproduct_images?model_id="+modelid;
                    }
                })
            })
        })
        $('.moveup').click(function(){
            var url ='/images/editproduct_images';
            var modelid = <?php echo $model_id?>;
            var picid  = $(this).attr('picid');
            var sort  = $(this).attr('sort');
            layer.confirm("您确认要上移吗？",function(){
                $.post(url,{mark:'moveup',modelid:modelid,picid:picid,sort:sort},function(data){
                    if(data){
                        window.location.href = "/images/editproduct_images?model_id="+modelid;
                    }
                })
            })
        })
    })
    function moveUpImg(){
        window.location='doAdminAction.php?act=moveUpImg&id='+id+'&proId='+proId;
    }
    $(document).ready(function(){
        $("#selectFileBtn").click(function(){
            $fileField = $('<input type="file" name="proImg[]"/>');
            $fileField.hide();
            $("#attachList").append($fileField);
            $fileField.trigger("click");
            $fileField.change(function(){
                $path = $(this).val();
                $filename = $path.substring($path.lastIndexOf("\\")+1);
                $attachItem = $('<div class="attachItem"><div class="left">a.gif</div><div class="right"><a href="#" title="删除附件">删除</a></div></div>');
                $attachItem.find(".left").html($filename);
                $("#attachList").append($attachItem);
            });
        });
        $("#attachList").on('click','.attachItem a',function(obj,i){
            $(this).parents('.attachItem').prev('input').remove();
            $(this).parents('.attachItem').remove();
        });
    });
</script>
</body>
</html>