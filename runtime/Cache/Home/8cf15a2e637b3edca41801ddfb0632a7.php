<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?php echo ($seo_title); ?>-<?php echo ($site_name); ?>
        </title>
        <meta name="keywords" content="<?php echo ($seo_keywords); ?>" />
        <meta name="description" content="<?php echo ($seo_description); ?>" />
        <meta name="applicable-device" content="pc,mobile">
        <link rel="stylesheet" type="text/css" href="__CSS__/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="__CSS__/bxslider.css">
        <link rel="stylesheet" type="text/css" href="__CSS__/style.css">
        <script src="__JS__/jquery.min.js" type="text/javascript">
        </script>
        <script src="__JS__/bxslider.min.js" type="text/javascript">
        </script>
        <script src="__JS__/common.js" type="text/javascript">
        </script>
        <script src="__JS__/bootstrap.js" type="text/javascript">
        </script>
        <!--[if lt IE 9]>
            <script src="__JS__/html5shiv.min.js" type="text/javascript">
            </script>
            <script src="__JS__/respond.min.js" type="text/javascript">
            </script>
        <![endif]-->
        <link rel="stylesheet" type="text/css" href="__CSS__/lightbox.css">
        <script src="__JS__/lightbox.js" type="text/javascript">
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.showpic_flash').bxSlider({
                    pagerCustom: '#pic-page',
                    adaptiveHeight: true,
                });

            });
        </script>
    </head>
    <header>
        <div class="top_menu">
            <div class="container">
                <div class="col-xs-12 col-sm-9 col-md-9">
                    <span class="top_name">
                        Welcome~<?php echo ($site_name); ?>
                    </span>
                </div>
                <div id="topsearch" class="col-xs-12 col-sm-3 col-md-3">
                    <form id="searchform" action="/?m=search" method="post">
                        <div class="input-group search_group">
                            <input type="text" name="keyword" class="form-control input-sm" value="Please enter keywords"
                            onFocus="this.value=''" onBlur="if(!value){value=defaultValue;}">
                            <span class="input-group-btn">
                                <span id="submit_search" onclick="searchform.submit();" title="产品搜索" class="glyphicon glyphicon-search btn-lg"
                                aria-hidden="true">
                                </span>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-9 col-md-9">
                    <a href="/">
                        <img src="<?php echo ($site_logo); ?>" class="logo" alt="<?php echo ($site_name); ?>">
                    </a>
                </div>
                <!-- <div class="col-xs-12 col-sm-3 col-md-3 tel_box">
                    <div class="top_tel">
                        <img src="/themes/Home/Public/images/tel.jpg" alt="服务热线">
                    </div>
                    <div class="top_number">
                        <span>
                            全国客服热线：
                        </span>
                        <p>
                            <?php echo ($site_telephone); ?>
                        </p>
                    </div>
                </div> -->
            </div>
        </div>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">
                            Toggle navigation
                        </span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                        <span class="icon-bar">
                        </span>
                    </button>
                    <span id="small_search" class="glyphicon glyphicon-search" aria-hidden="true">
                    </span>
                    <a class="navbar-brand" href="#">
                        导航菜单
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/">
                                Home
                            </a>
                        </li>
                        <?php
 $count=0; foreach ($Cats as $keyy=>$vy) { if($vy["ismenu"]==1 && intval(0)==$vy["parentid"]) { $count++; } } $n=0; foreach ($Cats as $key=>$r) { if( $r['ismenu']==1 && intval(0)==$r["parentid"]) { ++$n; ?><li class="dropdown">
                                <a href="<?php echo ($r["url"]); ?>">
                                    <?php echo ($r["catname"]); ?>
                                </a>
                                <a href="<?php echo ($r["url"]); ?>" id="app_menudown" class="dropdown-toggle" data-toggle="dropdown"
                                role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-menu-down btn-xs">
                                    </span>
                                </a>
                                <?php if($r['child']=="1") : ?>
                                <ul class="dropdown-menu nav_small" role="menu">
                                    <?php
 $count=0; foreach ($Cats as $keyy=>$vy) { if($vy["ismenu"]==1 && intval($r['id'])==$vy["parentid"]) { $count++; } } $n=0; foreach ($Cats as $key=>$rr) { if( $rr['ismenu']==1 && intval($r['id'])==$rr["parentid"]) { ++$n; ?><li>
                                            <a href="<?php echo ($rr["url"]); ?>">
                                                <?php echo ($rr["catname"]); ?>
                                            </a>
                                        </li><?php
 } } ?>
                                </ul>
                                <?php endif;?>
                            </li><?php
 } } ?>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>
        <?php if(!empty($isIndex)) : ?>
            <!-- bxslider -->
    <div class="flash">
        <ul class="bxslider">
            <?php $slide = getSlide(1); ?>
            <?php if(is_array($slide)): $i = 0; $__LIST__ = $slide;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><li>
                    <a href="<?php echo ($r['link']); ?>">
                        <img src="<?php echo ($r['pic']); ?>" alt="<?php echo ($r['title']); ?>" />
                    </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <script type="text/javascript">
        $('.bxslider').bxSlider({
            adaptiveHeight: true,
            infiniteLoop: true,
            hideControlOnEnd: true,
            auto: true
        });
    </script>

        <?php else :?>
        <div class="page_bg" style="background:url(<?php if($Cats[$max_parent_catid]['image']) : ?>
        <?php echo ($Cats[$max_parent_catid]['image']); else : echo ($Cats[$catid]['image']); ?>
        <?php endif;?>">
        </div>
        <?php endif;?>
