
<div class="steps">
	<ol>
		<li><i>1</i><span data-phase-id="r_p_createAccount" class="tsl">阅读许可协议</span></li>
		<li><i>2</i><span data-phase-id="r_p_fillUserInfo" class="tsl">服务器检测</span></li>
		<li><i>3</i><span data-phase-id="r_p_fillUserInfo" class="tsl">填写初始配置</span></li>
		<li><i>4</i><span data-phase-id="r_p_fillUserInfo" class="tsl">详细安装进程</span></li>
		<li class="active"><i class="iconfont">√</i><span data-phase-id="r_p_regSuc" class="tsl">安装完成</span></li>
	</ol>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.setup_process').scrollTop( $('.setup_process')[0].scrollHeight );
});
</script>

<div class="content">

	<!--安装过程-->
	<div class="setup_process">

		<div class="div3" style="margin:10px auto;">
<?php

$status = true;
echo "<p>安装中,请稍后...</p>";


//1. 获取表单信息
$db_host = empty($_POST["localhost"])?"":trim($_POST["localhost"]);
$db_port = empty($_POST["db_port"])?"":trim($_POST["db_port"]);
$db_name = empty($_POST["db_name"])?"":trim($_POST["db_name"]);
$db_user = empty($_POST["db_user"])?"":trim($_POST["db_user"]);
$db_pass = empty($_POST["db_password"])?"":trim($_POST["db_password"]);
$db_pre  = empty($_POST["db_pre"])?"":trim($_POST["db_pre"]);
$is_data = empty($_POST["is_data"])?"0":trim($_POST["is_data"]);

/*$admin     = empty($_POST["admin"])?"":trim($_POST["admin"]);
$password  = empty($_POST["password"])?"":$_POST["password"];
$password2 = empty($_POST["password2"])?"":$_POST["password2"];
$mail      = empty($_POST["mail"])?"":trim($_POST["mail"]);


if($password!=$password2){
	die("<p style='color:red'>管理员密码两次不一致！</p><a href='javascript:window.history.back()'>[返回]</a>");
}else{
 	$password = md5($password);
}*/

//2. （连接数据库）效验一下数据库的账号和密码
$link = @mysql_connect($db_host,$db_user,$db_pass) or die("
<p style='color:red'>数据库连接失败！ </p>
<a href='javascript:window.history.back()'>[返回]</a>
");
echo "<p>数据库连接成功！....</p>";
mysql_set_charset("utf8");

//3. 读取数据库的sql文件(表结构)
$sql_content = file_get_contents("db/data.sql");
echo "<p>读取数据局库配置文件！....</p>";


//4. 解析配置文件。形成建表语句数组
preg_match_all("/CREATE TABLE IF NOT EXISTS `(.*?)`(.*?);/is",$sql_content,$sqllist);

//5. 创建数据库
if(!mysql_query("use {$db_name}",$link)){
	if(mysql_query("create database {$db_name}",$link)){
		echo "<p>数据库{$db_name}创建成功！....</p>";
	} else {
		echo ("<p style='color:red'>数据库{$db_name}创建失败！ </p>");
	}
	mysql_query("use {$db_name}",$link);//选择数据库
} else {
	echo "数据库{$db_name}存在<br>";
}
/*//6. 遍历创建表格
foreach($sqllist[1] as $k=>$table){
	$table=str_replace('qy_', '', $table);
	$sql1 = "DROP TABLE IF EXISTS `{$db_pre}{$table}`";
	$sql2 = "create table `{$db_pre}{$table}`{$sqllist[2][$k]}";
	//echo $sql."<br/><br/>";
	if(mysql_query($sql1,$link)){
		if(mysql_query($sql2,$link)){
			echo "<p>创建表格{$db_pre}{$table}成功！.....</p>";
		} else {
			die("<p style='color:red'>数据表{$db_pre}{$table}创建失败！ </p>
			<a href='javascript:window.history.back()'>[返回]</a>");
			exit;
		}
	}
}*/

/*//7。添加后台管理员账户信息
// $sql = "insert into `{$db_pre}admin` (id,groupid,username,password,email) values(1,1,'{$admin}','{$password}','{$mail}')";
$sql ="update `{$db_pre}user`  set username='{$admin}',password='{$password}',email='{$mail}' where id=1  ";
//echo $sql;
//echo $sql;
if(mysql_query($sql,$link) or die(mysql_error())){
	echo "<p>添加后台管理员账户成功！.....</p>";
}else{
	die("<p style='color:red'>添加后台管理员账户失败！ </p>
	<a href='javascript:window.history.back()'>[返回]</a>");
	exit;
}*/

//8. 生成配置文件dbconfig.inc.php
$confile=__ROOT__/apps/conf.'db.php';

$configText = file_get_contents($confile);
$reg=array(
		"/'DB_HOST'=>'.+?',/i",
		"/'DB_USER'.+?',/i",
		"/'DB_PWD'.+?',/i",
		"/'DB_NAME'.+?',/is",
		"/'DB_PREFIX'.+?',/is",
	  );

$rep=array(
	  "'DB_HOST'=>'{$db_host}',",
	  "'DB_USER'=>'{$db_user}',",
	  "'DB_PWD'=>'{$db_pass}',",
	  "'DB_NAME'=>'{$db_name}',",
	  "'DB_PREFIX'=>'{$db_pre}',",
	);

$dbArr= array(
	DB_TYPE=>'mysql',
	DB_HOST=>$db_host,
	DB_NAME=>$db_name,
	DB_USER=>$db_user,
	DB_PWD=>$db_pass,
	DB_PORT=>'3306',
	DB_PREFIX=>$db_pre,
);
file_put_contents($confile, preg_replace($reg, $rep, $configText));
echo "<p>成功写入配置文件信息。。。</p>";
// //测试数据

	//导入必要的系统数据
	unset($sql_array);
	$sql=file_get_contents('db/data.sql');
    $sql_array = explode(";\n", trim($sql));
	foreach($sql_array as $v){
		$v=trim($v);
		if(strlen($v)==0){continue;}





		if(mysql_query($v,$link)==false);
			"<p style='color:red'>导入系统数据失败:<br/>{$v} </p>";
	}
	echo "<p>导入系统数据。。。</p>";




//9.生成一个安装锁文件install.lock
if($status){
    //$dbArr = unslashes($dbArr);
    $phpcode = '<?php  return '.var_export($dbArr,true).';?>';
    file_put_contents(WEB_ROOT.'apps/Conf/db.php',$phpcode);

	file_put_contents(WEB_ROOT."install/install.lock",date("Y-m-d H:m:s"));

	//10. 关闭数据库
	echo "<p>安装成功。。。</p>";
}


?>
			</div>
		</div>
	</div><!--内容部分-->

		<div class="act">
		<button type="button" class="btn btn-primary toHome">进入首页</button>
		<button type="button" class="btn btn-primary toAdmin">进入管理后台</button>
		</div>

</div>

<script type="text/javascript">

$('.toHome').click(function(){
	window.location.href='<?php echo WEB_URL; ?>';
});
$('.toAdmin').click(function(){
	window.location.href='<?php echo WEB_URL; ?>/admin';
});
</script>
</div>
</body>
</html>