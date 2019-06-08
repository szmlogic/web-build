<?php

class NodeAction extends PublicAction {

    protected $db,$groups;

    function _initialize()
    {
        parent::_initialize();
        $this->db = D('Node');

        $this->groups[0] = array('id'=>0,'name'=>'全局设置');

        foreach($this->Menu as $key=>$r){
            if($r['parentid']==0){
                $this->groups[$r['id']] = $r;
            }
        }

        $this->assign('groups', $this->groups);
    }


    function index()
    {
        $node_db = D('Node');
        $str  = "<tr>
              <td><input name='listorders[\$id]' type='text' size='2' value='\$listorder'></td>
              <td>\$id</td>
              <td>\$spacer\$title</td>
              <td>\$name</td>
              <td>\$status</td>
              <td>\$str_manage</td>
            </tr>";

        import('@.ORG.Tree');

        foreach($this->groups as $key=>$res){

            $result = $node_db->where("groupid={$res['id']}")->select();

            $array = array();
            if (empty($result)) {
                $result = array();
            }
            foreach ($result as $r) {
                $r['str_manage'] = '<a href="'.U('Node/add',array( 'pid' => $r['id'],'groupid'=>$r['groupid'])).'">添加</a> |
                <a href="'.U('Node/edit',array( 'id' => $r['id'])).'">编辑</a> |
                <a href="javascript:confirm_delete(\''.U('Node/delete',array( 'id' => $r['id'])).'\',\''.L('confirm',array('message'=>$r['cname'])).'\')">删除</a> ';
                $r['parentid'] = $r['pid'];
                $r['status']==1 ? $r['status']= '启用' : $r['status']='禁止';
                $array[] = $r;
            }

            $tree = new Tree($array);
            $tree->icon = array('│ &nbsp;&nbsp;&nbsp;', '├─ ', '└─');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            $data = $tree->get_tree(1, $str);

            $nodes[$res['id']]['data']  = $data;
            $nodes[$res['id']]['groupinfo'] = $res;
        }

        $this->assign('nodes', $nodes);

        //记录当前位置
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        $this->display();
    }


    function edit()
    {
        $node_db = D('Node');
        if (IS_POST) {
            if($_POST['pid']){
                $level = $node_db->getById($_POST['pid']);
                $_POST['level'] = $level['level']+1;
            }else{
                $_POST['level'] = 1;
            }

            if (false === $node_db->create()) {
                $this->error($node_db->getError ());
            }

            if (false !== $node_db->save()) {

                $list_child = $node_db->where('pid='.$_POST['id'])->select();
                $data = array();
                $data['groupid'] = $_POST['groupid'];
                foreach ($list_child as $val) {
                    $data['id'] = $val['id'];
                    $node_db->save($data);
                }

                $this->success(L('edit_ok'));
            } else {
                $this->success (L('edit_error').': '.$node_db->getDbError());
            }
        } else {
            $id = I('get.id', 0, 'intval');
            $vo = $node_db->getById($id);
            $this->assign('groupid', $vo['groupid']);
            $pid =  intval($vo['pid']);

            import('@.ORG.Tree' );
            $result = $node_db->select();
            foreach($result as $r) {
                if($r['status']!=1) continue;
                $r['selected'] = $r['id'] == $pid ? 'selected' : '';
                $r['parentid']=$r['pid'];
                $array[] = $r;
            }
            $str  = "<option value='\$id' \$selected>\$spacer \$title</option>";
            $tree = new Tree($array);
            $nodes = $tree->get_tree(0, $str,$pid);
            $this->assign('nodes', $nodes);
            $this->assign('udate', $vo );
            $this->display();
        }
    }

    function add()
    {
        $node_db = D('Node');
        if (IS_POST) {

            if($_POST['pid']){
                $level = $node_db->getById($_POST['pid']);
                $_POST['level'] = $level['level']+1;
            }else{
                $_POST['level'] = 1;
            }

            if (false === $node_db->create ()) {
                $this->error( $model->getError());
            }

            $id = $node_db->add();

            if ($id !==false) {

                savecache('Node');

                $this->success('添加成功!');
            } else {
                $this->error('添加失败: '.$node_db->getDbError());
            }
        } else {
            $groupid = intval($_GET['groupid']);
            $pid = intval($_GET['pid']);

            import('@.ORG.Tree');
            $result = $node_db->select();

            foreach($result as $r) {
                if($r['status']!=1 || $r['level']==3) continue;
                $r['selected'] = $r['id'] == $pid ? 'selected' : '';
                $r['parentid']=$r['pid'];
                $array[] = $r;
            }
            $str  = "<option value='\$id' \$selected>\$spacer \$title</option>";
            $tree = new Tree ($array);
            $nodes  = $tree->get_tree(0, $str,$pid);
            $this->assign('nodes', $nodes);
            $this->assign('groupid', $groupid);
            $this->display();
        }
    }

    /**
     * 删除
     *
     */
    function delete()
    {
        $node_db = M('Node');
        $id = I('get.id', 0, 'intval');

        if ($id) {
            $strChildId = $this->getStrChildId($id);
            if (false !== $node_db->delete($strChildId)) {
                savecache('Node');

                $this->success(L('delete_ok'));
            } else {
                $this->error(L('delete_error').': '.$node_db->getDbError());
            }
        } else {
            $this->error(L('do_empty'));
        }
    }


    public function listview()
    {
        $list = M('Node')->select();

        import('@.ORG.Tree');
        $tree = new Tree();
        $data_list = $tree->toFormatTree($list,'title','id','pid');

        $this->assign('list', $data_list);
        $this->display();
    }

    //获取当前菜单id和子栏目id
    function getStrChildId($id)
    {
        $node_db = M('Node');
        $strChildId = $id;
        $list = $node_db->where('pid='.$id)->select();
        if (!empty($list)) {
            foreach ($list as $val) {
                $strChildId = $strChildId.','.$this->getStrChildId($val['id']);
            }
        }

        return $strChildId;
    }
}