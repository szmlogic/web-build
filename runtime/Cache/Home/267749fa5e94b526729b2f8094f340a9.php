<?php if (!defined('THINK_PATH')) exit();?><div class="kefuBox" id="kefu">
    <div class="kefuLeft">
    </div>
    <div class="kefuRight">
        <div class="kefuTop">
            <div class="kefuClose">
            </div>
        </div>
        <div class="kefuCont">
            <ul>
                <li class="pic">
                    <img src="__IMG__/kefu/pic.png">
                </li>
                <?php echo ($html); ?>
                <li class="codeer">
                    <p>
                        扫一扫,关注我们
                    </p>
                    <span>
                        <img src="<?php echo ($site_wzqrcode); ?>" />
                    </span>
                </li>
            </ul>
        </div>
        <div class="kefuBottom">
        </div>
    </div>
</div>
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