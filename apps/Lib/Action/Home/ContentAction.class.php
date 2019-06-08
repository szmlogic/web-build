<?php
/**
 *
 * ContentAction.class.php (前台内容模块)
 *
 */
class ContentAction extends PublicAction {

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

    public function index($catid='',$modelname='')
    {
        $this->Urlrule = F('Urlrule');

        if (empty($catid)) {
            $catid = intval($_GET['id']);
        }

        $p = I('get.p', 1);
        if ($catid) {
            $cat = $this->Categorys[$catid];
            if (empty($modelname)){
                $modelname = $cat['model'];
            }

            $this->assign('model_name',$modelname);
            $this->assign($cat);
            $this->assign('catid',$catid);
        }

        $fields = F($this->Mod[$modelname].'_Field');

        foreach ($fields as $key=>$r) {
            $fields[$key]['setup'] = json_decode($fields[$key]['setup'], true);
        }

        $this->assign('fields', $fields);

        if($catid){
            $seo_title = $cat['title'] ? $cat['title'] : $cat['catname'];
            $this->assign('seo_title',$seo_title);
            $this->assign('seo_keywords',$cat['keywords']);
            $this->assign('seo_description',$cat['description']);

            $condition = array();
            $condition['status']  = 1;
            $condition['createtime']  = array('ELT',time());


            $fields = F($this->Mod[$modelname].'_Field');

            foreach ($fields as $field) {
                if ($field['type'] == 'type') {
                    $field_value = I($field['field'],0 , 'intval');
                    if ($field_value)
                        $condition[$field['field']] = $field_value;
                }
            }

            $setup = json_decode($fields[$key]['setup'],true);

            if ($fields[$key]['type'] == 'relation') {
                //关联信息
                if (!empty($data['relation'])) {
                    $temp_modelname = $this->Model[$setup['modelid']]['tablename'];
                    $data['relation'] = json_decode($data['relation'], true);
                    $relation = M($temp_modelname)->field('url,title,thumb')->where(array('id'=>array('in',$data['relation'])))->select();
                    M($temp_modelname)->getLastSql();
                    $this->assign('relation',$relation);
                }
            }

            if ($setup['fieldtype'] == 'varchar' && $fields[$key]['type']!='text') {
                $data[$key.'_old_val'] = $data[$key];
                $data[$key] = fieldoption($fields[$key],$data[$key]);
            } elseif ($fields[$key]['type']=='images' || $fields[$key]['type']=='files') {
                if(!empty($data[$key])){
                    $data[$key] = json_decode($data[$key],true);
                }
            }



            if ($cat['child']) {
                $condition['catid']  = array('in',$cat['arrchildid']);
            } else {
                $condition['catid']  = $catid;
            }

            if (empty($cat['listtype'])) {

                $model_db = M($modelname);

                $count = $model_db->where($condition)->count();

                if($count){
                    import( "@.ORG.Page" );
                    $listRows =  !empty($cat['pagesize']) ? $cat['pagesize'] : C('PAGE_LISTROWS');
                    $page = new Page($count, $listRows);

                    $page->urlrule = geturl($cat,'',$this->Urlrule);
                    $pages = $page->show();

                    $field =  $this->Model[$this->Mod[$modelname]]['listfields'];
                    $field =  $field ? $field : '*';

                    $list = $model_db->field($field)->where($condition)->order('listorder desc,id desc')->limit($page->firstRow . ',' . $page->listRows)->select();
                    
                    $this->assign('pages',$pages);
                    $this->assign('list',$list);
                }

                $template_r = 'list';

            } else {
                $template_r = 'index';
            }
        } else {
            $template_r = 'list';
        }

        $template = $cat['template_list'] ? $cat['template_list'] : $template_r;

        $this->display($modelname.':'.$template);
    }

