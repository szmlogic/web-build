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
    <div class="col-md-12">
    <form id="myform" name="myform" class="form-horizontal" action="<?php echo U('Category/edit');?>" method="post">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#home" role="tab" data-toggle="tab">基本设置</a></li>
        <li><a href="#seo" role="tab" data-toggle="tab">SEO设置</a></li>
        <!--<li><a href="#extend" role="tab" data-toggle="tab">扩展信息</a></li>-->
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
            <div class="form-group">
                <label class="control-label col-md-2">上级栏目</label>
                <div class="col-md-8">
                    <div>
                        <select name="parentid" class="form-control" <?php if($vo['parentid'] == 0):?>disabled<?php endif;?>>
                            <option value="0">作为一级栏目</option>
                            <?php echo ($select_categorys); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group" <?php if($_SESSION['admin']['role'] != 1):?>style="display:none;"<?php endif;?>>
                <label class="control-label col-md-2">栏目类型</label>
                <div class="col-md-8">
                    <?php echo Form::select( array('field'=>'modelid', 'options'=>$model+array('0'=>array('id'=>0,'name'=>'外部链接')), 'options_key'=>'id,name', 'setup'=>array('onchange'=>'changetemplate(this.value)')), $vo['modelid'] );?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">栏目名称</label>
                <div class="col-md-8">
                    <input type="text" name="catname" class="form-control" value="<?php echo ($vo['catname']); ?>" />
                </div>
            </div>

            <?php if($_SESSION['admin']['role'] == 1):?>
            <div class="form-group type1">
                <label class="control-label col-md-2">页面命名</label>
                <div class="col-md-8">
                    <input type="text" name="catdir" class="form-control" value="<?php echo ($vo['catdir']); ?>" />
                </div>
            </div>
            <?php endif;?>

            <div class="form-group" id="model_url" style="display:none;">
                <label class="control-label col-md-2">外部链接地址</label>
                <div class="col-md-8">
                    <input type="text" name="url" class="form-control" value="<?php if($vo['type']==2): echo ($vo['url']); endif; ?>" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">栏目图片</label>
                <div class="col-md-8">
                    <div class="thumb_image">
                        <div id="image_aid_box"></div>
                        <a class="thumbnail" href="javascript:swfupload('image','<?php echo get_yzh_auth(1,'200kb',1);?>',yesdo);">
                            <img id="image_pic" height="68" src="<?php if(!empty($vo['image'])): echo ($vo['image']); else: ?>__IMG__/upload_thumb.png<?php endif; ?>"></a>
                        <input type="button" value="取消图片" onclick="javascript:clean_thumb('image');" class="btn btn-xs btn-primary"/>
                        <input type="hidden" id="image" name="image" value="<?php echo ($vo['image']); ?>"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">多栏目设置: </label>
                <div class="col-md-8">
                    <div class="checkbox-inline">
                    <input type="checkbox" id="chage_all" name="chage_all" value="1" /><font color="red"> <?php echo L('chage_all');?></font>
                    </div>
                </div>
            </div>

            <div class="form-group" >
                <label class="control-label col-md-2">导航</label>
                <div class="col-md-8">
                    <?php echo Form::radio(array('field'=>'ismenu','options'=>array('1'=>L('yes'),'0'=>L('no'))),$vo['ismenu']);?>
                </div>
            </div>

            <?php if($vo['modelid'] > 1):?>
            <div class="form-group" <?php if($_SESSION['admin']['role'] != 1):?>style="display:none;"<?php endif;?>>
                <label class="control-label col-md-2">分页条数</label>
                <div class="col-md-8">
                    <input type="text" name="pagesize" class="form-control w-100" value="<?php if(!empty($vo['pagesize'])): echo ($vo['pagesize']); endif; ?>" size="3" /> <font color="red"><?php echo L('pagesize_desc');?></font>
                </div>
            </div>
            <?php endif;?>

            <?php if($vo['modelid'] > 0):?>
            <div class="form-group" <?php if($_SESSION['admin']['role'] != 1):?>style="display:none;"<?php endif;?>>
                <label class="control-label col-md-2">列表页模板</label>
                <div class="col-md-8">
                    <select id="template_list" name="template_list" class="form-control w-300 pull-left"></select>
                    &nbsp;&nbsp;
                    <input type="checkbox" class="pull-left" id="listtype" name="listtype"  onclick="javascript:templatetype();" value="1"  <?php if(!empty($vo['listtype'])): ?>checked<?php endif; ?> /> 是否为封面栏目
                </div>
            </div>
            <?php endif;?>
            <?php if($vo['modelid'] > 1):?>
            <div class="form-group" <?php if($_SESSION['admin']['role'] != 1):?>style="display:none;"<?php endif;?>>
                <label class="control-label col-md-2">内容页模板</label>
                <div class="col-md-8">
                    <select id="template_show" name="template_show" class="form-control w-300"></select>
                </div>
            </div>
            <?php endif;?>
        </div>

        <div role="tabpanel" class="tab-pane" id="seo">

            <div class="form-group">
                <label class="control-label col-md-2"><?php echo L('seo_title');?></label>
                <div class="col-md-8">
                    <input name='title' type='text' value="<?php echo ($vo['title']); ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2"><?php echo L('seo_keywords');?></label>
                <div class="col-md-8">
                    <input name="keywords" type="text" value="<?php echo ($vo['keywords']); ?>" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-2"><?php echo L('seo_description');?></label>
                <div class="col-md-8">
                    <textarea name="description" rows="5" cols="60" class="form-control"><?php echo ($vo['description']); ?></textarea>
                </div>
            </div>
        </div>

        <!--<div role="tabpanel" class="tab-pane" id="extend">
            <div class="form-group">
                <label class="control-label col-md-2">英文标题</label>
                <div class="col-md-8">
                    <input name="wap_catname" type="text" value="<?php echo ($vo['wap_catname']); ?>" class="form-control">
                </div>
            </div>
        </div>-->

        <div class="form-actions">
            <input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>">
            <input type="submit" value="提交" class="btn btn-primary" >
            <button class="btn btn-default return" onclick="javascript:history.back(-1);return false;">返回</button>
        </div>
    </form>

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
$(document).ready(function() {
    $('#myform').ajaxForm({
        success:  complete,  // post-submit callback
        dataType: 'json'
    });
});

