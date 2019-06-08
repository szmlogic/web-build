<?php
/**
 *
 * Base (前台公共模块)
 *
 */
class PublicAction extends Action {
    protected $Config;
    protected $SysConfig;
    protected $Categorys;
    protected $Mod;
    protected $Model;
    protected $_groupid;
    protected $_userid;

    public function _initialize()
    {
        $this->SysConfig = F('sys.config');
        $this->Model     = F('Model');
        $this->Mod       = F('Mod');

        //用户组
        $this->_groupid = !empty($_SESSION['member']['groupid'])?$_SESSION['member']['groupid']:0;
        $this->_userid = !empty($_SESSION['member']['id'])?$_SESSION['member']['id']:0;

        //检测是否是手机访问
        $this->checkMobile();

        //获取栏目
        $this->Categorys = F('Category');

        //获取网站配置信息
        $this->Config = F('Config');

        $this->assign($this->Config);
        $this->assign('Model',$this->Model);
        $this->assign('Cats',$this->Categorys);

        C('PAGE_LISTROWS',$this->SysConfig['PAGE_LISTROWS']);
        C('URL_M',$this->SysConfig['URL_MODEL']);
        C('URL_LANG',$this->SysConfig['DEFAULT_LANG']);

        $current = !empty($_SERVER['HTTP_X_REWRITE_URL']) ? $_SERVER['HTTP_X_REWRITE_URL'] : $_SERVER['REQUEST_URI'];

        $this->assign('current',$current);

        //获取碎片
        $data_block = M('Block')->where(array('group'=>1))->select();
        $block = array();
        foreach ($data_block as $val) {
            $block[$val['id']] = $val['content'];
        }

        $this->assign('block',$block);
    }

    //验证码
    public function verify()
    {
        header('Content-type: image/jpeg');
        $type = isset($_GET['type'])?$_GET['type']:'jpeg';
        import("@.ORG.Image");
        ob_end_clean();
        Image::buildImageVerify(4,1,$type);
    }

    //检测是否登录
    function checkLogin()
    {
        if (empty($_SESSION['member']['username'])) {
            $this->redirect('User/Login/index');
        }
    }


    //检测是否是移动设备
    function checkMobile()
    {
        import('ORG.Util.MobileDetect');
        $detect = new MobileDetect;
        if ($detect->isMobile() || $detect->isTablet()) {
            if ($this->SysConfig['SUB_DOMAIN'] == 1) {
                redirect('http://'.C('SITE_WAP_DOMAIN'));
            }
        }
    }
}