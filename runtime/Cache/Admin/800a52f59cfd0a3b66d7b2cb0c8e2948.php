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
            

	<?php if(!empty($message)): ?><div class="col-2 col-auto alert-info">
		<h6>提示建议</h6>
		<div class="content">
			<div class="bk20 hr"><hr /></div>
			<?php if(is_array($message)): $i = 0; $__LIST__ = $message;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="on<?php echo ($val["type"]); ?>">&nbsp;<?php echo ($val["content"]); ?></div><br /><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div><?php endif; ?>

    <div class="page-header">

        <div class="pull-left">
            <h1>欢迎使用<?php echo L('system_name');?></h1>
        </div>

        <div class="pull-right">
            <ul class="stats">
                <li class="lightred">
                    <i class="fa fa-calendar"></i>
                    <div class="details">
                        <span class="big"><?php echo date("F j, Y")?></span>
                        <span id="time"></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="content metro-nav">

        <div class="metro-nav-block">
            <a href="">
                <i class="fa fa-eye"></i>
                <div class="info" id="views_pv">0</div>
                <div class="status">浏览量(PV)</div>
            </a>
        </div>
        <div class="metro-nav-block">
            <a href="">
                <i class="fa fa-user"></i>
                <div class="info" id="views_ip">0</div>
                <div class="status">访客数量(IP)</div>
            </a>
        </div>
        <div class="metro-nav-block">
            <a href="">
                <i class="fa fa-comments"></i>
                <div class="info" id="feedback_count">0</div>
                <div class="status">反馈数量</div>
            </a>
        </div>
        <div class="metro-nav-block">
            <a href="">
                <i class="fa fa-comment"></i>
                <div class="info"  id="comment_count">0</div>
                <div class="status">评论</div>
            </a>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 chartshow">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <tr>
                        <th style="text-align:left;"><b class="ico"></b>
                            <span id="type">PC端统计图表</span>
                            <a class="red" href="javascript:;" onclick="refresh_chart(this)">手机端统计图表</a>
                            <a class="green" href="javascript:;" onclick="tab_charts_w(this)">7天</a>
                            <a class="blue" href="javascript:;" onclick="tab_charts_m(this)">30天</a>
                            <img src="__IMG__/loading.gif" alt="">
                        </th>
                    </tr>
                </div>
                <div>
                    <tr>
                        <td style="border-bottom-width:0">
                            <div id="chart" style="height:300px;"></div>
                        </td>
                    </tr>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="content col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-bar-chart-o"></i>数据统计</div>
                <table class="table table-bordered">
                    <tr>
                        <th>信息名称</>
                        <th>总数据</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($models)): $i = 0; $__LIST__ = $models;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo ($r["description"]); ?></td>
                            <td><?php echo ($mdata[$r['tablename']]); ?></td>
                            <td><a class="btn btn-primary btn-xs" href="<?php echo U($r['tablename'].'/index');?>">查看</a></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">系统信息</div>
                <table class="table table-hover">
                    <?php if(is_array($server_info)): $i = 0; $__LIST__ = $server_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                            <td><?php echo L($key);?>:</td>
                            <td><?php echo ($v); ?></td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    <tr>
                        <td>系统名称：</td>
                        <td><?php echo L('system_name');?></td>
                    </tr>

                </table>
            </div>
        </div>


    </div>

</div>