function complete(data){
    if(data.status==1){
        layer.msg(data.info, {
            icon: 1,
            time: 2000 //2秒关闭（如果不配置，默认是3秒）
        }, function(){
            window.location.href = "<?php echo (cookie('__forward__')); ?>";
            return true;
        });
    }else{
        layer.msg(data.info, {
            icon: 2,
            time: 2000 //2秒关闭（如果不配置，默认是3秒）
        });
    }

}
</script>
<script>

var modulearr = new Array();

<?php if(is_array($model)): $i = 0; $__LIST__ = $model;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mdate): $mod = ($i % 2 );++$i;?>modulearr[<?php echo ($mdate['id']); ?>] = "<?php echo ($mdate['tablename']); ?>";<?php endforeach; endif; else: echo "" ;endif; ?>

var templatearr = new Array();

<?php if(is_array($templates)): $i = 0; $__LIST__ = $templates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tem): $mod = ($i % 2 );++$i;?>templatearr[<?php echo ($i); ?>] = "<?php echo ($tem['name']); ?>,<?php echo ($tem['value']); ?>,<?php echo ($tem['filename']); ?>";<?php endforeach; endif; else: echo "" ;endif; ?>


var datas = "<option value=''>请选择</option>";
var modelid = $('#modelid').val();


showtemplist(<?php echo ($vo['modelid']); ?>,<?php if(empty($vo[listtype])): ?>0<?php else: echo ($vo["listtype"]); endif; ?>);

function showtemplist(m,t){

    var type='_list';

    if(t){
        type='_index';
    }

    var mtlist = modulearr[m]+type;
    var mtshow = modulearr[m]+'_show';

    if(modulearr[m]=='Page')
        mtlist=mtshow ='Page_';

    $('#template_list').html(datas);
    $('#template_show').html(datas);

    listdatas = showdatas ='';

    for(i=1;i<templatearr.length;i++){
        data = templatearr[i].split(',');

        if(data[0].indexOf(mtlist)  >= 0){
            listdatas  ="<option value='"+data[1]+"'>"+data[2]+"</option>";
            $('#template_list').append(listdatas);
        }

        if(data[0].indexOf(mtshow)  >= 0){
            showdatas ="<option value='"+data[1]+"'>"+data[2]+"</option>";
            $('#template_show').append(showdatas);
        }
    }
    $('#template_list').val('<?php echo ($vo["template_list"]); ?>');
    $('#template_show').val('<?php echo ($vo["template_show"]); ?>');
}

function changetemplate(m){
    if(m==0){
        $('#model_url').show();
        $('.type1').hide();
        $('#type').val('2');
        $('#catdir').removeClass('required');
    }else{
        $('#model_url').hide();
        $('.type1').show();
        $('#type').val('0');
        $('#catdir').addClass('required');
    }
    showtemplist(m,0);
    $("#listtype").removeAttr("checked");
}

function templatetype(){

    var modelid = $('#modelid').val();

    if($("#listtype").attr('checked')=='checked'){
        showtemplist(modelid,1);
    }else{
        showtemplist(modelid,0);
    }

}

function urlrule(m){
    if(m==1){
        $('#urlrule').show();
    }else{
        $('#urlrule').hide();
    }
}

urlrule(<?php echo ($vo['ishtml']); ?>);

<?php if($vo['type'] == 2): ?>$('#modelid').val(0);
    changetemplate(0);<?php endif; ?>
</script>

</body>
</html>