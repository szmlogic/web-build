$(document).ready(function(){
    var imgwidth=$('.product_img img').width();
    var imgheight=$('.product_img img').height();
    $('.product_title').css("top",imgheight * 0.4);
    // 0.4代表遮罩的透明度
    $('.product_img div').css('opacity',0.3);
    $('.product_img').hover(function(){
        var el = $(this);
        // 先淡出阴影，后淡入文字
        el.find('div').stop().animate({width:imgwidth,height:imgheight},'slow',function(){
            el.find('p').fadeIn('fast');
        });
    },function(){
        var el = $(this);
        // 隐藏文字
        el.find('p').stop(true,true).hide();
        // 去掉遮罩
        el.find('div').stop().animate({width:0,height:0},'fast');
    }).click(function(){
        // 点击图片时打开链接
       window.location=$(this).find('a').attr('href');
    });

});