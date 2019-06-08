<?php



class KefuAction extends PublicAction {

    protected  $db,$fields;

    /**
     * 列表
     *
     */
    public function index()
    {
        $model = M('Kefu');

        $this->assign($_REQUEST);

        //取得满足条件的记录总数
        $count = $model->where($map)->count($id);
        //echo $model->getLastsql();

        if ($count > 0) {
            import("@.ORG.Page");

            $p = new Page($count, 15);

            //分页查询数据
            $voList = $model->where($map)->limit($p->firstRow . ',' . $p->listRows)->select ( );

            //分页跳转的时候保证查询条件
            foreach ( $map as $key => $val ) {
                if (! is_array ( $val )) {
                    $p->parameter .= "$key=" . urlencode ( $val ) . "&";
                }
            }
            $map[C('VAR_PAGE')]='{$page}';

            $page->urlrule = U('Kefu/index', $map);
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
        $model = D('Kefu');

        if (IS_POST) {

            if (empty($_POST['name'])){
                $this->error('客服名称不能为空！');
            }

            $_POST['createtime'] = time();
            $_POST['updatetime'] = $_POST['createtime'];

            if (false === $model->create()) {
                $this->error($model->getError());
            }

            $_POST['id'] = $id= $model->add();

            if ($id !==false) {

                if($_POST['aid']) {

                    $Attachment = M('attachment');

                    $aids = implode(',',$_POST['aid']);
                    $data['id']=$id;
                    $data['catid']= $catid;
                    $data['status']= '1';
                    $Attachment->where("aid in (".$aids.")")->save($data);
                }

                $this->assign('jumpUrl', U('Kefu/index') );

                $this->success(L('add_ok'));
            } else {
                $this->error(L('add_error').': '.$model->getDbError());
            }
        } else {
            $this->display();
        }

    }


    public function edit()
    {
        $model = D('Kefu');

        if (IS_POST) {

            if (empty($_POST['name'])){
                $this->error('客服名称不能为空！');
            }

            if (false === $model->create()) {
                $this->error($model->getError());
            }

            // 更新数据
            $list = $model->save();

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

            $vo = $model->getById($id);

            $vo['content'] = htmlspecialchars($vo['content']);

            $this->assign('vo', $vo);

            $this->display();
        }
    }

    function delete()
    {
        $model = M('Kefu');
        $id = I('get.id', 0 ,'intval');

        if(isset($id)) {
            if(false!==$model->delete($id)){
                $this->success(L('delete_ok'));
            }else{
                $this->error(L('delete_error').': '.$model->getDbError());
            }
        }else{
            $this->error(L('do_empty'));
        }
    }

    /*状态*/
    public function status()
    {
        $model = D('Kefu');

        if($model->save($_GET)){
            $this->success(L('do_ok'));
        }else{
            $this->error(L('do_error'));
        }
    }
}