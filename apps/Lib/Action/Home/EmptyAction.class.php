<?php
/**
 *
 * Empty (空模块)
 */

class EmptyAction extends Action {

    public function _empty() {

        //空操作 空模块
        if(MODULE_NAME!='Urlrule'){
            $Mod = F('Mod');

            if(!$Mod[MODULE_NAME]){
                header("HTTP/1.0 404 Not Found");
                $this->display('/public/404.html');
            }
        }

        $a = ACTION_NAME?ACTION_NAME:"index";

        $id = I('id',0,'intval');
        $catid = I('catid',0,'intval');
        $modelid = I('modelid',0,'intval');

        if(MODULE_NAME=='Urlrule'){

            if($_GET['catdir']){
                $Cat = F('Cat');

                $catid = $catid ? $catid : $Cat[$_REQUEST['catdir']];
                if(!$catid){
                    header("HTTP/1.0 404 Not Found");
                    $this->display('./public/404.html');
                    exit;
                }
                unset($Cat);
            }

            if (!empty($_GET['model'])) {
                $m = I('model');
            } elseif($modelid) {
                $Model = F('Model');
                $m = $Model[$modelid]['tablename'];
                unset($Model);
            } elseif(!empty($catid)) {
                $Category = F('Category');
                $m = $Category[$catid]['model'];
                unset($Category);
            }else{
                header("HTTP/1.0 404 Not Found");
                $this->display();
            }
            if($a=='index')
                $id = $catid;
        }else{
            if(empty($id)){
                $Cat = F('Cat');
                $id = $Cat[$_REQUEST['id']];
                unset($Cat);
            }
            $m = MODULE_NAME;
        }

        import('@.Action.Public');

        if ($m == 'Page') {
            $bae = new PageAction();
        } else {
            $bae = new ContentAction();
        }

        $bae->$a($id,$m);

    }

}