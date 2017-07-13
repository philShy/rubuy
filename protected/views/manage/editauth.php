<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title></title>
</head>

<style>
    select{boeder:none;width:173px;height:22px}
    table tr:nth-child(odd){background:#eee;}
    table tr:hover{background:#eee;}
    .smt{background: #ffb752;border:1px solid #ffb752;border-radius: 3px;width:50px;height:30px;color:#fff;cursor: pointer}
</style>
<body>
<h3>权限操作</h3>

<form action="" method="post">
    <table width="70%" cellpadding="5" rules="all" cellspacing="0" bgcolor="#fff" style="border:1px solid #ddd">
        <tr>
            <td>权限名称</td>
            <td>
                <input class="authName" name="authName" type="text" value="<?php echo $authOne['auth_name']?>" ></td>
            <td></td>
        </tr>
        <tr>
            <td>控制器名</td>
            <td><input class="authContrl" name="authContrl" type="text" value="<?php echo $authOne['contrl']?>"></td>
            <td><span style="color:#ccc;font-size: 14px"> 如果添加0级权限则不用填写</span></td>
        </tr>
        <tr>
            <td>方法名称</td>
            <td><input class="authAction" name="authAction" type="text" value="<?php echo $authOne['action']?>"></td>
            <td><span style="color:#ccc;font-size: 14px"> 如果添加0级权限则不用填写</span></td>
        </tr>
        <tr>
            <td>权限级别</td>
            <td><input class="authLevel" name="authLevel" type="text" value="<?php echo $authOne['level']?>"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3"><input class="smt" type="submit" value="提交"></td>
        </tr>
    </table>
</form>
</body>
</html>
<script src="/js/jquery-1.9.1.min.js"></script>
<script src="/assets/layer/layer.js" type="text/javascript" ></script>
<script src="/assets/laydate/laydate.js" type="text/javascript"></script>
<script type="text/javascript">

</script>