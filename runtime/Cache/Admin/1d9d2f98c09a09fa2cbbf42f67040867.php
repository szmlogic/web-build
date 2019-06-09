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
            

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">公司信息</div>
                <div class="panel-body">
                    <form class="myform form-horizontal" method="post" action="<?php echo U('config/save');?>">
                        <?php if(is_array($company_config)): $i = 0; $__LIST__ = $company_config;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['type']==1) : ?>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo ($vo["info"]); ?>:</label>
                                <div class="col-md-10">
                                    <input type="hidden" id="<?php echo ($vo["varname"]); ?>" name="<?php echo ($vo["varname"]); ?>"  value="<?php echo ($vo['value']); ?>" size="40" />
                                    <div class="thumb_box">
                                        <div id="image_aid_box"></div>
                                        <a class="thumbnail" href="javascript:swfupload('<?php echo ($vo["varname"]); ?>','<?php echo get_yzh_auth(1,'200kb',1);?>',yesdo)">
                                            <img height="50" src="<?php if(!empty($vo['value'])): echo ($vo['value']); else: ?>__IMG__/upload_thumb.png<?php endif; ?>" id="<?php echo ($vo["varname"]); ?>_pic" >
                                        </a>
                                        <input type="button" value="取消图片" onclick="javascript:clean_thumb('<?php echo ($vo["varname"]); ?>');" class="btn btn-xs btn-info" style="margin:0;" />
                                    </div>
                                    <label>(请根据前端实际图片大小进行设计后上传)</label>
                                </div>
                            </div>
                            <?php else :?>
                            <div class="form-group">
                                <label class="control-label col-md-2"><?php echo ($vo["info"]); ?>:</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="<?php echo ($vo["varname"]); ?>" value="<?php echo ($vo["value"]); ?>">
                                </div>
                            </div>
                            <?php endif; endforeach; endif; else: echo "" ;endif; ?>

                        <div class="form-actions">
                            <input type="submit" value="保存" class="btn btn-primary" />
                            <input type="reset" value="重置" class="btn btn-primary"/>
                        </div>
                    </form>

                </div>

            </div>
        </div>


        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">站点信息</div>
                <div class="panel-body">
                    <form class="myform" method="post" action="<?php echo U('config/save');?>">
                        <div class="form-group">
                            <label class="control-label">网站名称:</label>
                            <input type="text" class="form-control"  name="site_name" value="<?php echo ($site_config["site_name"]); ?>">
                        </div>

                        <div class="form-group">
                            <label class="control-label">网站logo:</label>
                            <input type="hidden" id="site_logo" name="site_logo" value="<?php echo ($site_config["site_logo"]); ?>"/>
                            <div class="thumb_box">
                                <div id="image_aid_box"></div>
                                <a class="thumbnail" href="javascript:swfupload('site_logo','<?php echo get_yzh_auth(1,'200kb',1);?>',yesdo)">
                                    <img height="80" src="<?php if(!empty($site_config["site_logo"])): echo ($site_config["site_logo"]); else: ?>__IMG__/upload_thumb.png<?php endif; ?>" id="site_logo_pic" >
                                </a>
                                <input type="button" value="取消图片" onclick="javascript:clean_thumb('site_logo');" class="btn btn-xs btn-info"/>
                            </div>
                            <label>(请根据前端实际图片大小进行设计后上传)</label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">首页标题:</label>
                            <input type="text" class="form-control"  name="seo_title" value="<?php echo ($site_config["seo_title"]); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">首页关键词:</label>
                            <input type="text" class="form-control"  name="seo_keywords" value="<?php echo ($site_config["seo_keywords"]); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">首页描述:</label>
                            <textarea class="form-control" rows="4" cols="60" name="seo_description"><?php echo ($site_config["seo_description"]); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">备案信息:</label>
                            <input type="text" class="form-control"  name="site_approve" value="<?php echo ($site_config["site_approve"]); ?>">
                        </div>
                        <div class="form-group">
                            <label class="control-label">版权信息:</label>
                            <input type="text" class="form-control" name="site_copyright" value="<?php echo ($site_config["site_copyright"]); ?>">
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
        layer.msg('修改成功');
    }else{
        layer.msg(data.info);
    }
}
</script>

</body>
</html>