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
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/js/H-ui.js" type="text/javascript"></script>
    <script src="/js/displayPart.js" type="text/javascript"></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <title>系统日志</title>
</head>

<body>
<div class="margin clearfix">
    <div id="system_style">
        <div class="search_style">
        <form action="" method="post">
            <ul class="search_content clearfix">
                <li><label class="l_f">管理员</label><input name="manager" type="text" class="text_add"style=" width:250px"></li>
                <li><label class="l_f">时间</label><input name="datetime" class="inline laydate-icon" id="start" style=" margin-left:10px;"></li>
                <li style="width:90px;"><input type="submit" class="btn_search" value="查询"></li>
            </ul>
        </form>
        </div>
        <!--系统日志-->
        <div class="system_logs">
            <table class="table table-striped table-bordered table-hover" id="sample-table">
                <thead>
                <tr>
                    <th width="80px">ID</th>
                    <th width="120px">登录用户</th>
                    <th width="120px">角色</th>
                    <th width="120px">数据表</th>
                    <th width="120px">操作</th>
                    <th width="120px">登录ip</th>
                    <th width="150px">操作时间</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($log_arr as $key=>$value):?>
                <tr>
                    <td><?php echo $value['id']?></td>
                    <td><?php echo $value['login_user']?></td>
                    <td><?php echo $value['role']?></td>
                    <td><?php echo $value['table_cname']?></td>
                    <td><?php echo $value['curd_cname']?></td>
                    <td><?php echo $value['login_ip']?></td>
                    <td><?php echo $value['operate_time']?></td>
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
    laydate({
        elem: '#start',
        event: 'focus'
    });
    $(function() {
        var oTable1 = $('#sample-table').dataTable( {
            "aaSorting":false,//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                {"orderable":false,"aTargets":[0,1,2,3,4,5]}// 制定列不参与排序
            ]});
    })
</script>
