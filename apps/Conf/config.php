<?php
$database = require(CONF_PATH . '/db.php');
$sys_config =  include DATA_PATH . 'sys.config.php';

if (empty($sys_config)) {
    $sys_config=array();
    $sys_config['LAYOUT_ON']=1;
}
if ($sys_config['URL_MODEL']) {
    $RULES = include DATA_PATH . 'Routes.php';
}

$config = array(

    'DEFAULT_CHARSET'       =>  'utf-8',
    // 'APP_GROUP_MODE'        =>  1,
    'APP_GROUP_LIST'        =>  'Home,Admin,Wap,User,api,Attachment',
    'DEFAULT_GROUP'         =>  'Home',
    'DB_FIELDS_CACHE'       =>  false,
    'DB_FIELDTYPE_CHECK'    =>  true,
    'DEFAULT_MODULE'        =>  'Index',
    'ADMIN_ACCESS'          =>  'c653a6e39a9fcdf234bb0cb01655040d',

    'DEFAULT_LANG'   => 'zh-cn',
    'LANG_SWITCH_ON'		=> true,
    'LANG_LIST'=>'zh-cn,en',

    /* 数据缓存设置 */
    'DATA_CACHE_TIME'       =>  0,      // 数据缓存有效期 0表示永久缓存
    'DATA_CACHE_COMPRESS'   =>  false,   // 数据缓存是否压缩缓存
    'DATA_CACHE_CHECK'      =>  false,   // 数据缓存是否校验缓存
    'DATA_CACHE_PREFIX'     =>  '',     // 缓存前缀
    'DATA_CACHE_TYPE'       =>  'File',  // 数据缓存类型,支持:File|Db|Apc|Memcache|Shmop|Sqlite|Xcache|Apachenote|Eaccelerator
    'DATA_CACHE_PATH'       =>  TEMP_PATH,// 缓存路径设置 (仅对File方式缓存有效)
    'DATA_CACHE_SUBDIR'     =>  false,    // 使用子目录缓存 (自动根据缓存标识的哈希创建子目录)
    'DATA_PATH_LEVEL'       =>  1,        // 子目录缓存级别
    
    /* 日志设置 */
    'LOG_RECORD'            =>  false,   // 默认不记录日志
    'LOG_TYPE'              =>  'File', // 日志记录类型 默认为文件方式
    'LOG_LEVEL'             =>  'EMERG,ALERT,CRIT,ERR',// 允许记录的日志级别
    'LOG_EXCEPTION_RECORD'  =>  false,    // 是否记录异常信息日志

    /* Cookie设置 */
    'COOKIE_EXPIRE'         =>  '',    // Cookie有效期
    //'COOKIE_DOMAIN'         =>  '',      // Cookie有效域名
    //'COOKIE_PATH'           =>  '/',     // Cookie路径
    'COOKIE_PREFIX'         =>  'yzh_',


    /* 系统变量名称设置 */
    'VAR_PAGE'              =>  'p',

    // Think模板引擎标签库相关设定
    'TAGLIB_PRE_LOAD'       =>  'Gr',
    'TAGLIB_LOAD'           =>  true,

    /* URL设置 */
    'URL_CASE_INSENSITIVE'  =>  true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_ROUTER_ON'         =>  true,   // 是否开启URL路由
    'URL_ROUTE_RULES'       =>  $RULES, // 默认路由规则 针对模块
    'URL_MAP_RULES'         =>  array(), // URL映射定义规则


    /* 模板引擎设置 */
    'TMPL_STRIP_SPACE'      =>  false,
    'TMPL_FILE_DEPR'        =>  '_',

    // 布局设置
    'LAYOUT_HOME_ON'        =>  $sys_config['LAYOUT_ON'],

    //分组域名功能
    'APP_SUB_DOMAIN_DEPLOY' => $sys_config['SUB_DOMAIN'], // 是否开启子域名部署
    'APP_SUB_DOMAIN_RULES'    => array(
        'm'    => array('Wap/'),  // m域名指向Wap分组
    ),
    
);
return array_merge($database, $config ,$sys_config);
?>
