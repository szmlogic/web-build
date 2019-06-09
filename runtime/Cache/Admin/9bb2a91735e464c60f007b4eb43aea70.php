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
		<div class="panel panel-info">
			<div class="panel-heading">绑定域名</div>
			<div class="panel-body">
				<form class="myform form-horizontal" method="post" action="<?php echo U('sysconfig/save');?>">

					<div class="form-group">
						<label class="control-label col-md-2">网站域名:</label>
						<div class="col-md-8">
							<div class="input-group">
								<input type="text" class="form-control" name="SITE_DOMAIN" value="<?php echo ($sysconf['SITE_DOMAIN']); ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">其他域名:</label>
						<div class="col-md-8">
							<div class="input-group">
								<textarea type="text" class="form-control" name="SITE_DOMAINS" cols="3" rows="8"><?php echo ($sysconf['SITE_DOMAINS']); ?></textarea>
								<label>当前站点支持绑定多个域名，它们将会301到主域名，域名之间以回车符分隔（请勿与其他站点的域名重复）</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-2">自动识别:</label>
						<div class="col-md-5">
							<input id="sub_domain" type="checkbox" data-off-text="关闭" data-on-text="开启" data-handle-width="50">
							<a href="javascript:;" target="_blank" data-toggle="tooltip" data-placement="right" title="开启后将自动识别移动端并强制定向到此域名"><i class="fa fa-lg fa-question-circle"></i></a>
							<input type="hidden" name="SUB_DOMAIN" value="<?php echo ($sysconf['SUB_DOMAIN']); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-2">移动端域名:</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="SITE_WAP_DOMAIN" value="<?php echo ($sysconf['SITE_WAP_DOMAIN']); ?>">
						</div>
					</div>

					<div class="form-actions">
						<input type="submit" value="保存" class="btn btn-sm btn-primary" />
						<input type="reset" value="重置" class="btn btn-sm btn-primary"/>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading">搜索引擎抓取设置(robots.txt设置)</div>
			<div class="panel-body">
				<form class="myform form-horizontal" method="post" action="<?php echo U('sysconfig/robots');?>">
                    <input type="hidden" id="robots_txt_1" value="<?php echo ($robots_txt1); ?>">
                    <input type="hidden" id="robots_txt_2" value="<?php echo ($robots_txt2); ?>">
                <div class="form-group">
					<div class="col-md-12">
						<textarea name="robots" class="form-control" cols="30" rows="10"><?php echo ($robots); ?></textarea>
                        <a class="btn btn-xs btn-info" href="javascript:robots_set(1);">禁止搜索引擎抓取</a>
                        <a class="btn btn-xs btn-info" href="javascript:robots_set(2);">默认robots.txt设置</a>
                    </div>
				</div>
				<div class="form-actions">
					<input type="submit" value="保存" class="btn btn-sm btn-primary" />
					<input type="reset" value="重置" class="btn btn-sm btn-primary"/>
				</div>
                </form>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">附件设置</div>
			<div class="panel-body">
				<form class="myform form-horizontal" method="post" action="<?php echo U('sysconfig/save');?>">
				<div class="form-group">
					<label class="control-label col-md-2">允许上传附件大小</label>
					<div class="col-md-10">
						<div class="input-group w-100">
							<input type="text" class="form-control" name="attach_maxsize" value="<?php echo ($sysconf["attach_maxsize"]); ?>"/>
							<span class="input-group-addon">MB</span>
						</div>
						<label for="">最大值5MB</label>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2">允许上传附件类型</label>
					<div class="col-md-10">
						<input type="text" class="form-control" name="attach_allowext" value="<?php echo ($sysconf["attach_allowext"]); ?>"/>
					</div>
				</div>

					<div class="form-actions">
						<input type="submit" value="保存" class="btn btn-primary" />
						<input type="reset" value="重置" class="btn btn-primary"/>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">水印设置</div>
			<div class="panel-body">
					<form class="myform form-horizontal" method="post" action="<?php echo U('sysconfig/save');?>">
						<div class="form-group">
							<label class="control-label col-md-2">是否开启图片水印</label>
							<div class="col-md-10">
								<label class="radio-inline">
									<input name="watermark_enable" value="1" <?php if($sysconf["watermark_enable"] == 1): ?>checked<?php endif; ?> type="radio"> 开启
								</label>
								<label class="radio-inline">
									<input name="watermark_enable" value="0" <?php if($sysconf["watermark_enable"] == 0): ?>checked<?php endif; ?> type="radio">关闭
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-md-2">水印添加条件</label>
							<div class="col-md-10">
								<input type="text" name="watermark_minwidth" value="<?php echo ($sysconf["watermark_minwidth"]); ?>" /> PX 宽
								<input type="text" name="watermark_minheight" value="<?php echo ($sysconf["watermark_minheight"]); ?>" /> PX 高
								<label for="">提示：大于该尺寸则水印生效</label>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-2">水印图片</label>
							<div class="col-md-10">
								<input type="hidden" name="watermark_img" id="watermark_img" value="<?php echo ($sysconf["watermark_img"]); ?>"/>
								<div class="thumb_box">
									<div id="image_aid_box"></div>
									<a href="javascript:swfupload('watermark_img','<?php echo get_yzh_auth(1,'200kb',1);?>',yesdo)">
										<img width="50" height="50" src="<?php if(!empty($sysconf['watermark_img'])): echo ($sysconf["watermark_img"]); else: ?>__IMG__/upload_thumb.png<?php endif; ?>" id="watermark_img_pic" ></a><br>
									<input type="button" value="取消图片" onclick="javascript:clean_thumb('watermark_img');" class="btn btn-xs btn-info" />
									<label for="">提示：要求PNG透明格式，建议文件大小＜50KB，水印图片尺寸宽高＜100像素</label>
								</div>
							</div>

						</div>
						<div class="form-group">
							<label class="control-label col-md-2">水印透明度</label>
							<div class="col-md-10">
								<input type="text" class="form-control w-100" name="watermark_pct" value="<?php echo ($sysconf["watermark_pct"]); ?>" />
								<label for="">提示：0-100，值越大透明度越低</label>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-md-2">JPEG 水印质量</label>
							<div class="col-md-10">
								<input type="text" class="form-control w-100" name="watermark_quality" value="<?php echo ($sysconf["watermark_quality"]); ?>" />
								<label for="">提示：0-100，值越大质量越高</label>
							</div>
						</div>

						<!--<div class="form-group">
							<label class="control-label col-md-2">水印边距</label>
							<div class="col-md-10">
								<input type="text" class="form-control" name="watermark_pospadding" value="<?php echo ($sysconf["watermark_pospadding"]); ?>" />
							</div>
						</div>-->

						<div class="form-group">
							<label class="control-label col-md-2">水印位置</label>
							<div class="col-md-10">
								<table class="table table-bordered">
									<tr>
										<td rowspan="3">
											<input name="watermark_pos" value="10" type="radio" <?php if($sysconf["watermark_pos"] == 10): ?>checked<?php endif; ?> > 随机位置
										</td>
										<td>
											<input name="watermark_pos" value="1" type="radio" <?php if($sysconf["watermark_pos"] == 1): ?>checked<?php endif; ?>> 顶部居左
										</td>
										<td>
											<input name="watermark_pos" value="2" type="radio" <?php if($sysconf["watermark_pos"] == 2): ?>checked<?php endif; ?> > 顶部居中
										</td>
										<td>
											<input name="watermark_pos" value="3" type="radio" <?php if($sysconf["watermark_pos"] == 3): ?>checked<?php endif; ?>>顶部居右
										</td>
									</tr>
									<tr>
										<td>
											<input name="watermark_pos" value="4" type="radio" <?php if($sysconf["watermark_pos"] == 4): ?>checked<?php endif; ?>>中部居左
										</td>
										<td>
											<input name="watermark_pos" value="5" type="radio" <?php if($sysconf["watermark_pos"] == 5): ?>checked<?php endif; ?>>垂直居中
										</td>
										<td>
											<input name="watermark_pos" value="6" type="radio" <?php if($sysconf["watermark_pos"] == 6): ?>checked<?php endif; ?>>中部居右
										</td>
									</tr>
									<tr>
										<td>
											<input name="watermark_pos" value="7" type="radio" <?php if($sysconf["watermark_pos"] == 7): ?>checked<?php endif; ?>>底部居左
										</td>
										<td>
											<input name="watermark_pos" value="8" type="radio" <?php if($sysconf["watermark_pos"] == 8): ?>checked<?php endif; ?>>底部居中
										</td>
										<td>
											<input name="watermark_pos" value="9" type="radio" <?php if($sysconf["watermark_pos"] == 9): ?>checked<?php endif; ?>>底部居右
										</td>
									</tr>
								</table>
							</div>
						</div>

						<div class="form-actions">
							<input type="submit" value="保存" class="btn btn-primary" />
							<input type="reset" value="重置" class="btn btn-primary"/>
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




	<link href="__STATIC__/bootstrap-switch/css/bootstrap-switch.css" rel="stylesheet">
	<script src="__STATIC__/bootstrap-switch/js/bootstrap-switch.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#sub_domain").bootstrapSwitch('state',<?php echo ($sysconf['SUB_DOMAIN']); ?>);
			$("#sub_domain").on('switchChange.bootstrapSwitch', function (e, state) {
				if (state) { //on
					$('input[name="SUB_DOMAIN"]').val('1');
				} else { //0FF
					$('input[name="SUB_DOMAIN"]').val('0');
				}
			});

			$('.myform').ajaxForm({
				success:  complete,  // post-submit callback
				dataType: 'json'
			});
		});

		function complete(data){
			if(data.status==1){
				layer.msg('修改成功');
				setTimeout(function(){
					window.location.href = "<?php echo (cookie('__forward__')); ?>";
				},1000);
			}else{
				layer.msg(data.info);
			}
		}

        function robots_set(id){

            var robots_txt = $('#robots_txt_'+id).val();
            $("[name='robots']").html(robots_txt);


        }
	</script>

</body>
</html>