<?php
/**
 *
 * Attachment(附件管理)
 */
class AttachmentAction extends  PublicAction {

    protected $db;
    protected $userid;

    function _initialize()
    {
        parent::_initialize();
        $this->db = M('Attachment');
        $this->userid = $_SESSION['admin']['id'];
    }

    public function index()
    {
        import('@.ORG.Page');
        $attachment_db = M('Attachment');

        if(empty($_REQUEST['start_time'])){
            $start_time = 0;
        } else {
            $start_time = strtotime($_REQUEST['start_time']);
        }
        if(empty($_REQUEST['end_time'])){
            $end_time = time();
        } else {
            $end_time = strtotime($_REQUEST['end_time']);
        }

        $map['createtime'] = array(array('gt',$start_time),array('lt',$end_time));


        $count = $attachment_db->where($map)->count();
        $page = new Page($count,30);
        $imagearr = explode(',', 'jpg,gif,png,jpeg,bmp,ttf,tif');

        $show = $page->show();
        $this->assign("page",$show);
        $list = $this->db->where($map)->order('aid desc')->limit($page->firstRow.','.$page->listRows)->select();
        foreach((array)$list as $key=>$r){
            $list[$key]['thumb'] = in_array($r['fileext'],$imagearr) ? $r['filepath'] : __ROOT__.'/Public/images/ext/'.$r['fileext'].'.png';
            $list[$key]['filesize'] = byte_format($list[$key]['filesize']);
        }

        $this->assign('list',$list);
        $this->assign($_REQUEST);


        //记录当前位置
        cookie('__forward__', $_SERVER['REQUEST_URI']);

        $this->display();
    }

    public function edit()
    {
        $attachment_db = M('Attachment');
        if (IS_POST) {
            $_POST['updatetime'] = time();
            if (false === $attachment_db->create()) {
                $this->error($attachment_db->getError());
            }

            if (false !== $attachment_db->save()) {
                $this->success('修改成功！');
            }
        } else {
            $aid = $_REQUEST['aid'];

            $vo = $attachment_db->find($aid);

            $form = new Form($vo);

            $this->assign($_REQUEST);
            $this->assign('vo', $vo);
            $this->assign('form', $form);
            $this->display();
        }
    }

    public function swfupload()
    {
        $sessid = time();
        $yzh_auth = $_GET['auth'];
        $yzh_auth_key = sysmd5(C('ADMIN_ACCESS').$_SERVER['HTTP_USER_AGENT']);
        $temp_str = authcode($yzh_auth, 'DECODE', $yzh_auth_key);

        $attach = json_decode($temp_str, true);

        $attach['file_types'] = '*.'.str_replace(",",";*.",$attach['file_types']);

        $count = $this->db->where('status=0 and userid ='.$this->userid)->count();
        $this->assign('no_use_files',$count);

        $this->assign('small_upfile_limit', $attach['file_limit']);

        $this->assign('attach', $attach);


        $watermark_enable = $this->SysConfig['watermark_enable'] ? 1 : 0;

        $this->assign('sessid', $sessid);
        $this->assign('watermark_enable', $watermark_enable);
        $this->assign('userid', $this->userid);

        $swf_auth_key = sysmd5($sessid.$this->userid);
        $this->assign('swf_auth_key',$swf_auth_key);

        $this->assign('more',$_GET['more']);

        $this->display();
    }

