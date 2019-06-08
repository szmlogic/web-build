<?php
/**
 *
 * Base (前台公共模块)
 *
 */
class PageAction extends PublicAction {

    public function _initialize()
    {
        parent::_initialize();

        $_GET['id'] = !empty($_GET['id'])?$_GET['id']:0;

        //栏目id
        $catid = !empty($_GET['catid']) ? $_GET['catid'] : $_GET['id'];

        if(empty($catid)){
            $Cat = F('Cat');
            $catid = $Cat[I('get.catdir')];
        }

        if(array_key_exists($catid,$this->Categorys)){
            $parencats = explode(',',$this->Categorys[$catid]['arrparentid']);
            $max_parent_catid = empty($parencats[1]) ? $catid : $parencats[1];
            $this->assign('max_parent_catid',$max_parent_catid);
            $this->assign('max_parent_catname',$this->Categorys[$max_parent_catid]['catname']);
        }

        //当前栏目id
        $this->assign('current_catid',$catid);
    }

    public function index($catid='',$module='')
    {
        //获取路由规则
        $this->Urlrule = F('Urlrule');

        if (empty($catid)) {
            $catid = I('get.id');
        }
        if ($catid) {
            $cat = $this->Categorys[$catid];
            $this->assign($cat);
            $this->assign('catid',$catid);
        }

        $seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
        $this->assign('seo_title',$seo_title);
        $this->assign('seo_keywords',$cat['keywords']);
        $this->assign('seo_description',$cat['description']);

        $page_db = M('Page');

        $data = $page_db->find($catid);

        $template = $cat['template_list'] ? $cat['template_list'] : 'index' ;

        $this->assign($data);
        $this->display('Page:'.$template);
    }

    public function hits()
    {
        $module    = $module ? $module : MODULE_NAME;
        $id        = $id ? $id : intval($_REQUEST['id']);
        $this->db = M($module);
        $this->db->where("id=".$id)->setInc('hits');

        if($module=='Download'){
            $r = $this->db->find($id);
            echo '$("#hits").html('.$r['hits'].');$("#downs").html('.$r['downs'].');';
        }else{
            $hits = $this->db->where("id=".$id)->getField('hits');
            echo '$("#hits").html('.$hits.');';
        }
        exit;
    }
}