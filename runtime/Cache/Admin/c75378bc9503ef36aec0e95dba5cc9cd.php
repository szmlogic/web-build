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
            
<script type="text/javascript" src="__JS__/jquery.colorpicker.js"></script>
<script src="__JS__/Sortable.min.js"></script>

<form id="myform" action="<?php echo U($model_name.'/add');?>" method="post">
    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-heading">基本内容</div>
                <div class="panel-body">
                <?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if(!empty($r['status']) && $r['isbase']==1): ?><div class="form-group">
                    <label class="control-label">
                        <?php if($r['required']): ?><font color="red">*</font><?php endif; echo ($r["name"]); ?>
                    </label>
                    <div id="box_<?php echo ($r['field']); ?>">
                        <?php if($r['type'] == 'images') : ?>
            <?php
 $parseData = $form->images($r); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">最多同时可以上传<span class="text-danger"><?php echo ($r['setup']['upload_maxnum']); ?></span>张
                    <div class="pull-right">
                        <a class="btn btn-xs btn-info" href="javascript:swfupload('<?php echo ($r['field']); ?>', '<?php echo ($parseData['yzh_auth']); ?>', up_images);">图片上传</a></div>
                    </div>
                    <div id="<?php echo ($r['field']); ?>_images" class="imagesList panel-body">
                        <input type="hidden" name="<?php echo ($r['field']); ?>[]" value=""/>
                        <input type="hidden" name="<?php echo ($r['field']); ?>_name[]" value="" />
                    </div>
                </div>
            <script>
            Sortable.create(<?php echo ($r['field']); ?>_images, { handle: "img", animation: 150});
            </script>

                        <?php else :?>
                            <?php echo (getform($form,$r)); ?>
                        <?php endif;?>
                        </div>
                    </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">缩略图</div>
                <div class="panel-body">
                    <div class="thumb_box" id="thumb_box" style="text-align: center">
                        <div id="thumb_aid_box"></div>
                        <a class="thumbnail uploadimg" href="javascript:swfupload('thumb','<?php echo get_yzh_auth(1,'200kb',1);?>',yesdo);">
                            <img src="__IMG__/upload_thumb.png" id="thumb_pic" width="135" height="113">
                        </a>
                        <input type="button" value="取消缩略图" onclick="javascript:clean_thumb('thumb');" class="btn btn-xs btn-primary" />
                        <input type="hidden" id="thumb" name="thumb" value="" />
                    </div>
                </div>
            </div>

    <?php if(is_array($fields)): $i = 0; $__LIST__ = $fields;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i; if(!empty($r['status']) && $r['isbase']==0): ?><div class="panel panel-default">
                <div class="panel-heading">
                    <?php if($r['required']): ?><font color="red">*</font><?php endif; echo ($r["name"]); ?>
                </div>
                <div class="panel-body">
                    <?php echo (getform($form,$r)); ?>
                </div>
            </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>

        </div>
    </div>
    <div class="form-actions">
        <input type="submit" value="提交" class="btn btn-primary" />
        <input type="reset" value="重置" class="btn btn-primary"/>
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

            layer.confirm(data.info, {
                icon:1,
                btn: ['继续发布内容','返回列表'] //按钮
            }, function(){
                window.location.href = "<?php echo U($model_name.'/add');?>";
                return false;
            }, function(){
                window.location.href = "<?php echo (cookie('__forward__')); ?>";
                return true;
            });

        } else {
            layer.msg(data.info, {icon: 2});
        }

    }

</script>

</body>
</html>