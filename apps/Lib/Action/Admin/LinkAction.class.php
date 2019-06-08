<?php



class LinkAction extends PublicAction {

    /**
     * 列表
     *
     */
    public function index()
    {
        $link_db = M('Link');
        $map = array();
        //取得满足条件的记录总数
        $count = $link_db->where($map)->count('id');

        if ($count > 0) {
            $listRows = ! empty($_REQUEST['listRows'])?$_REQUEST['listRows']:C('PAGE_LISTROWS');

            import("@.ORG.Page");
            //创建分页对象
            $p = new Page($count, $listRows);

            //分页查询数据
            $voList = $link_db->where($map)->limit($p->firstRow . ',' . $p->listRows)->select( );

            //分页跳转的时候保证查询条件
            $p->parameter = '';
            foreach ($map as $key=>$val) {
                if (! is_array($val)) {
                    $p->parameter .= "$key=" . urlencode ( $val ) . "&";
                }
            }
            $map[C('VAR_PAGE')]='{$page}';

            $p->urlrule = U('Link/index', $map);
            //分页显示
            $page = $p->show();

            //模板赋值显示
            $this->assign('list', $voList );
            $this->assign('page', $page );
        }

        //记录当前位置
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        $this->display();
    }


    public function add()
    {
        if (IS_POST) {
            $link_db = M('Link');

            if (empty($_POST['name'])){
                $this->error('网站名称不能为空！');
            }
            if (empty($_POST['siteurl'])){
                $this->error('网站地址不能为空！');
            }

            $_POST['createtime'] = time();
            $_POST['updatetime'] = $_POST['createtime'];

            if (false === $link_db->create()) {
                $this->error($link_db->getError());
            }

            $_POST['id'] = $id= $link_db->add();

            if ($id !==false) {

                if($_POST['aid']) {

                    $Attachment = M('attachment');

                    $aids = implode(',',$_POST['aid']);
                    $data['id'] = $id;
                    $data['catid'] = $catid;
                    $data['status'] = '1';
                    $Attachment->where("aid in (".$aids.")")->save($data);
                }

                $this->success(L('add_ok'));
            } else {
                $this->error(L('add_error').': '.$model_db->getDbError());
            }
        } else {
            $this->display();
        }
    }


    public function edit()
    {
        $link_db = M('Link');
        if (IS_POST) {

            if(empty($_POST))
                $this->error (L('do_empty'));

            if (empty($_POST['name'])){
                $this->error('网站名称不能为空！');
            }
            if (empty($_POST['siteurl'])){
                $this->error('网站地址不能为空！');
            }

            if (false === $link_db->create()) {
                $this->error($link_db->getError());
            }

            // 更新数据
            $list = $link_db->save();

            if (false !== $list) {

                $id = $_POST['id'];

                if($_POST['aid']) {
                    $Attachment =M('attachment');
                    $aids =  implode(',',$_POST['aid']);
                    $data['id']= $id;
                    $data['catid']= $catid;
                    $data['status']= '1';
                    $Attachment->where("aid in (".$aids.")")->save($data);
                }

                $this->success(L('edit_ok'));
            } else {
                //错误提示
                $this->error(L('edit_error').': '.$model->getDbError());
            }
        } else {
            $id = $_REQUEST['id'];

            $vo = $link_db->getById($id);

            $vo['content'] = htmlspecialchars($vo['content']);
            $this->assign($_REQUEST);
            $this->assign('vo', $vo);

            $this->display();
        }
    }


    function delete()
    {
        $link_db = M('Link');
        $id = I('id');
        if (!$id) {
            $this->error('参数不正确！');
        }

        if(false !== $link_db->delete($id)){
            delattach("id in($id)");
            $this->success(L('delete_ok'));
        }else{
            $this->error(L('delete_error').': '.$link_db->getDbError());
        }

    }

    public function listorder()
    {
        $link_db = M('Link');
        $ids = $_POST['listorders'];

        foreach($ids as $key=>$r) {
            $data['listorder']=$r;
            $link_db->where('id='.$key)->save($data);
        }

        $this->success('提交成功!');
    }
}