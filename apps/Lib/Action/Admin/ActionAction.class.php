<?php
/**
 * 行为控制器
 * @author huajie <banhuajie@163.com>
 */
class ActionAction extends PublicAction {

    /**
     * 行为日志列表
     * @author huajie <banhuajie@163.com>
     */
    public function actionLog(){
        //获取列表数据
        $aUid=I('get.uid',0,'intval');
        if($aUid) $map['user_id']=$aUid;
        $map['status']    =   array('gt', -1);
        $list   =   M('ActionLog')->order('id desc')->select();

/*        foreach ($list as $key=>$value){
            $model_id                  =   get_document_field($value['model'],"name","id");
            $list[$key]['model_id']    =   $model_id ? $model_id : 0;
        }*/

        $this->assign('_list', $list);
        $this->display();
    }

    /**
     * 查看行为日志
     * @author huajie <banhuajie@163.com>
     */
    public function detail($id = 0){
        empty($id) && $this->error(L('_PARAMETER_ERROR_'));

        $info = M('ActionLog')->field(true)->find($id);

        $this->assign('info', $info);
        $this->meta_title = L('_CHECK_THE_BEHAVIOR_LOG_');
        $this->display();
    }

    /**
     * 删除日志
     * @param mixed $ids
     * @author huajie <banhuajie@163.com>
     */
    public function remove($ids = 0){
        empty($ids) && $this->error(L('_PARAMETER_ERROR_'));
        if(is_array($ids)){
            $map['id'] = array('in', $ids);
        }elseif (is_numeric($ids)){
            $map['id'] = $ids;
        }
        $res = M('ActionLog')->where($map)->delete();
        if($res !== false){
            $this->success(L('_DELETE_SUCCESS_'));
        }else {
            $this->error(L('_DELETE_FAILED_'));
        }
    }

    /**
     * 清空日志
     */
    public function clear(){
        $res = M('ActionLog')->where('1=1')->delete();
        if($res !== false){
            $this->success(L('_LOG_EMPTY_SUCCESSFULLY_'));
        }else {
            $this->error(L('_LOG_EMPTY_'));
        }
    }

}
