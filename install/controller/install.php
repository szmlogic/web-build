<?php
error_reporting(0);
//全局公共文件
//require WEB_ROOT.'/install/controller/config.php';

function copydir($dirsrc,$dirto){
    if(is_file($dirto)){
        echo '目标不是目录不能创建';
        return;
    }

    if(!file_exists($dirto)){
        mkdir($dirto);
        echo '创建目录'.$dirto.'成功<br/>';
    }

    $dir=opendir($dirsrc);

    while($filename=readdir($dir)){
        if($filename!='.'&&$filename!='..'){
            $file1=$dirsrc.'/'.$filename;
            $file2=$dirto.'/'.$filename;

            if(is_dir($file1)){
                copydir($file1,$file2);
            }else{
                echo '复制文件的'.$file1.'成功<br/>';
                copy($file1,$file2);
            }
        }
    }

    closedir($dir);
}
//去掉注释
function get_sql($file){
    $sql = file_get_contents($file);
    $arr = array("/#.*/","/--\s+.*/","/\/\*.*?\*\//s");
    $sql = preg_replace($arr,'',$sql);
    return $sql;
}

//
function import_data($file,$db_pre,$link){
  $sql_array = file($file);

  foreach($sql_array as $k=>$v){

    $v=trim($v);
    if(strlen($v)==0){
        continue;
    }



    if(mysql_query($v,$link)==false){
      return $v;
    }

  }
  return TRUE;
}

view('install');