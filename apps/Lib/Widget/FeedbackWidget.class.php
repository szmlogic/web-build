<?php
/**
 * Class FeedbackWidget
 * 在线留言
 * @author Mr.Weng
 */

class FeedbackWidget extends Action
{
    public function render($data) {

        $this->display('Widget:feedback');
    }

}