<?php

/**
 *
 * Config(系统配置文件)
 *
 */
class SysconfigAction extends PublicAction {

    public function index()
    {
        $model = M('Sysconfig');
        $data = $model->select();
        $sysconf = array();
        foreach($data as $key=>$r) {
            if ($r['varname'] == 'attach_maxsize') {
                $temp_size = byteFormat($r['value'], "MB", 0);
                $sysconf[$r['varname']] = substr($temp_size,0,-2);
            } else {
                $sysconf[$r['varname']] = $r['value'];
            }
        }

        $this->assign('sysconf',$sysconf);

        //获取robots.txt
        $robots = file_get_contents('robots.txt');
        $this->assign('robots', $robots);
        $robots_txt1 = <<<yuzihao
User-agent:*
Disallow:/
yuzihao;
        $robots_txt2 = <<<yuzihao
User-agent: *
Disallow: /public/
Disallow: /core/
Disallow: /admin/
Disallow: /apps/
Disallow: /*.js$
Disallow: /*.css$
yuzihao;

        $this->assign('robots_txt1', $robots_txt1);
        $this->assign('robots_txt2', $robots_txt2);

        //记录当前位置
        cookie('__forward__', $_SERVER['REQUEST_URI']);
        
        $this->display();
    }

    public function advanced()
    {
        $model = M('Sysconfig');
        if (IS_POST) {
            if(C('TOKEN_ON') && !$model->autoCheckToken($_POST))
                $this->error(L('_TOKEN_ERROR_'));

            if(isset($_POST['site_url'])){
                $_POST['site_url'] = str_replace('http://', '', $_POST['site_url']);
                $_POST['site_url'] = rtrim($_POST['site_url'],'/');
            }

            $where ="";

            if(isset($_POST['lang'])){
                $where.= " AND lang={$_POST['lang']}";
            }

            foreach($_POST as $key=>$value){
                $data['value'] = $value;
                $f = $model->where("varname='".$key."'".$where)->save($data);
            }
            savecache('Sysconfig');

            if($_POST['DEFAULT_LANG'])
                routes_cache($_POST['URL_URLRULE']);

            if($f){
                $this->success('提交成功!');
            }else{
                $this->error('提交失败!');
            }
        } else {
            $sysconfig = F("sys.config");
            $Urlrule=array();
            foreach((array)$this->Urlrule as $key => $r){
                $urls=$r['showurlrule'].':::'.$r['listurlrule'];
                if(empty($r['ishtml']))
                    $Urlrule[$urls] = "内容页:".$r['showexample'].", 列表页:".$r['listexample'];
            }
            $this->assign('Urlrule',$Urlrule);

            $this->assign('yesorno',array(0 => L('no'),1  => L('yes')));
            $this->assign('openarr',array(0 => L('close_select'),1  => L('open_select')));
            $this->assign('enablearr',array(0 => L('disable'),1  => L('enable')));

            $urlmodelArr = array(
                                0 => '普通模式(m=module&a=action&id=1)',
                                1 => 'PATHINFO模式(index.php/Index_index_id_1)',
                                2 => 'REWRITE模式(Index_index_id_1)',
                                3 => '兼容模式'
                            );
            $this->assign('urlmodelarr', $urlmodelArr);
            $this->assign('readtypearr', array(0=>'readfile',1=> 'redirect'));
            $this->assign($sysconfig);

            $this->display();
        }
    }

    function robots()
    {
        $content = $_POST['robots'];
        $r = file_put_contents('robots.txt', $content);

        if ($r) {
            $this->success('保存成功!');
        } else {
            $this->success('保存失败!');
        }
    }

    //邮箱设置
    public function mail()
    {
        $sysconfig_db = M('Sysconfig');
        $data = $sysconfig_db->select();
        $sysconf = array();
        foreach($data as $key=>$r) {
            $sysconf[$r['varname']] = $r['value'];
        }

        $this->assign('sysconf',$sysconf);
        $this->display();
    }

    public function save()
    {
        if(C('TOKEN_ON') && !$this->db->autoCheckToken($_POST))
            $this->error(L('_TOKEN_ERROR_'));

        if(isset($_POST['site_url'])){
            $_POST['site_url'] = str_replace('http://', '', $_POST['site_url']);
            $_POST['site_url'] = rtrim($_POST['site_url'],'/');
        }

        $sta = false;
        if ($_POST['attach_maxsize'] > 5) {
            $this->error('允许上传附件大小不能超过5M！');
        }
        foreach($_POST as $key=>$value){
            if ($key == 'attach_maxsize') {
                $data['value'] = $value*1024*1024;
            } else {
                $data['value'] = $value;
            }
            $f = M('Sysconfig')->where("varname='".$key."'")->save($data);
            if ($f) {
                $sta = true;
            }
        }
        savecache('Sysconfig');

        if($_POST['DEFAULT_LANG'])
            routes_cache($_POST['URL_URLRULE']);

        if($sta){
            $this->success('保存成功!');
        }else{
            $this->error('没有发生更改!');
        }
    }

    public function testmail()
    {
        $mailto = I('get.mail_to');
        $message = '这是一封测试邮件';
        $r = sendmail($mailto,$this->Config['site_name'],$message,$this->SysConfig);

        if($r){
            $this->success('邮件发送成功！');
        }else{
            $this->error('邮件发送失败！'.$r);
        }
    }
}