<script type="text/javascript">
function currentTime(){
    var d = new Date(),str = '';

	var today = new Array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
	var week = today[d.getDay()];

    str += week+'&nbsp;&nbsp;';
	str += d.getHours()+':';
	str += d.getMinutes()+':';
	str += d.getSeconds();
	return str;
}
setInterval(function(){$('#time').html(currentTime)},1000);
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




    <script src="__STATIC__/highcharts.js"></script>
    <!--<script src="https://code.highcharts.com/highcharts.js"></script>-->
    <script src="__STATIC__/exporting.js"></script>
    <script>
        $(function(){
            $.ajax({
                url: "<?php echo U('Admin/Public/public_get_views');?>",
                dataType: "json",
                success: function (data) {
                    var r = data.data;

                    //访问数量(pv)
                    $("#views_pv").html(r.pc_pv.views);
                    //访问数量(IP)
                    $("#views_ip").html(r.pc_ip.views);
                    /*==================pc=================*/
                    $("#day_pc_pv").html(r.pc_pv.day);
                    $("#day_pc_ip").html(r.pc_ip.day);

                    $("#yesterday_pc_pv").html(r.pc_pv.yesterday);
                    $("#yesterday_pc_ip").html(r.pc_ip.yesterday);

                    $("#week_pc_pv").html(r.pc_pv.week);
                    $("#week_pc_ip").html(r.pc_ip.week);

                    $("#month_pc_pv").html(r.pc_pv.month);
                    $("#month_pc_ip").html(r.pc_ip.month);

                    /*================mobile===============*/
                    $("#day_mobile_pv").html(r.mobile_pv.day);
                    $("#day_mobile_ip").html(r.mobile_ip.day);

                    $("#yesterday_mobile_pv").html(r.mobile_pv.yesterday);
                    $("#yesterday_mobile_ip").html(r.mobile_ip.yesterday);

                    $("#week_mobile_pv").html(r.mobile_pv.week);
                    $("#week_mobile_ip").html(r.mobile_ip.week);

                    $("#month_mobile_pv").html(r.mobile_pv.month);
                    $("#month_mobile_ip").html(r.mobile_ip.month);
                },
                error: function () {
                }
            });

            $.ajax({
                url: "<?php echo U('Admin/Public/public_get_count');?>",
                dataType: "json",
                success: function(data){
                    $("#feedback_count").text(data.feedback);
                }
            });
            render_chart();
        });

        var type = 1;
        var day = 10;
        function refresh_chart(obj) {
            var text = $("#type").text();
            $("#type").text($(obj).text());
            $(obj).addClass("hover");
            $(obj).text(text);
            if(type == 1) {
                type = 2;
            }else {
                type = 1;
            }
            day = 10;
            render_chart();
        }

        function tab_charts_w(obj) {
            $(".range").removeClass("range");
            $(obj).addClass("range");
            day = 7;
            render_chart();
        }

        function tab_charts_m(obj) {
            $(".range").removeClass("range");
            $(obj).addClass("range");
            day = 30;
            render_chart();
        }

        function render_chart() {
            $("#loading").css("display", "inline-block");
            $.get("<?php echo U('Admin/Public/public_get_chart');?>", {"type":type, "day":day},
                    function(data){
                        $("#loading").css("display", "none");
                        get_chart(data.type1,data.type2,data.categories,$("#type").text(),type);
                    },"json");
        }

        function get_chart(data1,data2,categories,text,step){
            var text = text ? text : "手机端统计图表";
            var stepval = step ? step: 1;

            Highcharts.setOptions({
                colors:['#27A9E3','#FF6666']
            });
            $('#chart').highcharts({
                chart: {
                    renderTo: 'container',
                    defaultSeriesType: 'line',//图表类别，可取值有：line、spline、area、areaspline、bar、column等
                },
                credits:{
                    enabled:false
                },
                exporting :{
                    enabled :false
                },
                title: {
                    text: text,
                    x: -20
                },
                xAxis: {
                    type : 'datetime',
                    categories: categories,
                    labels:{
                        step:stepval,
                        staggerLines: 1
                    }
                },
                yAxis: {
                    title: {
                        text: 'PV/IP'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }],
                },
                tooltip: {
                    valueSuffix: '',
                    //shared: true
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                    }
                },
                series: [{
                    name: 'IP',
                    data: data1
                }, {
                    name: 'PV',
                    data: data2
                }
                ]
            });
        }
    </script>

</body>
</html>