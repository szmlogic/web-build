<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<!--<![endif]-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo L('system_name');?> &rsaquo; 登录</title>
<link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css">

<link rel='stylesheet' id='login-css'  href="__PUBLIC__/admin/css/login.css" type="text/css" />

<script src="__JS__/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="__STATIC__/layer/layer.js"></script>
<link href="__STATIC__/icheck/skins/all.css" rel="stylesheet">
<script src="__STATIC__/icheck/icheck.min.js"></script>
<meta name='robots' content='noindex,follow' />
<script src="__STATIC__/iealert/iealert.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="__STATIC__/iealert/iealert/style.css" />
<script type="text/javascript">
    $(document).ready(function() {
        $("body").iealert({
            support: "ie8",
            title:'你的浏览器太旧了，请升级浏览器！',
            text:'您正在使用IE低版浏览器，为了您的账号安全和更好的产品体验，强烈建议使用更快更安全的浏览器。如果您正在使用360浏览器，请切换到极速模式。',
            upgradeTitle:'升级'
        });
    });
</script>
</head>
<body class="login">
<div class="wrapper">
    <h1>
        <a href="/admin" title="<?php echo L('system_name');?>" tabindex="-1">
            <img src="__PUBLIC__/admin/images/loginlogo.png">
        </a>
    </h1>

    <div class="login-body">
        <h2>管理后台登陆</h2>
        <form name="loginform" id="loginform" action="<?php echo U('Login/doLogin');?>" method="post">
            <div class="form-group">
                <input type="text" name="username" id="user_login" class="form-control" placeholder="账号" size="20" />
            </div>
            <div class="form-group">
                <input type="password" name="password" id="user_pass" class="form-control" placeholder="密码" size="20" />
            </div>
            <div class="form-group" style="position: relative">
                <input type="text" name="verifyCode" class="form-control" placeholder="验证码" size="20" style="width:50%" />
                <img src="<?php echo U('Login/verify');?>" onclick="this.src='<?php echo U('Login/verify');?>'+'&'+Math.random()" class="verifycode" title="<?php echo L('REVERIFY');?>" style="position: absolute;top: 0; left: 52%;"/>
            </div>
            <div class="submit">
                <div class="remember">
                    <div class="icheckbox_square-blue" >
                        <input type="checkbox" name="remember" class="icheck-me" data-skin="square" data-color="blue" id="remember">
                    </div>
                    <label for="remember" class="">记住登陆状态</label>
                </div>
                <input type="submit" name="submit" class="btn  btn-large" value="登录" />
                <input type="hidden" name="testcookie" value="1" />
            </div>
        </form>

        <div class="forget" style="margin-top: 60px;">
            <a href="<?php echo U('Login/lostpassword');?>">
                <span>忘记密码?</span>
            </a>
        </div>
    </div>


</div>
<script type="text/javascript">

$('.icheck-me').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    increaseArea: '20%' // optional
});

$("#loginform").submit(function () {
    var username, password,verifyCode;

    username = $("input[name='username']").val();
    password = $("input[name='password']").val();
    verifyCode = $("input[name='verifyCode']").val();

    var data = new Object();
    data.username = username;
    data.password = password;
    data.verifyCode = verifyCode;

    var options = new Object();

    options.data = data;
    //options.dataType = 'json';
    options.type = 'post';
    options.success = function(data) {
        if (data.status==1) {
            layer.msg(data.info);
            setTimeout(function(){
                window.location.href = '<?php echo U("Index/index");?>';
            },500);
        } else {
            layer.msg(data.info);
        }
    };

    options.url = '<?php echo U('Login/doLogin');?>';

    $.ajax(options);
    return false;
 });
</script>
</body>
</html>