<body>
    <div class="container">
        <div class="row">
            <!-- right -->
            <div class="col-xs-12 col-sm-8 col-md-9" style="float:right">
                <div class="list_box">
                    <h2 class="left_h2">
                        <?php echo ($catname); ?>
                    </h2>
                    <div class="product_list product_list2">
                        <?php if(!empty($list)): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$r): $mod = ($i % 2 );++$i;?><div class="col-sm-4 col-md-4 col-mm-6 product_img">
                                    <a href="<?php echo ($r["url"]); ?>">
                                        <img src="<?php echo ($r["thumb"]); ?>" class="opacity_img" alt="<?php echo ($r["title"]); ?>" />
                                    </a>
                                    <p class="product_title">
                                        <a href="<?php echo ($r["url"]); ?>" title="<?php echo ($r["title"]); ?>">
                                            <?php echo ($r["title"]); ?>
                                        </a>
                                    </p>
                                </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            <?php else: ?>
                            <?php echo ($catname); endif; ?>
                    </div>
                    <div class="page">
                        <?php echo ($pages); ?>
                    </div>
                </div>
            </div>
            <!-- left -->
            <div class="col-xs-12 col-sm-4 col-md-3">
    <div class="left_nav" id="categories">
        <h1 class="left_h2">
            <?php echo ($max_parent_catname); ?>
        </h1>
        <ul class="left_nav_ul" id="firstpane">
            <?php
 $count=0; foreach ($Cats as $keyy=>$vy) { if($vy["ismenu"]==1 && intval(7)==$vy["parentid"]) { $count++; } } $n=0; foreach ($Cats as $key=>$r) { if( $r['ismenu']==1 && intval(7)==$r["parentid"]) { ++$n; ?><li>
                    <a class="biglink" href="<?php echo ($r["url"]); ?>">
                        <?php echo ($r["catname"]); ?>
                    </a>
                    <span class="menu_head">
                        +
                    </span>
                    <ul class="left_snav_ul menu_body">
                        <?php
 $count=0; foreach ($Cats as $keyy=>$vy) { if($vy["ismenu"]==1 && intval($r['id'])==$vy["parentid"]) { $count++; } } $n=0; foreach ($Cats as $key=>$rr) { if( $rr['ismenu']==1 && intval($r['id'])==$rr["parentid"]) { ++$n; ?><li>
                                <a href="<?php echo ($rr["url"]); ?>">
                                    <?php echo ($rr["catname"]); ?>
                                </a>
                            </li><?php
 } } ?>
                    </ul>
                </li><?php
 } } ?>
        </ul>
    </div>
    <div class="left_news">
        <h1 class="left_h2">
            新闻中心
        </h1>
        <ul class="left_news">
            <?php
 $_result=M("Article")->field("thumb,title,url,createtime")->where("createtime<=1560434063 AND status=1  AND catid in(5,11,52,12,13) AND posid like '%-1-%'")->order("id desc")->limit("5")->select(); if ($_result) { $i=0; $total = count($_result); foreach($_result as $key=>$r) { ++$i; $mod = ($i % 2 ); ?><li>
                    <a href="<?php echo ($r["url"]); ?>" title="<?php echo ($r["title"]); ?>">
                        <?php echo (str_cut($r["title"],28)); ?>
                    </a>
                </li><?php
 } } ?>
        </ul>
    </div>
    <div class="index_contact">
        <h2 class="left_h2">
            联系我们
        </h2>
        <p style="padding-top:8px;">
            联系人：<?php echo ($site_lxr); ?>
        </p>
        <p>
            手机：<?php echo ($site_phone); ?>
        </p>
        <p>
            电话：<?php echo ($site_telephone); ?>
        </p>
        <p>
            邮箱：<?php echo ($site_email); ?>
        </p>
        <p>
            地址：<?php echo ($site_address); ?>
            </a>
        </p>
    </div>
