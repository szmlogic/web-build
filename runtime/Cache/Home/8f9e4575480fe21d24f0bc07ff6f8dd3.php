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
                        欢迎光临~<?php echo ($site_name); ?>
                    </span>
                </div>
                <div id="topsearch" class="col-xs-12 col-sm-3 col-md-3">
                    <form id="searchform" action="/?m=search" method="post">
                        <div class="input-group search_group">
                            <input type="text" name="keyword" class="form-control input-sm" value="请输入您要搜索的关键词"
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
                                网站首页
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
    <div class="about_bg" style="background-image: url(<?php echo ($site_aboutpic); ?>)">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p class="about_p">
                        About us
                    </p>
                    <h2 class="about_h2">
                        公 司 简 介
                    </h2>
                    <p class="about_line">
                    </p>
                    <div class="col-xs-12 col-sm-12 col-md-5">
                        <img src="<?php echo ($site_about); ?>" class="about_img" alt="公司简介">
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-7">
                        <p class="about_contents">
                            <?php echo ($block[20]); ?>
                        </p>
                        <a href="<?php echo ($Cats[17][url]); ?>" class="about_more">
                            了解更多
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product_bg" style="background-image: url(<?php echo ($site_productpic); ?>)">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="index_product">
                        <p class="about_p">
                            Product
                        </p>
                        <h2 class="about_h2">
                            产品展示
                        </h2>
                        <p class="about_line">
                        </p>
                        <div class="product_list">
                            <?php
 $_result=M("Product")->field("id,catid,url,title,title_style,keywords,description,thumb,createtime")->where("createtime<=1560083891 AND status=1  AND catid in(7,14,53,15,16) AND posid like '%-1-%'")->order("id desc")->limit("8")->select(); if ($_result) { $i=0; $total = count($_result); foreach($_result as $key=>$r) { ++$i; $mod = ($i % 2 ); ?><div class="col-sm-4 col-md-3 col-mm-6 product_img">
                                    <a href="<?php echo ($r["url"]); ?>">
                                        <img src="<?php echo ($r["thumb"]); ?>" class="opacity_img" alt="<?php echo ($r["title"]); ?>">
                                    </a>
                                    <p class="product_title">
                                        <a href="<?php echo ($r["url"]); ?>" title="<?php echo ($r["title"]); ?>">
                                            <?php echo (str_cut($r["title"],15)); ?>
                                        </a>
                                    </p>
                                </div><?php
 } } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="news_box">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p class="about_p">
                        NEWS
                    </p>
                    <h2 class="about_h2">
                        新闻中心
                    </h2>
                    <p class="about_line">
                    </p>
                    <?php
 $_result=M("Article")->field("id,catid,url,title,title_style,keywords,description,thumb,createtime")->where("createtime<=1560083891 AND status=1  AND catid in(5,11,52,12,13) AND posid like '%-1-%'")->order("id desc")->limit("4")->select(); if ($_result) { $i=0; $total = count($_result); foreach($_result as $key=>$r) { ++$i; $mod = ($i % 2 ); ?><div class="col-sm-4 col-md-3 col-mm-6 index_news">
                            <span>
                                <?php echo (todate($r["createtime"],'Y-m')); ?>
                            </span>
                            <h3>
                                <a href="<?php echo ($r["url"]); ?>" title="<?php echo ($r["title"]); ?>">
                                    <?php echo ($r["title"]); ?>
                                </a>
                            </h3>
                            <p>
                                <?php echo ($r["description"]); ?>
                            </p>
                            <a href="<?php echo ($r["url"]); ?>" class="new_btn">
                                详细&gt;&gt;
                            </a>
                        </div><?php
 } } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="index_case">
                    <p class="about_p">
                        Cases
                    </p>
                    <h2 class="about_h2">
                        施工案例
                    </h2>
                    <p class="about_line">
                    </p>
                    <div class="product_list">
                        <?php
 $_result=M("Picture")->field("id,catid,url,title,title_style,keywords,description,thumb,createtime")->where("createtime<=1560083891 AND status=1  AND catid=19 AND posid like '%-1-%'")->order("id desc")->limit("4")->select(); if ($_result) { $i=0; $total = count($_result); foreach($_result as $key=>$r) { ++$i; $mod = ($i % 2 ); ?><div class="col-sm-4 col-md-3 col-mm-6 product_img">
                                <a href="<?php echo ($r["url"]); ?>">
                                    <img src="<?php echo ($r["thumb"]); ?>" class="opacity_img" alt="<?php echo ($r["title"]); ?>">
                                </a>
                                <p class="product_title">
                                    <a href="<?php echo ($r["url"]); ?>">
                                        <?php echo ($r["title"]); ?>
                                    </a>
                                </p>
                            </div><?php
 } } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="link_box">
        <div class="container">
            <span class="link_title">
                友情链接
            </span>
            <button id="link_btn" class="glyphicon glyphicon-plus" aria-hidden="true">
            </button>
            <span class="link_list">
                <?php
 $_result=M("Link")->field("*")->where(" status = 1  and typeid=0 and  linktype=1")->order("id desc")->limit("20")->select();;$count=count($_result); if ($_result){ $i=0; foreach ($_result as $key=>$r) { ++$i; $mod = ($i % 2 ); ?><a href="<?php echo ($r["siteurl"]); ?>" target="_blank">
                        <?php echo ($r["name"]); ?>
                    </a><?php
 } } ?>
            </span>
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