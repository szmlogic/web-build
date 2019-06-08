<?php
/**
 *
 * Base (前台公共模块)
 *
 */
class CommonAction extends Action {

    public function _initialize()
    {
        //301跳转
        $siteDomains = C('SITE_DOMAINS');
        if (!empty($siteDomains)) {
            $siteDomainArr = explode("\n", C('SITE_DOMAINS'));

            if (in_array($_SERVER['SERVER_NAME'], $siteDomainArr)) {
                header( "HTTP/1.1 301 Moved Permanently" );
                header("location: http://".C('SITE_DOMAIN'));
            }
        }
    }
}