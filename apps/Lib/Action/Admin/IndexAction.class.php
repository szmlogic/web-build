<?php


class IndexAction extends PublicAction {

    public function index()
    {
        $role = F("RoleUser");
        $this->assign('usergroup',$role[$_SESSION['roleid']]['name']);

        $this->assign($this->Config);

        D('');
        $db = DB::getInstance();
        $info = array(
              'SERVER_SOFTWARE'       => PHP_OS.' '.$_SERVER["SERVER_SOFTWARE"],
              'mysql_get_server_info' => php_sapi_name(),
              'MYSQL_VERSION'         => mysql_get_server_info(),
              'upload_max_filesize'   => ini_get('upload_max_filesize'),
              'max_execution_time'    => ini_get('max_execution_time').L('miao'),
              'disk_free_space'       => round((@disk_free_space(".")/(1024*1024)),2).'M',
              );

        $this->assign('server_info',$info);

        $models = array();
        foreach ((array)$this->Model as $val) {
            if($val['type']==1 && $val['status'] == 1){
                $models[] = $val;
                $model_db = M($val['tablename']);
                $mdata[$val['tablename']] = $model_db->count();
            }
        }

        $model_db = M('User');
        $counts = $model_db->count();
        $userinfos = $model_db->find($_SESSION['admin']['id']);

        $mdata['User'] = $counts;
        $mdata['Category'] = M('Category')->count();
        $mdata['Link'] = M('Link')->count();

        $Form = F('Form');
        $mdata['formdata'] = 0;
        foreach ($Form as $item) {
            $mdata['formdata'] += M($item['tablename'])->count('id');
        }

        $this->assign('models',$models);
        $this->assign('mdata',$mdata);

        $userinfo = array(
          'username'    =>$userinfos['username'],
          'groupname'   =>$role[$userinfos['role']]['name'],
          'login_time'   =>toDate($userinfos['last_login_time']),
          'last_ip'     =>$userinfos['last_ip'],
          'login_count' =>$userinfos['login_count'].'次',
        );


        $this->assign('userinfo',$userinfo);

        //快捷操作
        $shortcuts = json_decode($this->Config['shortcuts'],true);
        $this->assign('shortcuts', $shortcuts);

        $this->display();
    }

    //快捷操作
    public function shortcuts()
    {
        if (IS_POST) {
            $config_db = M('Config');
            $sta = false;
            $data = array();
            foreach($_POST['name'] as $key=>$value){
                $data[$key]['name'] = $value;
                $data[$key]['url'] = $_POST['url'][$key];
            }

            $shortcuts = json_encode($data);

            $f = $config_db->where("varname='shortcuts'")->save(array('value'=>$shortcuts));
            if ($f) {
                $sta = true;
            }
            savecache('Config');

            if($sta){
                $this->success('保存成功!');
            }else{
                $this->error('没有发生更改!');
            }
            exit;
        }

        $shortcuts = json_decode($this->Config['shortcuts'],true);
        $this->assign('shortcuts', $shortcuts);
        $this->display();
    }
}