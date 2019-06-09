<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 8 ]><html class="ie8"><![endif]-->
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="w3c"><!--<![endif]-->
<head>

    <!--[if lte IE 8]>
    <meta http-equiv="refresh" content="0;url=http://<?php echo ($_SERVER['SERVER_NAME']); ?>/public/browser">
    <script>location.href="http://<?php echo ($_SERVER['SERVER_NAME']); ?>/public/browser";</script>
    <![endif]-->

    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 最新 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="__STATIC__/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="__STATIC__/font-awesome/css/font-awesome.min.css">

    <link rel='stylesheet' type='text/css' href='__PUBLIC__/admin/css/style.css'>
    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="__JS__/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>



    <!-- custom scrollbar stylesheet -->
    <link rel="stylesheet" href="__PUBLIC__/admin/css/jquery.mCustomScrollbar.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="__STATIC__/bootstrap/js/vendor/html5shiv.js"></script>
    <script src="__STATIC__/bootstrap/js/vendor/respond.min.js"></script>
    <![endif]-->
    <title><?php echo L('system_name');?></title>
    <script>
        document.domain = '<?php echo (session('rootdomain')); ?>';
    </script>
    
</head>

<body>

<div id="header">
    <div class="container-fluid">
        <div id="brand"></div>

        <ul class="nav navbar-nav main-nav">
            <?php if(is_array($topmenu)): $i = 0; $__LIST__ = $topmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li <?php if($menu['id'] == $__CURRENT_ROOTMENU__) echo 'class="active"'; ?>>
                <a href="<?php echo U($menu['group'].'/'.$menu['model'].'/'.$menu['action'],$menu['data']);?>">
                    <i class="<?php echo ($menu['icon']); ?>"></i>
                    <span><?php echo ($menu['name']); ?></span></a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>

        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links navbar-right">
                <li><a href="javascript:update_cache();" title="更新缓存"><i class="fa fa-lg fa-refresh"></i></a></li>
                <li><a href="/" target="_blank" title="浏览站点"><i class="fa fa-lg fa-globe"></i></a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php if(empty($_SESSION['admin']['avatar'])): ?>__PUBLIC__/images/admin_avtar.jpg<?php else: echo (thumb($_SESSION['admin']['avatar'],'30,30')); endif; ?>" alt="avatar" class="mw30 br64">
                        <?php echo ($_SESSION['admin']['username']); ?>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="<?php echo U('User/index');?>"><i class="fa fa-edit"></i>帐号设置</a>
                        </li>
                        <li>
                            <a id="logout" href="<?php echo U('Login/logout');?>"><i class="fa fa-sign-out"></i>安全退出</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <!--侧边导航-->
        
    <div id="aside">
    <div class="navbar">
        <ul class="asidenav">
            <li><a><i class="fa fa-folder-open-o"></i><span>快捷操作</span></a>
                <ul>
                    <?php if(is_array($shortcuts)): $i = 0; $__LIST__ = $shortcuts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li>
                            <a href="<?php echo ($r["url"]); ?>">
                                <i class="fa fa-mail-forward"></i><span><?php echo ($r["name"]); ?></span>
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>

                    <?php if($_SESSION['admin']['id']== 1): ?><li>
                            <a href="<?php echo U('Index/shortcuts');?>">
                                <i class="fa fa-eye"></i>
                                <span>快捷操作管理</span>
                            </a>
                        </li><?php endif; ?>

                </ul>
            </li>

        </ul>
    </div>
