<?php

$config = array(

    /* 模板相关配置 */
    'TMPL_CACHE_ON'       => true,
    'TMPL_CACHE_TIME'     => 3600,
    'TMPL_PARSE_STRING'   => array(
      '__PUBLIC__' => '/public',
      '__STATIC__' => '/public/static',
      '__IMG__'    => '/themes/Home/Public/images',
      '__JS__'     => '/themes/Home/Public/js',
      '__CSS__'    => '/themes/Home/Public/css',
    ),

    'APP_SUB_DOMAIN_DEPLOY'    => false,

    'TMPL_ACTION_ERROR'     =>  TMPL_PATH.'Home/Public/error.html',
    'TMPL_ACTION_SUCCESS'   =>  TMPL_PATH.'Home/Public/success.html',
    'TMPL_EXCEPTION_FILE'   =>  TMPL_PATH.'Home/Public/exception.html',
);
return $config;
?>
