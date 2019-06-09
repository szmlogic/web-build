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
            

    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-primary" href="<?php echo U('Link/add');?>">新增</a>
                <a class="btn btn-primary" onclick="return confirm_deleteall()">删除</a>
                <a class="btn btn-primary" onclick="myform.action='<?php echo U('Link/listorder');?>';$('#myform').submit();" >排序</a>
            </div>
         </div>
    </div>

    <div class="row table-container">
        <div class="col-md-12">
            <form name="myform" id="myform" action="" method="post">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th width="20"><input type="checkbox" value="" id="check_box" onclick="selectall('ids[]');"></th>
                        <th class="table-cell-1">排序</th>
                        <th width="40">ID</th>
                        <th>名称</th>
                        <th>网站地址</th>
                        <th>logo</th>
                        <th class="table-cell-3">添加时间</th>
                        <th class="table-cell-2 center">管理操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(empty($list)): ?><tr class="table-data-empty">
                            <td class="text-center empty-info" colspan="8">
                                <i class="fa fa-database"></i> 暂时没有数据<br>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr>
                                <td width="20" align="center"><input class="inputcheckbox " name="ids[]" value="<?php echo ($vo['id']); ?>" type="checkbox" ></td>
                                <td width="30"><input name='listorders[<?php echo ($vo["id"]); ?>]' type='text' size='3' value='<?php echo ($vo["listorder"]); ?>' class='input-text-c'></td>
                                <td><?php echo ($vo['id']); ?><input class="id" type="hidden" name="id" value="<?php echo ($vo['id']); ?>"></td>
                                <td><?php echo ($vo['name']); ?></td>
                                <td><?php echo ($vo['siteurl']); ?></td>
                                <td><?php if($vo['weblogo']): ?><img src="<?php echo ($vo['weblogo']); ?>" height=26><?php endif; ?>&nbsp;</td>
                                <td align="center"><?php echo (todate($vo['createtime'],"Y-m-d H:i:s")); ?></td>
                                <td class="table-cell-2 center">
                                    <a class="btn btn-xs btn-primary" href="<?php echo U('Link/edit',array('id'=>$vo['id']));?>">编辑</a>
                                    <a class="btn btn-xs btn-danger" href="javascript:confirm_delete('<?php echo U('Link/delete',array(id=>$vo['id']));?>')">删除</a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                    </tbody>
                </table>
            </form>
            <div id="pages"><?php echo ($page); ?></div>
        </div>

    </div>
</div>
<script>
// 确认删除
function confirm_deleteall(){
    var str = 0;
    var id = tag = '';
    $('input[name="ids[]"]:checked').each(function(){
        str = 1;
        id += tag + $(this).val();
        tag = ',';
    });
    if (str == 0) {
        layer.msg('您没有勾选信息，无法进行操作！', {
            icon: 2,
            time: 1000 //2秒关闭（如果不配置，默认是3秒）
        });
        return false;
    }
    layer.confirm("<?php echo L('real_delete');?>", function(){
        myform.action='<?php echo U('Link/delete');?>'+'&id='+id;
        $('#myform').submit();
    });
}
</script>

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



</body>
</html>