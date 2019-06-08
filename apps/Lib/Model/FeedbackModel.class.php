<?php
class FeedbackModel extends Model {
    
    /*
     * 表单验证
     */
    protected  $_validate = array(
        array('uname','require','用户名不能为空！',1,'regex',1),
        array('tel','/^1[3|4|5|8][0-9]\d{4,8}$/','手机号码错误！',0,'regex',1),
        array('email','require','邮箱不能为空！',1,'regex',3),
        array('email','email','邮箱格式不对!'),
        array('content','require','内容不能为空！',0,'regex',1),
    );


    /*
     * 自动完成
     */
    protected $_auto = array(
        array('createtime','time',1,'function'),
        array('updatetime','time',2,'function'),
        array('reg_ip','get_client_ip',1,'function'),
    );
}
?>