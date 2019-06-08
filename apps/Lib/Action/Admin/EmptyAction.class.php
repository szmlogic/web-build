<?php
/**
 *
 * Empty (空模块)
 */
class EmptyAction extends Action {

    public function _empty()
    {
        //空操作 空模块
        if (MODULE_NAME!='Urlrule') {
            $Mod = F('Mod');
            if(!$Mod[MODULE_NAME]){
                throw_exception('404');
            }
        }

        R('Admin/Content/'.ACTION_NAME);
    }
}