</div>
        </div>
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom footer_nav">
    <div class="foot_nav btn-group dropup">
        <a class="dropdown-toggle" href="/">
            <span class="glyphicon glyphicon-share btn-lg" aria-hidden="true"></span>
            首页
        </a>
    </div>
    <div class="foot_nav">
        <a href="tel:<?php echo ($site_phone); ?>">
            <span class="glyphicon glyphicon-phone btn-lg" aria-hidden="true">
            </span>
            手机
        </a>
    </div>
<div class="foot_nav" aria-hidden="true" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><span class="glyphicon glyphicon-th-list btn-lg"></span>分类</div>
    <div class="foot_nav">
        <a id="gototop" href="#">
            <span class="glyphicon glyphicon-circle-arrow-up btn-lg" aria-hidden="true">
            </span>
            顶部
        </a>
    </div>
</nav>
<footer>
    <div class="copyright">
        <p>
            CopyRight <?php echo ($site_copyright); ?>&nbsp;<?php echo ($site_approve); ?>
        </p>
        <p class="copyright_p">
            地址：<?php echo ($site_address); ?> &nbsp;电话:<?php echo ($site_telephone); ?> &nbsp;
        </p>
    </div>
    <?php echo W('Kefu');?>
</footer>
<link rel="stylesheet" type="text/css" href="__CSS__/chat.css" />
<script>
    $('#kefu .kefuClose').click(function() {
        $('#kefu .kefuLeft').animate({
            width: '30px'
        },
        500);
        $('#kefu .kefuRight').animate({
            width: 0
        },
        100);
    });
    $('.kefuLeft').click(function() {
        $(this).animate({
            width: 0
        },
        100);
        $('.kefuRight').animate({
            width: '154px'
        },
        100);
    });
</script>
<script src="__JS__/main.js" type="text/javascript">
</script>
<script type="text/javascript">
var winHeight=200;
var timer=null;
function show(){
    document.getElementById("popWin").style.display="block"; 
    timer=setInterval("lift(5)",2);
} 
function hid(){
        timer=setInterval("lift(-5)",2);
} 
function lift(n) { 
    var w=document.getElementById("popWin"); 
    var h=parseInt(w.style.height||w.currentStyle.height);
    if (h<winHeight && n>0 || h>1 && n<0){
        w.style.height=(h+n).toString()+"px"; 
    } 
    else
        {
        w.style.display=(n>0?"block":"none");
                clearInterval(timer);
    } 
} 
window.onload=function(){ 
        setTimeout("show()",1000);
} 
</script>
<!--访问统计-->
<script>
    window.onload = function()
    {
        $.ajax({
            url:"<?php echo U('Api/Hitstall/index');?>",
        });
    }
</script>
</html>
</body>

</html>