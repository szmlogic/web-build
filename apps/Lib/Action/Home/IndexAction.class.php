<?php
/**
 *
 * IndexAction.class.php (前台首页)
 *
 */
class IndexAction extends PublicAction {

    public function index()
    {
        $this->assign('isIndex',1);
        $this->display();
    }
}