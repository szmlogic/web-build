<?php	return array ( 'catid' => array ( 'id' => '20', 'modelid' => '3', 'field' => 'catid', 'name' => '栏目', 'tips' => '', 'required' => '1', 'minlength' => '1', 'maxlength' => '6', 'pattern' => '0', 'errormsg' => '必须选择一个栏目', 'class' => 'w-400', 'type' => 'catid', 'setup' => '', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '1', 'status' => '1', 'issystem' => '1', ), 'title' => array ( 'id' => '21', 'modelid' => '3', 'field' => 'title', 'name' => '产品名称', 'tips' => '', 'required' => '1', 'minlength' => '1', 'maxlength' => '80', 'pattern' => '0', 'errormsg' => '标题必须为1-80个字符', 'class' => 'w-400', 'type' => 'title', 'setup' => '{"thumb":"1","style":"1","size":"55"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '2', 'status' => '1', 'issystem' => '1', ), 'keywords' => array ( 'id' => '22', 'modelid' => '3', 'field' => 'keywords', 'name' => '关键词', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '80', 'pattern' => '0', 'errormsg' => '', 'class' => 'w-400', 'type' => 'text', 'setup' => '{"size":"55","default":"","ispassword":"0","fieldtype":"varchar"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '3', 'status' => '1', 'issystem' => '1', ), 'description' => array ( 'id' => '23', 'modelid' => '3', 'field' => 'description', 'name' => 'SEO简介', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => 'w-500', 'type' => 'textarea', 'setup' => '{"fieldtype":"mediumtext","rows":"4","cols":"55","default":""}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '4', 'status' => '1', 'issystem' => '1', ), 'pics' => array ( 'id' => '25', 'modelid' => '3', 'field' => 'pics', 'name' => '图片', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'images', 'setup' => '{"default":"","upload_maxnum":"10","upload_maxsize":"0.2","upload_allowext":"jpeg,jpg,gif","watermark":"0","more":"1"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '5', 'status' => '1', 'issystem' => '0', ), 'content' => array ( 'id' => '26', 'modelid' => '3', 'field' => 'content', 'name' => '产品说明', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'editor', 'setup' => '{"toolbar":"full","default":"","height":"","show_add_description":"0","show_auto_thumb":"0","showpage":"1","enablekeylink":"0","replacenum":"","enablesaveimage":"0","flashupload":"1","alowuploadexts":"","alowuploadlimit":""}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '6', 'status' => '1', 'issystem' => '1', ), 'createtime' => array ( 'id' => '27', 'modelid' => '3', 'field' => 'createtime', 'name' => '发布时间', 'tips' => '', 'required' => '1', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => 'w-200', 'type' => 'datetime', 'setup' => '', 'isbase' => '0', 'unpostgroup' => '', 'listorder' => '7', 'status' => '1', 'issystem' => '1', ), 'posid' => array ( 'id' => '29', 'modelid' => '3', 'field' => 'posid', 'name' => '推荐位', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'posid', 'setup' => '', 'isbase' => '1', 'unpostgroup' => '3,4', 'listorder' => '8', 'status' => '1', 'issystem' => '1', ), 'template' => array ( 'id' => '30', 'modelid' => '3', 'field' => 'template', 'name' => '模板', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'template', 'setup' => '', 'isbase' => '0', 'unpostgroup' => '3,4', 'listorder' => '9', 'status' => '0', 'issystem' => '1', ), 'status' => array ( 'id' => '31', 'modelid' => '3', 'field' => 'status', 'name' => '状态', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'radio', 'setup' => '{"options":"\\u5df2\\u5ba1\\u6838|1\\n\\u672a\\u5ba1\\u6838|0","fieldtype":"tinyint","numbertype":"1","labelwidth":"75","default":"1"}', 'isbase' => '0', 'unpostgroup' => '3,4', 'listorder' => '10', 'status' => '1', 'issystem' => '1', ), 'hits' => array ( 'id' => '34', 'modelid' => '3', 'field' => 'hits', 'name' => '点击次数', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '8', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'number', 'setup' => '{"size":"10","numbertype":"1","decimaldigits":"0","default":"0"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '11', 'status' => '0', 'issystem' => '0', ), 'relation' => array ( 'id' => '35', 'modelid' => '3', 'field' => 'relation', 'name' => '关联产品', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => '', 'type' => 'relation', 'setup' => '{"modelid":"3","fieldtype":"varchar"}', 'isbase' => '0', 'unpostgroup' => '', 'listorder' => '12', 'status' => '1', 'issystem' => '0', ), 'bianhao' => array ( 'id' => '76', 'modelid' => '3', 'field' => 'bianhao', 'name' => '产品编号', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => 'w-400', 'type' => 'text', 'setup' => '{"size":"55","default":"","ispassword":"0","fieldtype":"varchar"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '13', 'status' => '1', 'issystem' => '0', ), 'texing' => array ( 'id' => '77', 'modelid' => '3', 'field' => 'texing', 'name' => '产品特性', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => 'w-400', 'type' => 'text', 'setup' => '{"size":"55","default":"","ispassword":"0","fieldtype":"varchar"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '14', 'status' => '1', 'issystem' => '0', ), 'gongneng' => array ( 'id' => '78', 'modelid' => '3', 'field' => 'gongneng', 'name' => '产品功能', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => 'w-400', 'type' => 'text', 'setup' => '{"size":"55","default":"","ispassword":"0","fieldtype":"varchar"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '15', 'status' => '1', 'issystem' => '0', ), 'guige' => array ( 'id' => '79', 'modelid' => '3', 'field' => 'guige', 'name' => '产品规格', 'tips' => '', 'required' => '0', 'minlength' => '0', 'maxlength' => '0', 'pattern' => '0', 'errormsg' => '', 'class' => 'w-400', 'type' => 'text', 'setup' => '{"size":"55","default":"","ispassword":"0","fieldtype":"varchar"}', 'isbase' => '1', 'unpostgroup' => '', 'listorder' => '16', 'status' => '1', 'issystem' => '0', ), );?>