    public function upload()
    {
        import("@.ORG.UploadFile");
        $upload = new UploadFile();
        //$upload->supportMulti = false;
        //设置上传文件大小
        $upload->maxSize = $this->SysConfig['attach_maxsize'];
        $upload->autoSub = true;

        $upload->subType = 'date';
        $upload->dateFormat = 'Ym';
        //设置上传文件类型
        $upload->allowExts = explode(',', $this->SysConfig['attach_allowext']);
        //设置附件上传目录
        $upload->savePath = UPLOAD_PATH;
        //设置上传文件规则
        $upload->saveRule = uniqid;

        //删除原图
        $upload->thumbRemoveOrigin = true;

        if (!$upload->upload()) {
            $this->ajaxReturn(0,$upload->getErrorMsg(),0);
        } else {
            //取得成功上传的文件信息
            $uploadList = $upload->getUploadFileInfo();

            if(I('addwater')){
                //$this->Config['watermark_enable']  $_REQUEST['addwater']
                import("@.ORG.Image");
                Image::watermark($uploadList[0]['savepath'].$uploadList[0]['savename'],'',$this->SysConfig);
            }

            $imagearr = explode(',', 'jpg,gif,png,jpeg,bmp,ttf,tif');
            $data = array();

            $attachment_db = M('Attachment');
            $modelid = I('modelid', -1);
            $catid = I('catid', 0);
            //保存当前数据对象
            $data['modelid'] = $modelid;
            $data['catid'] = $catid;
            $data['userid'] = $_SESSION['admin']['id'];
            $data['filename'] = $uploadList[0]['name'];
            $data['filepath'] = __ROOT__.substr($uploadList[0]['savepath'].strtolower($uploadList[0]['savename']),1);
            $data['filesize'] = $uploadList[0]['size'];
            $data['fileext'] = strtolower($uploadList[0]['extension']);
            $data['isimage'] = in_array($data['fileext'],$imagearr) ? 1 : 0;
            $data['isthumb'] = intval($_REQUEST['isthumb']);
            $data['createtime'] = time();
            $data['uploadip'] = get_client_ip();
            $aid = $attachment_db->add($data);
            $returndata['aid']    = $aid;
            $returndata['filepath'] = $data['filepath'];
            $returndata['fileext']  = $data['fileext'];
            $returndata['isimage']  = $data['isimage'];
            $returndata['filename'] = $data['filename'];
            $returndata['filesize'] = $data['filesize'];

            $this->ajaxReturn($returndata,L('upload_ok'), '1');
        }
    }

    public function filelist()
    {
        import('@.ORG.Page' );
        $attachment_db = M('Attachment');
        if(empty($_REQUEST['start_time'])){
            $start_time = '';
        } else {
            $start_time = strtotime($_REQUEST['start_time']);
        }
        if(empty($_REQUEST['end_time'])){
            $end_time = time();
        } else {
            $end_time = strtotime($_REQUEST['end_time']);
        }

        $map['createtime'] = array(array('gt',$start_time),array('lt',$end_time));

        $count = $attachment_db->where($map)->count();

        $Page = new Page($count,12);
        $imagearr = explode(',', 'jpg,gif,png,jpeg,bmp,ttf,tif');

        $Page->urlrule = 'javascript:ajaxload('.$_REQUEST['typeid'].',{$page},\''.$_REQUEST['inputid'].'\',\''.$_REQUEST['start_time'] .'\',\''.$_REQUEST['end_time'] .'\');';
        $show = $Page->show();
        $this->assign("page",$show);

        $list = $attachment_db->where($map)->order('aid desc')
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach((array)$list as $key=>$r){
            $list[$key]['thumb']=in_array($r['fileext'],$imagearr) ? $r['filepath'] : __ROOT__.'/public/images/ext/'.$r['fileext'].'.png';
        }
        $this->assign('list',$list);
        $this->assign($_REQUEST);

        $this->display();
    }

    function delfile($aid)
    {
        if(empty($aid)){
            $aid = $_REQUEST['aid'];
        }
        $r = delattach(array('aid'=>$aid));
        if ($r) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }


    function cleanfile()
    {
        $r = delattach(array('status'=>0));
        if($r){
            $this->assign('jumpUrl', U(MODULE_NAME.'/index') );
            $this->success(L ( 'delete_ok' ) );
        }else{
            $this->error(L ( 'delete_error' ) );
        }
    }
}