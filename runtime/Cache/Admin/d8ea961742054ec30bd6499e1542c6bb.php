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
        
    <div id="aside" class="scrollerbar">
    <div class="navbar">
        <ul class="asidenav">
            <?php if(is_array($side_menu_list)): $i = 0; $__LIST__ = $side_menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li><a><i class="fa fa-folder-open-o"></i><span><?php echo ($r['name']); ?></span></a>
                    <ul>
                        <?php if(is_array($r["_child"])): $i = 0; $__LIST__ = $r["_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rr): $mod = ($i % 2 );++$i;?><li>
                                <a href="<?php echo U($rr['group'].'/'.$rr['model'].'/'.$rr['action'],$rr['data']);?>">
                                    <i class="<?php echo ($rr['icon']); ?>"></i><span><?php echo ($rr['name']); ?></span>
                                </a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</div>



        <div id="main" class="col-xs-12 col-sm-10">
            <!-- 面包屑导航 -->
            <ol class="breadcrumb">
                <li><i class="fa fa-map-marker"></i></li>
                <?php if(is_array($parent_menu)): $i = 0; $__LIST__ = $parent_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu_li): $mod = ($i % 2 );++$i;?><li><?php echo ($menu_li["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ol>
            

    <form id="myform" class="form-horizontal" action="<?php echo U('Slide/editpic');?>" method="post">
        <input type="hidden" name="description" value="">
        <input type="hidden" name="content" value="">
        <input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>"/>
        <table class="form-table">
            <div class="form-group">
                <label class="control-label col-md-2"><b color="red">*</b>标题</label>
                <div class="col-md-5">
                    <input type="text" id="title" name="title" value="<?php echo ($vo["title"]); ?>" class="form-control" validate="required:true,cn_username:true, minlength:2, maxlength:20"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">链接</label>
                <div class="col-md-5">
                    <input type="text" id="link" name="link" value="<?php echo ($vo["link"]); ?>" class="form-control" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">小图</label>
                <div class="col-md-5">
                    <div id="small_aid_box" style="display:none;"></div>
                    <input type="hidden" id="small" name="small" value="<?php echo ($vo['small']); ?>" class="form-control input-sm" />
                    <a class="thumbnail" href="javascript:swfupload('small','<?php echo get_yzh_auth(1,'1MB',1);?>',yesdo)">
                        <img height="80" src="<?php if(!empty($vo["small"])): echo ($vo["small"]); else: ?>__IMG__/upload_thumb.png<?php endif; ?>" id="small_pic" >
                    </a>
                    <input type="button" value="取消图片" onclick="javascript:clean_thumb('small');" class="btn btn-xs btn-info"/>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">大图</label>
                <div class="col-md-5" class="pic_box">
                    <div id="pic_aid_box"></div>
                    <input type="hidden" id="pic" name="pic" value="<?php echo ($vo['pic']); ?>" class="form-control input-sm" />
                    <a class="thumbnail" href="javascript:swfupload('pic','<?php echo get_yzh_auth(1,'1MB',1);?>',yesdo)">
                        <img height="80" src="<?php if(!empty($vo["pic"])): echo ($vo["pic"]); else: ?>__IMG__s/upload_thumb.png<?php endif; ?>" id="pic_pic" >
                    </a>
                    <input type="button" value="取消图片" onclick="javascript:clean_thumb('pic');" class="btn btn-xs btn-info"/>
                    (建议尺寸:<?php echo ($slide["width"]); ?>px*<?php echo ($slide["height"]); ?>px)
                </div>
            </div>
            <div class="form-group" style="display: none">
                <label class="control-label col-md-2">状态</label>
                <div class="col-md-9">
                    <label class="radio-inline checkbox_status">
                        <input type="radio" name="status" <?php if(($vo["status"]) == "1"): ?>checked<?php endif; ?> value="1"> 已审核
                    </label>
                    <label class="radio-inline checkbox_status">
                        <input type="radio" name="status" <?php if(($vo["status"]) == "0"): ?>checked<?php endif; ?> value="0"> 未审核
                    </label>
                </div>
            </div>
            <div class="form-actions">
                <input type="submit" value="提交" class="btn btn-primary"/>
                <a class="btn btn-primary" href="javascript:window.history.go(-1);">返回</a>
            </div>
    </form>


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
        $(document).ready(function() {
            $('#myform').ajaxForm({
                success:  complete,  // post-submit callback
                dataType: 'json'
            });
        });

        function complete(data){
            if (data.status == 1) {
                layer.msg(data.info, {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function(){
                    window.location.href = "<?php echo (cookie('__forward__')); ?>";
                    return true;
                });
            } else {
                layer.msg(data.info, {
                    icon: 2,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                });
            }
        }
    </script>

</body>
</html>