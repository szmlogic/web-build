<?php
/**
 *
 * Adminbase (后台公共模块)
 *
 */

class PublicAction extends Action {

    protected $Mod;
    protected $Config;
    protected $SysConfig;
    protected $Menu;
    protected $Categorys;
    protected $Model;
    protected $modelid;
    protected $Urlrule;
    protected $cache_model;

    function _initialize()
    {
        //检测是否登陆
        $this->checkLogin();
        $this->SysConfig = F('sys.config');
        $this->Menu  = F('Menu');
        $this->Model    = F('Model');
        $this->Urlrule   = F('Urlrule');
        $this->Mod       = F('Mod');
        $this->Categorys = F('Category');
        $this->Config = F('Config');

        $this->assign('model_name',MODULE_NAME);
        $this->assign('action_name',ACTION_NAME);

        C('URL_LANG',$this->SysConfig['DEFAULT_LANG']);
        C('URL_M',$this->SysConfig['URL_MODEL']);
        C('URL_URLRULE',$this->SysConfig['URL_URLRULE']);

        //获取根域名
        $_SESSION['rootdomain'] = GetUrlToDomain($_SERVER["HTTP_HOST"]);

        // 后台用户权限检查
        if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
            import('ORG.Util.RBAC');
            if (!RBAC::AccessDecision('Admin')) {
                //检查认证识别号
                if (!$_SESSION[C('USER_AUTH_KEY')]) {
                    //跳转到认证网关
                    redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                }
                // 没有权限 抛出错误
                if (C('RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    redirect(C('RBAC_ERROR_PAGE'));
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
                    }
                    // 提示错误信息
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }

        import("@.ORG.Form");
        $this->assign('Form', new Form());

        //获取系统菜单导航
        $map['status'] = array('eq', 1);

        //获取菜单
        $topmenu = $this->getTopMenu();
        $this->assign('topmenu',$topmenu);

        $all_menu_list = array();
        if(empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
            foreach ($topmenu as $key1 => $val1) {
                $all_menu_list[$key1] = $val1;
                $temp = M('Menu')->where('parentid=' . $val1['id'])->order('listorder asc')->select();
                if ($temp) {
                    foreach ($temp as $key2 => $val2) {
                        $asidenav = $this->getnav($val2['id']);
                        $aside = array();
                        if ($asidenav) {
                            $all_menu_list[$key1]['_child'][$key2] = $val2;
                            $all_menu_list[$key1]['_child'][$key2]['_child'] = $asidenav;
                        }
                    }
                }
            }
        } else {
            import('@.ORG.Tree');
            $tree = new Tree();
            $menu_lists = $tree->list_to_tree($this->Menu,'id','parentid'); //所有系统菜单

            //设置数组key为菜单ID
            foreach($menu_lists as $key => $val){
                $all_menu_list[$val['id']] = $val;
            }
        }

        $current_menu = D('Menu')->getCurrentMenu(); //当前菜单
        if($current_menu){
            $parent_menu = D('Menu')->getParentMenu($current_menu); //获取面包屑导航
            foreach($parent_menu as $key => $val){
                $parent_menu_id[] = $val['id'];
            }
            $side_menu_list = $all_menu_list[$parent_menu[0]['id']]['_child']; //左侧菜单
        }

        $this->assign('current_menu', $current_menu); //当前菜单
        $this->assign('parent_menu', $parent_menu); //当前菜单的所有父级菜单
        $this->assign('all_menu_list', $all_menu_list); //所有菜单
        $this->assign('side_menu_list', $side_menu_list); //左侧菜单
        $this->assign('__CURRENT_ROOTMENU__', $parent_menu[0]['id']); //当前主菜单
    }


    function getnav($menuid)
    {
        $nav = array();
        if($this->Menu){
            $accessList = $_SESSION['_ACCESS_LIST'];
            foreach($this->Menu as $key=>$module) {

                if($module['parentid'] != $menuid || $module['status']==0)
                    continue;

                if(isset($accessList[strtoupper('Admin')][strtoupper($module['model'])]) || !empty($_SESSION[C('ADMIN_AUTH_KEY')])) {
                    //设置模块访问权限$module['access'] =   1;
                    if(empty($module['action']))
                        $module['action']='index';

                    //检测动作权限
                    if(isset($accessList[strtoupper('Admin')][strtoupper($module['model'])][strtoupper($module['action'])]) || !empty($_SESSION[C('ADMIN_AUTH_KEY')])){
                        $nav[$key]  = $module;

                        $array = array('menuid'=> $nav[$key]['parentid']);

                        if(empty($menuid) && empty($isnav))
                            $array=array();
                        $c = array();
                        parse_str($nav[$key]['data'],$c);
                        $nav[$key]['data'] = $c + $array;
                    }
                }
            }
        }

        return $nav;
    }

    function getTopMenu()
    {
        $topmenu = array();
        if(empty($_SESSION[C('ADMIN_AUTH_KEY')])){
            $modules = array();
            foreach ((array)$_SESSION['_ACCESS_LIST']['ADMIN'] as $key=>$r) {
                $modules[] = ucwords(strtolower($key));
            }

            $modules = implode("','",$modules);

            $alltopnode= M('Node')->field('groupid')->where("name in('$modules') and level=2")->group('groupid')->select();

            $groupAccessids = array();

            foreach ((array)$alltopnode as $key=>$r) {
                $groupAccessids[] = $r['groupid'];
            }

            foreach ($this->Menu as $key=>$module) {

                if($module['parentid'] != 0 || $module['status']==0) {
                    continue;
                }

                if (in_array($key,$groupAccessids) || $_SESSION[C('ADMIN_AUTH_KEY')]) {
                    if (empty($module['action'])){
                        $module['action']='index';
                    }
                    $topmenu[$key] = $module;
                }
            }
        } else {
            //获取顶部菜单
            foreach ($this->Menu as $key=>$module) {

                if($module['parentid'] != 0 || $module['status']==0) {
                    continue;
                }

                if (empty($module['action'])){
                    $module['action']='index';
                }

                $topmenu[$key] = $module;
            }
        }
        return $topmenu;
    }

    public function cache()
    {
        dir_delete(RUNTIME_PATH.'Cache/');
        dir_delete(RUNTIME_PATH.'Data/');
        dir_delete(RUNTIME_PATH.'Logs/');
        if(is_file(RUNTIME_PATH.'~runtime.php')){
            @unlink(RUNTIME_PATH.'~runtime.php');
        }

        R('Admin/Category/repair');

        $this->cache_model = M('Cache')->field('module')->select();

        foreach($this->cache_model as $r){
            savecache($r['module']);
        }

        $this->success('更新缓存成功！');
    }


    public function public_get_views()
    {
        $this->hits_info = M("hits_info");
        $data = array();
        $time = time();
        //昨天
        $yesterday = date('Ymd', strtotime('-1 day'));
        $yesterday_data = $this->hits_info->where(array('d'=>$yesterday))->select();
        if($yesterday_data){
            foreach($yesterday_data as $key=>$val){
                $data[$val['type']]['yesterday'] = $val['hits'];
            }
        }
        //今天
        $day = date('Ymd', $time);
        $day_data = $this->hits_info->where(array('d'=>$day))->select();
        if($day_data){
            foreach($day_data as $key=>$val){
                $data[$val['type']]['day'] = $val['hits'];
            }
        }
        //本周
        //$week_start = mktime(0, 0 , 0,date("m"),date("d")-date("w")+1,date("Y"));
        //$week_end  =  mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"));
        $week_start = mktime(23,59,59,date("m"),date("d")-7,date("Y"));
        $week_data = $this->hits_info->query("SELECT SUM(hits) AS tp_sum ,type FROM `".C('DB_PREFIX')."hits_info` WHERE ( inputtime between ".$week_start." AND ".time().") GROUP BY type");

        if($week_data){
            foreach($week_data as $key=>$val){
                $data[$val['type']]['week']  = $val['tp_sum'];
            }
        }
        //本月
        //$month_start = mktime(0, 0 , 0,date("m"),1,date("Y"));
        //$month_end  =  mktime(23,59,59,date("m"),date("t"),date("Y"));
        $month_start = mktime(23,59,59,date("m"),date("d")-30,date("Y"));
        $month_data = $this->hits_info->query("SELECT SUM(hits) AS tp_sum ,type FROM `".C('DB_PREFIX')."hits_info` WHERE ( inputtime between ".$month_start." AND ".time().") GROUP BY type");

        if($month_data){
            foreach($month_data as $key=>$val){
                $data[$val['type']]['month']  = $val['tp_sum'];
            }
        }
        //总数
        $views_data = $this->hits_info->query("SELECT SUM(hits) AS tp_sum ,type FROM `".C('DB_PREFIX')."hits_info`  GROUP BY type");

        if($views_data){
            foreach($views_data as $key=>$val){
                $data[$val['type']]['views']  = $val['tp_sum'];
            }
        }
        $datas['data'] = array(
            "pc_pv" => $data[2],
            "pc_ip" => $data[1],
            "mobile_pv" => $data[4],
            "mobile_ip" => $data[3]
        );
        $this->ajaxReturn($datas);
    }

    public function public_get_count() {
        $data = array();
        $data['feedback'] = M('feedback')->count();
        $this->ajaxReturn($data);
    }

    //获取访问量
    public function public_get_chart(){
        $day = I('get.day',7,'intval');
        $type = I('get.type',1,'intval');
        //1pc端 2手机端，------1为pc(ip),2为pc(pv),3为mobile(ip),4为mobile(pv)

        $type_where = $type==1 ? 'and (type = 1 or type =2)' : 'and (type = 3 or type =4)';

        $categories_e_time = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
        $this->hits_info = M("hits_info");
        $start_time = mktime(23,59,59,date("m"),date("d")-$day,date("Y"));

        $sql = "SELECT hits ,type,inputtime FROM `".C('DB_PREFIX')."hits_info` WHERE ( inputtime between ". $start_time ." AND ".$categories_e_time.") ".$type_where ." order by inputtime ASC";
        $result = $this->hits_info->query($sql);

        $types = '';
        if($result){
            foreach($result as $key => $val){
                $inputtime =strtotime(date('m/d',$val['inputtime']));
                if(in_array($val['type'],array(1,3))){
                    $types = 1;
                    $data_type1[$inputtime] = (int)$val['hits'];
                }

                if(in_array($val['type'],array(2,4))){
                    $types = 2;
                    $data_type2[$inputtime]= (int)$val['hits'];
                }
            }
        }
        $categories_s_time = mktime(0,0,0,date("m"),date("d")-$day,date("Y"));
        for($i=$categories_s_time; $i<$categories_e_time;$i+=(24*3600))
        {
            $categories_str[] = date('m/d',$i);
            if(!$data_type1[$i]){
                $data_type1[$i]= 0;
            }
            if(!$data_type2[$i]){
                $data_type2[$i]= 0;
            }
        }
        //正序
        ksort($data_type1);
        ksort($data_type2);
        $data['type1'] = array_values($data_type1);
        $data['type2'] = array_values($data_type2);
        $data['categories'] = $categories_str;
        $this->ajaxReturn($data);
    }

    function checkLogin()
    {
        if(empty($_SESSION['admin'])){
            $this->redirect('Login/index');
        }
    }
}