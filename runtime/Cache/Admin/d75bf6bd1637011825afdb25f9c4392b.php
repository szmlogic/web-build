<?php if (!defined('THINK_PATH')) exit();?><textarea id="<?php echo ($name); ?>" name="<?php echo ($name); ?>" class="form-control" style="height: 400px;"><?php echo ($value); ?></textarea>
<script type="text/javascript" src="__STATIC__/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript">
    KindEditor.ready(function(K) {
        K.create('#<?php echo ($name); ?>', {
            cssPath : '/public/static/kindeditor/plugins/code/prettify.css',
            fileManagerJson:'<?php echo ($upurl); ?>',
            editorid:'content',
            upImgUrl:'<?php echo ($upImgUrl); ?>',
            upFlashUrl:'<?php echo ($upFlashUrl); ?>',
            upMediaUrl:'<?php echo ($upMediaUrl); ?>',
            allowFileManager : true,
            filterMode: false,
            hunqinglineTag:'br',
            items: ['source', '|', 'fullscreen', 'undo', 'redo', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', '|','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'removeformat', '|', 'image', 'multiimage','media', 'table','hr', 'link', 'unlink'],
            afterBlur: function () { this.sync(); }
        });
    });
</script>