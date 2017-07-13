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
    <script type="text/javascript" src="/Widget/Validform/5.3.2/Validform.min.js"></script>
    <script src="/assets/js/typeahead-bs2.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/jquery.dataTables.bootstrap.js"></script>
    <script src="/assets/layer/layer.js" type="text/javascript" ></script>
    <script src="/js/lrtk.js" type="text/javascript" ></script>
    <script src="/assets/layer/layer.js" type="text/javascript"></script>
    <script src="/assets/laydate/laydate.js" type="text/javascript"></script>
    <title></title>
</head>
<style>
    .c-red{color:red}
    .error{color:red}
</style>
<body>
    <!--添加管理员-->
    <div class="add_menber" style="margin-top: 30px">
        <form action="/manage/editmanager" method="post" id="form-admin-add">
            <input type="hidden" name="managerid" value="<?php echo $manager_one['id']?>">
            <div class="form-group">
                <label class="form-label"><span class="c-red">*</span>管理员：</label>
                <div class="formControls">
                    <input type="text" class="input-text" value="<?php echo $manager_one['manager']?>" name="name" datatype="*2-16" nullmsg="用户名不能为空">
                </div>
                <div class="col-4"> <span class="Validform_checktip"></span></div>
            </div>
            <div class="form-group">
                <label class="form-label"><span class="c-red">*</span>密码：</label>
                <div class="formControls">
                    <input type="password" placeholder="密码" name="userpassword" autocomplete="off" value="" class="input-text" datatype="*6-20" nullmsg="密码不能为空">
                </div>
                <div class="col-4"> <span class="Validform_checktip"></span></div>
            </div>
            <div class="form-group">
                <label class="form-label "><span class="c-red">*</span>性别：</label>
                <div class="formControls  skin-minimal">
                    <!--<label><input name="form-field-radio" type="radio" class="ace" checked="checked"><span class="lbl">保密</span></label>&nbsp;&nbsp;-->
                    &nbsp;&nbsp;<label><input name="sex" type="radio" class="ace" <?php if($manager_one['sex'] == 0) echo 'checked';?> value=0><span class="lbl">男</span></label>&nbsp;&nbsp;
                    &nbsp;&nbsp;<label><input name="sex" type="radio" class="ace" <?php if($manager_one['sex'] == 1) echo 'checked';?> value=1><span class="lbl">女</span></label>
                </div>
                <div class="col-4"> <span class="Validform_checktip"></span></div>
            </div>
            <div class="form-group">
                <label class="form-label "><span class="c-red">*</span>手机：</label>
                <div class="formControls ">
                    <input type="text" class="input-text" value="<?php echo $manager_one['phone']?>" name="phone" datatype="m" nullmsg="手机不能为空">
                </div>
                <div class="col-4"> <span class="Validform_checktip"></span></div>
            </div>
            <div class="form-group">
                <label class="form-label"><span class="c-red">*</span>邮箱：</label>
                <div class="formControls ">
                    <input type="text" value="<?php echo $manager_one['email']?>" class="input-text" name="email"  datatype="e" nullmsg="请输入邮箱！">
                </div>
                <div class="col-4"> <span class="Validform_checktip"></span></div>
            </div>
            <div class="form-group">
                <label class="form-label"><span class="c-red">*</span>角色：</label>
                <div class="formControls "> <span class="select-box" style="width:150px;">
				<select class="select" name="role" size="1" style="margin-left: 10px">
                    <?php foreach($role as $key=>$value):?>
                        <option <?php if($manager_one['role_id'] == $value['id']) echo 'selected'?> value="<?php echo $value['id']?>"><?php echo $value['role']?></option>
                    <?php endforeach;?>
                </select>
				</span> </div>
            </div>
            <div class="form-group">
                <label class="form-label">备注：</label>
                <div class="formControls">
                    <textarea name="note" cols="" rows="" class="textarea" dragonfly="true" onkeyup="checkLength(this);"><?php echo $manager_one['note']?></textarea>

                </div>
                <div class="col-4"> </div>
            </div>
            <div>
                <input style="margin-left: 100px" class="btn btn-primary radius" type="submit" id="Add_Administrator" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
        </form>
    </div>
</div>
</body>
</html>
<script src="/assets/js/jquery.validate.js"></script>
<script type="text/javascript">
$(function(){

    $("#form-admin-add").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            role: 'required',
        },
        messages: {
            name: {
                required: "&nbsp;&nbsp;&nbsp;必填",
                minlength: "&nbsp;&nbsp;&nbsp;用户名必需由两个字母组成"
            },
            email: {
                required: "&nbsp;&nbsp;&nbsp;必填",
                email:'&nbsp;&nbsp;&nbsp;邮箱格式不正确'
            },
            role:  "&nbsp;&nbsp;&nbsp;必填",
        }
    })
})
$(function(){
    var dataformInit = $("#form-admin-add").serializeArray();
    var jsonTextInit = JSON.stringify({ dataform: dataformInit });
    $(".btn").click(function(){
        var dataform = $("#form-admin-add").serializeArray();
        var jsonText = JSON.stringify({ dataform: dataform });
        if(jsonTextInit==jsonText)
        {
            //layer.alert('没有修改')
            return false;
        }
        else{
            $("#form-admin-add").submit();
        }
    })
})
</script>
