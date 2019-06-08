<div class="steps">
  <ol>
    <li><i>1</i><span data-phase-id="r_p_createAccount" class="tsl">阅读许可协议</span></li>
    <li><i>2</i><span data-phase-id="r_p_fillUserInfo" class="tsl">服务器检测</span></li>
    <li class="active"><i>3</i><span data-phase-id="r_p_fillUserInfo" class="tsl">填写初始配置</span></li>
    <li><i>4</i><span data-phase-id="r_p_fillUserInfo" class="tsl">详细安装进程</span></li>
    <li><i class="iconfont">√</i><span data-phase-id="r_p_regSuc" class="tsl">安装完成</span></li>
  </ol>
</div>

<div class="content">
  <form name="form1" action="index.php?a=install"  method="post" class="form-horizontal" >

  <fieldset>
    <legend>数据库设置</legend>
    <div class="form-group">
      <label class="col-md-2 control-label">数据库主机：</label>
      <div class="col-md-4">
        <input class="form-control" name="localhost" value="localhost"/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">数据库端口：</label>
      <div class="col-md-4">
        <input class="form-control" name="db_port" value="3306"/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">用户名：</label>
      <div class="col-md-4">
        <input class="form-control" name="db_user" value=""/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">密码：</label>
      <div class="col-md-4">
        <input class="form-control" name="db_password" value=""/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">数据库名：</label>
      <div class="col-md-4">
        <input class="form-control" name="db_name" value=""/>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-2 control-label">表前缀：</label>
      <div class="col-md-4">
      <input class="form-control" name="db_pre" value="qy_"/>
      <label></label>
      </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">演示数据：</label>
        <div class="col-md-4">
          <input name="is_data" value="1" type="checkbox" checked="checked"/>
          <label></label>
        </div>
    </div>
  </fieldset>

  <!--<fieldset>
    <legend>管理员账号</legend>
      <div class="form-group">
        <label class="col-md-2 control-label">用户名：</label>
        <div class="col-md-4">
          <input class="form-control" type="text" name="admin" value="admin"/>
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label">密码：</label>
        <div class="col-md-4">
          <input class="form-control" type="password" name="password" value="admin"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">确认密码：</label>
        <div class="col-md-4">
          <input class="form-control" type="password" name="password2" value="admin"/>
        </div>
      </div>
      <div class="form-group">
        <label class="col-md-2 control-label">管理邮箱：</label>
        <div class="col-md-4">
        <input class="form-control" name="mail" value=""/>
        </div>
      </div>

    </fieldset>-->
    <div class="act">
      <button type="button" class="btn btn-primary prevStep">上一步：检测安装环境</button>
      <button type="submit" class="btn submitBtn btn-primary">开始安装</button>
    </div>
  </form>
  </div>
</div>
<script type="text/javascript">

$('.prevStep').click(function(){
  window.location.href='index.php?a=check';
});

</script>
</body>
</html>