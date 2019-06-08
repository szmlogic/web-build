<?php
/**
 *
 * SearchAction.class.php (前台搜索功能)
 */
class SearchAction extends PublicAction {

    public function index()
    {
        $p       = intval($_REQUEST[C('VAR_PAGE')]);
        $keyword = $_GET['keyword'] = I('keyword');
        $modelid = $_GET['modelid'] = I('modelid', 3, 'intval');
        $time = $_GET['time'] = I('time', 'all', 'string');

        $this->assign($_REQUEST);

        //可搜索内容模型
        $model_search = array();
        foreach ($this->Model as $val) {
            if ($val['issearch'] == 1) {
                $model_search[] = $val;
            }
        }
        $this->assign('model_search', $model_search);


        $this->assign('seo_title', $this->Config['seo_title']);
        $this->assign('seo_keywords', $this->Config['seo_keywords']);
        $this->assign('seo_description', $this->Config['seo_description']);

        $modelname = $this->Model[$modelid]['tablename'];

        $where = array();
        $where['status'] = 1;

        switch($time){
            case 'day':
                $begintime = mktime(0,0,0,date('m'),date('d')-1,date('Y'));
                $endtime = mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
                $where['createtime'] =  array('between',array($begintime,$endtime));
                break;
            case 'week':
                $begintime = mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'));
                $endtime = mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'));
                $where['createtime'] =  array('between',array($begintime,$endtime));
                break;
            case 'month':
                //php获取本月起始时间戳和结束时间戳
                $begintime = mktime(0,0,0,date('m')-1,date('d'),date('Y'));
                $endtime = mktime(23,59,59,date('m'),date('d'),date('Y'));
                $where['createtime'] =  array('between',array($begintime,$endtime));
                break;
            case 'year':
                $begintime = mktime(0,0,0,date('m'),date('t'),date('Y')-1);
                $endtime = mktime(0,0,0,date('m'),date('t'),date('Y'));
                $where['createtime'] =  array('between',array($begintime,$endtime));
                break;
            default;
        }

        $where['title'] = array('like',"%$keyword%");

        $db = M($modelname);
        $count = $db->where($where)->count();

        if($count) {
            import("@.ORG.Page");
            $page = new Page($count, 10);
            $pages = $page->show();

            $field = 'id,userid,url,title,keywords,description,thumb,createtime';

            $list = $db->field($field)->where($where)->order('listorder desc,id desc')->limit($page->firstRow . ',' . $page->listRows)->select();

            $this->assign('pages', $pages);
            $this->assign('list', $list);
        }
        $this->assign($_GET);
        $this->display();
    }
}