    public function detail($id='',$modelname='')
    {
        $this->Urlrule = F('Urlrule');
        $p = I('p', 1, 'intval');
        $id = $id ? $id : intval($_REQUEST['id']);

        if($_GET['chid']) {
          $id = $_GET['chid'];
          $this->assign('chid',$_GET['chid']);
        }

        $modelname = $modelname ? $modelname : MODULE_NAME;
        $this->assign('model_name',$modelname);
        $model_db = M($modelname);;
        $data = $model_db->find($id);

        $listorder = $data['listorder'];

        //上一个，下一个
        $map['createtime'] = array('lt',time());
        $map['catid'] = $data['catid'];
        if($listorder!=0){
            $map['listorder'] = array('lt',$listorder);
            $prea = $model_db->field('title,url')->where($map)->order('listorder desc')->limit('1')->select();

            $map['listorder'] = array('gt',$listorder);
            $next = $model_db->field('title,url')->where($map)->order('listorder asc')->limit('1')->select();
        } else{
            $map['id'] = array('gt',$id);
            $prea = $model_db->field('title,url')->where($map)->order('id asc')->limit('1')->select();
            $map['id'] = array('lt',$id);
            $next = $model_db->field('title,url')->where($map)->order('id desc')->limit('1')->select();
        }

        $this->assign('prea',$prea[0]);
        $this->assign('next',$next[0]);


        $catid = $data['catid'];

        $cat = $this->Categorys[$data['catid']];
        if(empty($cat['ishtml']))
            $model_db->where("id=".$id)->setInc('hits'); //添加点击次数

        //检查是否需要进行权限验证
        $noread = 0;
        if(!empty($data['readgroup'])){
            if(!in_array($this->_groupid,explode(',',$data['readgroup'])) )
                $noread=1;
        }elseif($cat['readgroup']){
            if(!in_array($this->_groupid,explode(',',$cat['readgroup'])) )
                $noread=1;
        }

        if($noread == 1){
            $this->assign('jumpUrl',U('User/Login/index'));
            $this->error ('您的浏览权限不够，请登陆或升级会员组！');
        }

        //seo设置
        $seo_title = $data['title'].'-'.$cat['catname'];
        $this->assign('seo_title',$seo_title);
        $this->assign('seo_keywords',$data['keywords']);
        $this->assign('seo_description',$data['description']);
        $this->assign('fields', F($cat['modelid'].'_Field'));

        $fields = F($this->Mod[$modelname].'_Field');

        foreach($data as $key=>$c_d){
            $setup = json_decode($fields[$key]['setup'],true);

            if ($fields[$key]['type'] == 'relation') {
                //关联信息
                if (!empty($data['relation'])) {
                    $temp_modelname = $this->Model[$setup['modelid']]['tablename'];
                    $data['relation'] = json_decode($data['relation'], true);
                    $relation = M($temp_modelname)->field('url,title,thumb')->where(array('id'=>array('in',$data['relation'])))->select();
                    M($temp_modelname)->getLastSql();
                    $this->assign('relation',$relation);
                }
            }

            if ($setup['fieldtype'] == 'varchar' && $fields[$key]['type']!='text') {
                $data[$key.'_old_val'] = $data[$key];
                $data[$key] = fieldoption($fields[$key],$data[$key]);
            } elseif ($fields[$key]['type']=='images' || $fields[$key]['type']=='files') {
                if(!empty($data[$key])){
                    $data[$key] = json_decode($data[$key],true);
                }
            }
        }

        $this->assign('fields',$fields);

        //手动分页
        $CONTENT_POS = strpos($data['content'], '[page]');
        if($CONTENT_POS !== false) {

            $urlrule    = geturl($cat,$data,$this->Urlrule);
            $urlrule    = str_replace('%7B%24page%7D','{$page}',$urlrule);
            $contents   = array_filter(explode('[page]',$data['content']));
            $pagenumber = count($contents);

            for($i=1; $i<=$pagenumber; $i++) {
                $pageurls[$i] = str_replace('{$page}',$i,$urlrule);
            }

            $pages = content_pages($pagenumber,$p, $pageurls);
            //判断[page]出现的位置是否在文章开始
            if($CONTENT_POS<7) {
                $data['content'] = $contents[$p];
            } else {
                $data['content'] = $contents[$p-1];
            }

            $this->assign ('pages',$pages);
        }

        //判断模板文件
        if(!empty($data['template'])){
            $template = $data['template'];
        }elseif(!empty($cat['template_show'])){
            $template = $cat['template_show'];
        }else{
            $template = 'show';
        }

        $this->assign('catid',$catid);
        $this->assign($cat);

        $this->assign (strtolower($modelname), $data);
        $this->display($modelname.':'.$template);
    }

    public function hits()
    {
        $modelname = $modelname ? $modelname : MODULE_NAME;
        $id        = $id ? $id : intval($_REQUEST['id']);
        $model_db = M($modelname);
        $model_db->where("id=".$id)->setInc('hits');

        if($modelname == 'Download'){
            $r = $model_db->find($id);
            echo '$("#hits").html('.$r['hits'].');$("#downs").html('.$r['downs'].');';
        }else{
            $hits = $model_db->where("id=".$id)->getField('hits');
            echo '$("#hits").html('.$hits.');';
        }
        exit;
    }
}