</div>

        <div id="main" class="col-xs-12 col-sm-10">
            <!-- 面包屑导航 -->
            <ol class="breadcrumb">
                <li><i class="fa fa-map-marker"></i></li>
                <?php if(is_array($parent_menu)): $i = 0; $__LIST__ = $parent_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu_li): $mod = ($i % 2 );++$i;?><li><?php echo ($menu_li["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ol>
            

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">快捷操作 <a class="pull-right" href="javascript:add_item();"><i class="fa fa-plus"></i>新增</a></div>
                <div class="panel-body">
                    <form class="myform form-horizontal" method="post" action="">
                        <div id="shortcuts">
                            <?php if(empty($shortcuts)): ?><div class="item item_1">
                                    <div class="form-group">
                                        <label class="control-label col-md-1">操作名称</label>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="name[]">
                                        </div>
                                        <label class="control-label col-md-1">链接地址</label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="url[]">
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <?php if(is_array($shortcuts)): $k = 0; $__LIST__ = $shortcuts;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($k % 2 );++$k;?><div class="item item_<?php echo ($k); ?>">
                                        <div class="form-group">
                                            <label class="control-label col-md-1">产品名称</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="name[]" value="<?php echo ($r['name']); ?>">
                                            </div>
                                            <label class="control-label col-md-1">产品链接</label>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control"  name="url[]" value="<?php echo ($r['url']); ?>">
                                            </div>
                                        <?php if(($k) != "0"): ?><div class="col-md-1">
                                                <button type="button" onclick="del_item(<?php echo ($k); ?>)" class="btn btn-primary btn-sm">删除</button>
                                            </div><?php endif; ?>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </div>

                        <div class="form-actions">
                            <input type="submit" value="保存" class="btn btn-sm btn-primary" />
                            <input type="reset" value="重置" class="btn btn-sm btn-primary"/>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

        </div>

    </div>
</div>



<!-- 引入js -->
<script type="text/javascript" src="__STATIC__/layer/layer.js"></script>
<script src="__STATIC__/laydate/laydate.js"></script>
<script type="text/javascript" src="__JS__/admin.js"></script>
<script type="text/javascript" src="__JS__/jquery.form.js"></script>
<script type="text/javascript" src="__JS__/jquery.colorpicker.js"></script>
<script type="text/javascript" src="__STATIC__/MyDate/WdatePicker.js"></script>
<!-- custom scrollbar plugin -->
<script src="__JS__/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript">

    var APP = '';
    var ROOT = '';
    var PUBLIC = '/public';

    $('.dropdown-toggle').dropdown()

    layer.config({
        extend: 'extend/layer.ext.js'
    });

    laydate.skin('molv');

    $(".scrollerbar").mCustomScrollbar({theme:"minimal"});

    //登出
    window.onload = function (){

        $('#logout').click(function(){
            var url = $('#logout').attr('href');
            $.ajax({
                url: url,
                success:function(data){
                    layer.msg(data.info);
                    window.location.href = "<?php echo U('Login/index');?>";
                }
            });
            return false;
        })
    }

    //更新缓存
    function update_cache(){
        $.ajax({
            url:"<?php echo U('Public/cache');?>",
            beforeSend:function(){
                layer.msg('正在更新缓存');
            },
            success:function(data){
                window.location.reload();
            }
        });
    }
</script>



    <script type="text/javascript">
        $(document).ready(function(){
            $('.myform').ajaxForm({
                success:  complete,  // post-submit callback
                dataType: 'json'
            });
        });

        function complete(data){
            if(data.status==1){
                layer.msg(data.info);
            }else{
                layer.msg(data.info);
            }
        }


        function add_item(num)
        {
            var num = $('.item').length+1;
            var html = '<div class="item item_'+num+'">';
            html += '<div class="form-group">';
            html += '<label class="control-label col-md-1">操作名称</label>';
            html += '<div class="col-md-3">';
            html += '<input class="form-control" type="text" name="name[]" >';
            html += '</div>';
            html += '<label class="control-label col-md-1">链接地址</label>';
            html += '<div class="col-md-5">';
            html += '<input class="form-control" type="text" name="url[]">';
            html += '</div>';
            html += '<div class="col-md-1">';
            html += '<button type="button" onclick="del_item('+num+')" class="btn btn-primary btn-sm">删除</button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            $('#shortcuts').append(html);
        }

        function del_item(num){
            $('.item_'+num).remove();
        }
    </script>

</body>
</html>