<?php

class PageAction extends PublicAction {
    protected  $fields;

    public function _initialize()
    {
        parent::_initialize();
        $this->assign('categorys',$this->Categorys);
        $fields = F($this->modelid.'_Field');
        foreach($fields as $key => $res){
            $res['setup'] = json_decode($res['setup'], true);

            $this->fields[$key]=$res;
        }
        unset($fields);
        unset($res);

        $this->assign ('fields',$this->fields);
    }


    public function index()
    {
        $data = array();
        $data_ids = D('Page')->field('id')->select();
        $ids = array();
        foreach($data_ids as $data_id){
            $ids[]=$data_id['id'];
        }

        foreach($this->Categorys as $d){
            if(($d['model']=='Page'&&$d['parentid']==0)||($d['parentid']==0&&$d['modelid']==0)){
                $parent[]=$d['id'];
                $parent_no[]=$d['modelid']==0?$d['id']:'';
            }
        }

        foreach($parent as $p){
            $ps = explode(',',$this->Categorys[$p]['arrchildid']);
            foreach($ps as $pc){
                if($this->Categorys[$pc]['model']!='Page')
                    continue;
                if(!in_array($pc,$parent_no)){
                    $action = in_array($pc,$ids)?'edit':'add';
                    $data[] = array('catname'=>$this->Categorys[$pc]['catname'],'id'=>$pc,'action'=>$action);
                }
            }
        }

        $this->assign ('list',$data);

        //记录当前位置
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        $this->display();
    }

    /**
     * 添加
     *
     */
    function add()
    {
        $r = M('Category')->find($_GET['id']);
        $vo = array();
        $vo['title'] = $r['catname'];
        $vo['content'] = '';
        $this->assign('vo',$vo);
        $this->display('edit');
    }

    public function edit()
    {
        $page_db = D('Page');
        if (IS_POST) {

            if (false === $page_db->create()) {
                $this->error($page_db->getError());
            }

            if (false !== $page_db->save()) {

                if($_POST['aid']){
                    $Attachment = M('attachment');
                    $aids = implode(',',$_POST['aid']);
                    $data['id'] = $_POST['id'];
                    $data['catid'] = intval($_POST['catid']);
                    $data['status'] = '1';
                    $Attachment->where("aid in (".$aids.")")->save($data);
                }

                $this->success(L('edit_ok'));
            } else {
                $this->success(L('edit_error').': '.$page_db->getDbError());
            }
        } else {
            $id = $_REQUEST['id'];

            $p = $page_db->find($id);

            if(empty($p)){
                $data['id']=$id;
                $data['title'] = $this->Categorys[$id]['catname'];
                $data['keywords'] = $this->Categorys[$id]['keywords'];
                $page_db->add($data);
            }

            $vo = $page_db->getById($id);

            $vo['content'] = htmlspecialchars($vo['content']);

            $form = new Form($vo);

            $this->assign('vo', $vo);
            $this->assign('form', $form);

            $this->display($template);
        }

    }
}