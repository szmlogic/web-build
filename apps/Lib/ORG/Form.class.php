<?php
/**
 *
 * Form.php (模型表单生成)
 *
 */
class Form extends Think {
    public $data = array();
    public $isadmin = 1;
    public $doThumb = 1;
    public $doAttach = 1;

    public function __construct($data=array())
    {
        $this->data = $data;
    }

    public function catid($info,$value)
    {
        $validate = getvalidate($info);

        $Category = F('Category');

        $id = $field = $info['field'];
        $value = !empty($value) ? $value : $this->data[$field];
        $modelid = $info['modelid'];
        $array = array();
        foreach ($Category as $r) {
            $arr = explode(",",$r['arrchildid']);
            $show = 0;
            foreach ((array)$arr as $rr) {
                if($Category[$rr]['modelid'] ==$modelid) $show=1;
            }
            if(empty($show))continue;
            $r['disabled'] = $r['child'] ? ' disabled' :'';
            $array[] = $r;
        }
        import('@.ORG.Tree');
        $str  = "<option value='\$id' \$disabled \$selected>\$spacer \$catname</option>";
        $tree = new Tree($array);
        $parseStr = '';
        $parseStr .= '<select id="'.$id.'" name="'.$field.'" class="form-control '.$info['class'].'"  '.$validate.'>';
        $parseStr .= '<option value="">请选择</option>';
        $parseStr .= $tree->get_tree(0, $str, $value);
        $parseStr .= '</select>';
        return $parseStr;
    }


    public function title($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);
        $style = $info['setup']['style'];
        $field_name = $info['field'];

        $value = !empty($value) ? $value : $this->data[$field_name];

        $style_color = '';
        $style_bold = '';
        if (!empty($this->data['title_style'])) {
            $title_style = explode(';',$this->data['title_style']);
            $style_color = explode(':',$title_style[0]);
            $style_color = $style_color[1];
            $style_bold = explode(':',$title_style[1]);
            $style_bold = $style_bold[1];
        }

        if (empty($info['setup']['upload_maxsize'])) {
            $Config = F('Config');
            $info['setup']['upload_maxsize'] = intval(byte_format($Config['attach_maxsize']));
        }

        $boldchecked = $style_bold=='bold' ? 'checked' : '';

        $parseStr = '<input type="text" class="form-control '.$info['class'].'" placeholder="'.$info['errormsg'].'" name="'.$field_name.'" value="'.$value.'" />';

        $stylestr = '<span class="input-group-addon">
<div id="'.$field_name.'_colorimg" class="colorimg" style="background-color:'.$style_color.'"></div></span>
<input type="hidden" id="'.$field_name.'_style_color" name="style_color" value="'.$style_color.'" />
<span class="input-group-addon"><input type="checkbox" class="style_bold" name="style_bold" value="bold" '.$boldchecked.' />
加粗</span>
<script>$.showcolor("'.$field_name.'_colorimg","'.$field_name.'_style_color");
</script>';

        if($style){

            $parseStr = '<div class="input-group">'.$parseStr.$stylestr.'</div>';
        }
        return $parseStr;
    }

    public function text($info,$value){
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : string2array($info['setup']);
        $id = $field = $info['field'];
        $validate = getvalidate($info);
        $info['setup']['ispassword'] ? $inputtext = 'password' : $inputtext = 'text';
        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }

        $onkey = "value=value.replace(/[^\w\.\u4E00-\u9FA5\uF900-\uFA2D\/]/ig,',')";
        $onkey_key = "value=value.replace(/[^\w\.\u4E00-\u9FA5\uF900-\uFA2D\/]/ig,',')";
        $seourl = "<a href=javascript:$('#seourl').parent().parent().toggle();>".L('cum_url')."</a>";

        $parseStr   = '<input type="'.$inputtext.'" class="form-control '.$info['class'].'" name="'.$field.'"  id="'.$id.'" value="'.stripcslashes($value).'" size="'.$info['setup']['size'].'"  '.$validate.'/>';
        return $parseStr;
    }



    public function verify($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        $parseStr = '<input class="input-text '.$info['class'].'" name="'.$field.'"  id="'.$id.'" value="" size="'.$info['setup']['size'].'"  '.$validate.' /><img src="'.URL('Home-Index/verify').'" onclick="javascript:resetVerifyCode();" class="checkcode" align="absmiddle"  title="点击刷新验证码" id="verifyImage"/>';
        return $parseStr;
    }

    public function number($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        $info['setup']['ispassowrd'] ? $inputtext = 'passowrd' : $inputtext = 'text';
        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $parseStr   = '<input type="'.$inputtext.'" class="form-control '.$info['class'].'" name="'.$field.'"  id="'.$id.'" value="'.$value.'" size="'.$info['setup']['size'].'"  '.$validate.'/>';
        return $parseStr;
    }

    public function textarea($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if (ACTION_NAME == 'add') {
            $value = $value ? $value : $info['setup']['default'];
        } else {
            $value = $value ? $value : $this->data[$field];
        }

        $parseStr = '<textarea class="form-control '.$info['class'].'" placeholder="'.$info['errormsg'].'" name="'.$field.'"  rows="'.$info['setup']['rows'].'" cols="'.$info['setup']['cols'].'"  id="'.$id.'"   '.$validate.'/>'.stripcslashes($value).'</textarea>';
        return $parseStr;
    }


    public function select($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if (ACTION_NAME=='add') {
            $value = !empty($value) ? $value : $info['setup']['default'];
        } else {
            $value = !empty($value) ? $value : $this->data[$field];
        }
        if ($value != '') {
            $value = strpos($value, ',') ? explode(',', $value) : $value;
        }

        if (is_array($info['options'])) {
            if ($info['options_key']) {
                $options_key = explode(',',$info['options_key']);
                foreach ((array)$info['options'] as $key=>$res) {
                    if ($options_key[0]=='key') {
                        $optionsarr[$key]=$res[$options_key[1]];
                    } else {
                        $optionsarr[$res[$options_key[0]]]=$res[$options_key[1]];
                    }
                }
            } else {
                $optionsarr = $info['options'];
            }
        } else {
            $options = explode("\n",$info['setup']['options']);
            foreach($options as $r) {
                $v = explode("|",$r);
                $k = trim($v[1]);
                $optionsarr[$k] = $v[0];
            }
        }

        if (!empty($info['setup']['multiple'])) {
            $parseStr = '<select id="'.$id.'" name="'.$field.'" onchange="'.$info['setup']['onchange'].'" class="form-control '.$info['class'].'"  '.$validate.' size="'.$info['setup']['size'].'" multiple="multiple">';
        } else {
            $parseStr = '<select id="'.$id.'" name="'.$field.'" onchange="'.$info['setup']['onchange'].'"  class="form-control '.$info['class'].'" '.$validate.'>';
        }

        if (is_array($optionsarr)) {
            foreach ($optionsarr as $key=>$val) {
                if (!empty($value)) {
                    $selected = '';
                    if($value==$key || in_array($key,$value)) {
                        $selected = ' selected';
                    }
                    $parseStr   .= '<option value="'.$key.'" '.$selected.'>'.$val.'</option>';
                } else {
                  $parseStr   .= '<option value="'.$key.'">'.$val.'</option>';
                }
            }
        }
        $parseStr   .= '</select>';
        return $parseStr;
    }

    public function li($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        if($value != '') $value = strpos($value, ',') ? explode(',', $value) : $value;

        if(is_array($info['options'])){
            if($info['options_key']){
                $options_key=explode(',',$info['options_key']);
                foreach((array)$info['options'] as $key=>$res){
                    if($options_key[0]=='key'){
                        $optionsarr[$key]=$res[$options_key[1]];
                    }else{
                        $optionsarr[$res[$options_key[0]]]=$res[$options_key[1]];
                    }
                }
            }else{
                $optionsarr = $info['options'];
            }
        }else{
            $options = explode("\n",$info['setup']['options']);
            foreach($options as $r) {
                $v = explode("|",$r);
                $k = trim($v[1]);
                $optionsarr[$k] = $v[0];
            }
        }


        if(!empty($info['setup']['class'])) {
            $parseStr = '<ul class="'.$info['class'].'">';
        }else {
            $parseStr = '<ul>';
        }

        if(is_array($optionsarr)) {
            foreach($optionsarr as $key=>$val) {
                if(!empty($value)){
                    $selected='';
                    if($value==$key || in_array($key,$value)) $selected = 'class="currt"';
                        $parseStr   .= '<li '.$selected.' tag="'.$key.'">'.$val.'</li>';
                }else{
                    $parseStr   .= '<li tag="'.$key.'">'.$val.'</li>';
                }
            }
        }
        $parseStr   .= '</ul>';
        return $parseStr;
    }

    //复选框
    public function checkbox($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if(ACTION_NAME=='add'){
            $value = !empty($value) ? $value : $info['setup']['default'];
        }else{
            $value = !empty($value) ? $value : $this->data[$field];
        }

        $labelwidth = $info['setup']['labelwidth'];

        if(is_array($info['options'])){
            if (!empty($info['options_key'])) {
                $options_key=explode(',',$info['options_key']);
                foreach((array)$info['options'] as $key=>$res){
                    if($options_key[0]=='key'){
                        $optionsarr[$key]=$res[$options_key[1]];
                    }else{
                        $optionsarr[$res[$options_key[0]]]=$res[$options_key[1]];
                    }
                }
            } else {
                $optionsarr = $info['options'];
            }
        }else{
            $options = $info['setup']['options'];
            $options = explode("\n",$info['setup']['options']);
            foreach($options as $r) {
                $v = explode("|",$r);
                $k = trim($v[1]);
                $optionsarr[$k] = $v[0];
            }
        }

        if($value != '') $value = (strpos($value, ',') && !is_array($value)) ? explode(',', $value) :  $value ;
        $value = is_array($value) ? $value : array($value);
        $i = 1;
        $onclick = !empty($info['setup']['onclick']) ? ' onclick="'.$info['setup']['onclick'].'" ' : '' ;

        $parseStr = '';
        foreach($optionsarr as $key=>$r) {
            $key = trim($key);
            if($i>1) $validate='';
            $checked = ($value && in_array($key, $value)) ? 'checked' : '';

            $parseStr .= '<label class="checkbox-inline checkbox_'.$id.'" >';
            $parseStr .= '<input type="checkbox" class="'.$info['class'].'" name="'.$field.'[]" id="'.$id.'_'.$i.'" '.$checked.$onclick.' value="'.htmlspecialchars($key).'"  '.$validate.'> '.htmlspecialchars($r);
            $parseStr .= '</label>';
            $i++;
        }
        return $parseStr;

    }

    //单选框
    public function radio($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $labelwidth = $info['setup']['labelwidth'];

        if (isset($info['options']) && is_array($info['options'])) {
            if (!empty($info['options_key'])) {
                $options_key = explode(',',$info['options_key']);
                foreach((array)$info['options'] as $key=>$res){
                    if($options_key[0]=='key'){
                        $optionsarr[$key]=$res[$options_key[1]];
                    }else{
                        $optionsarr[$res[$options_key[0]]]=$res[$options_key[1]];
                    }
                }
            } else {
                $optionsarr = $info['options'];
            }
        } else {
          $options = explode("\n",$info['setup']['options']);
          foreach($options as $r) {
            $v = explode("|",$r);
            $k = trim($v[1]);
            $optionsarr[$k] = $v[0];
          }
        }
        $onclick = !empty($info['setup']['onclick']) ? ' onclick="'.$info['setup']['onclick'].'" ' : '' ;
        $i = 1;

        $parseStr = '';
        foreach($optionsarr as $key=>$r) {
            if($i>1) $validate ='';
            $checked = trim($value)==trim($key) ? 'checked' : '';
            if(empty($value) && empty($key) ) $checked = 'checked';
            $parseStr .= '<label class="radio-inline checkbox_'.$id.'" >';
            $parseStr .= '<input type="radio" class="'.$info['class'].'" name="'.$field.'" id="'.$id.'_'.$i.'" '.$checked.$onclick.' value="'.$key.'" '.$validate.'> '.$r;
            $parseStr .= '</label>';
            $i++;
        }
        return $parseStr;
    }

    // 编辑器
    public function editor($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if(ACTION_NAME=='add'){
          $value = $value ? $value : $info['setup']['default'];
        }else{
          $value = $value ? $value : $this->data[$field];
        }

        //$value = stripslashes(htmlspecialchars_decode($value));
        $textareaid = $field;
        $toolbar = $info['setup']['toolbar'];
        $modelid = $info['modelid'];
        $height = !empty($info['setup']['height']) ? $info['setup']['height'] : 300;
        $flashupload = $info['setup']['flashupload']==1 ? 1 : '';
        $alowuploadexts = !empty($info['setup']['alowuploadexts']) ? $info['setup']['alowuploadexts'] :  'jpg,gif,png';
        $alowuploadlimit = !empty($info['setup']['alowuploadlimit']) ? $info['setup']['alowuploadlimit'] : 20 ;
        $show_page = $info['setup']['showpage'];

        $Config = F('Config');


        $str ='';
        $str .= '<div style="display:none;" id="'.$field.'_aid_box"></div>
        <textarea name="'.$field.'" class="form-control '.$info['class'].'"  id="'.$id.'"  boxid="'.$id.'" '.$validate.'  style="width:99%;height:'.$height.'px;visibility:hidden;">'.$value.'</textarea>';

        $info['setup']['edittype'] = 'kindeditor';


        $yzh_auth = get_yzh_auth(10,'1MB',$modelid);
        $upurl= __ROOT__."/index.php?g=Admin&m=Attachment&a=swfupload&auth=$yzh_auth";

        $yzh_auth = get_yzh_auth(1,'1MB',$modelid);

        $upImgUrl =__ROOT__."/index.php?g=Admin&m=Attachment&a=swfupload&auth=$yzh_auth";

        $yzh_auth = get_yzh_auth(1,'1MB',$modelid);
        $upFlashUrl=__ROOT__."/index.php?g=Admin&m=Attachment&a=swfupload&auth=$yzh_auth";

        $yzh_auth = get_yzh_auth(1,'1MB',$modelid);
        $upMediaUrl=__ROOT__."/index.php?g=Admin&m=Attachment&a=swfupload&auth=$yzh_auth";

        $str .="<script type=\"text/javascript\" src=\"".__ROOT__."/public/static/kindeditor/kindeditor-min.js\"></script>
    <script type=\"text/javascript\">
    KindEditor.ready(function(K) {
        K.create('#".$id."', {
        cssPath : '".__ROOT__."/public/static/kindeditor/plugins/code/prettify.css',
        fileManagerJson:'$upurl',
        editorid:'$id',
        upImgUrl:'$upImgUrl',
        upFlashUrl:'$upFlashUrl',
        upMediaUrl:'$upMediaUrl',
        allowFileManager : true,
        filterMode: false,
        hunqinglineTag:'br',
        afterBlur: function(){
            this.sync();
        }
    });
});
</script>
<div  class='editor_bottom2'>";

        if(!empty($info['setup']['show_add_description'])) {
            $str .='<input type="checkbox" name="add_description" value="1" checked />是否截取内容
        <input type="text" name="description_length" value="200" style="width:24px;" size="3" />字符至内容摘要';
        }

        if (!empty($info['setup']['show_auto_thumb'])) {
            $str .='<input type="checkbox" name="auto_thumb" value="1" checked />是否获取内容第
        <input type="text" name="auto_thumb_no" value="1" size="1" />张图片作为标题图片';
        }


        if (!empty($info['setup']['enablesaveimage'])){
            $str .='<input type="hidden" name="enablesaveimage" value="1" /> ';
        }
        if (!empty($info['setup']['enablekeylink'])) {
            $str .='<input type="hidden" name="enablekeylink" value="'.$info['setup']['enablekeylink'].'" /> ';
        }
        if (!empty($info['setup']['replacenum'])) {
            $str .='<input type="hidden" name="replacenum" value="'.$info['setup']['replacenum'].'" /> ';
        }

        $str .= '</div>';

        return $str;
    }

    // 日期选择器
    public function datetime($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);
        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if (ACTION_NAME=='add') {
            $value = !empty($value) ? $value : $info['setup']['default'];
        } else {
            $value = !empty($value) ? $value : $this->data[$field];
        }
        $value = !empty($value) ? toDate($value,"Y-m-d H:i:s") : toDate(time(),"Y-m-d H:i:s");

        $parseStr = '<input class="Wdate form-control '.$info['class'].'"  '.$validate.'  name="'.$field.'" type="text" id="'.$id.'" size="25" onFocus="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:ss\'
        })" value="'.$value.'" />';
        return $parseStr;
    }

    public function groupid($info,$value)
    {
        $newinfo = $info;
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $groups = F('MemberGroup');
        $options = array();
        foreach($groups as $key=>$r) {
            if($r['status']){
                $options[$key] = $r['name'];
            }
        }
        $newinfo['options']=$options;
        $fun = $info['setup']['inputtype'];
        return $this->$fun($newinfo,$value);
    }

    //关联信息
    public function relation($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);
        $value = $value?$value:$this->data[$info['field']];
        $value = json_decode($value, true);
        $modelid = !empty($info['setup']['modelid'])?$info['setup']['modelid']:$info['modelid'];
        $map['id']  = array('in',$value);
        $Model = F("Model");
        $modelname = $Model[$modelid]['tablename'];
        $list = M($modelname)->field('id,title')->where($map)->select();
        foreach($list as $pro){
            $str .= '<li id="'.$info['field'].'_'.$pro['id'].'">·<span>'.$pro['title'].'</span><a href="javascript:;" class="close" onclick="remove_relation(\''.$info['field'].'\','.$pro['id'].')"></a>
            <input type="hidden" name="'.$info['field'].'[]" value="'.$pro['id'].'"/>
            </li>';
        }
        $parseStr='<input type="hidden" name="'.$info['field'].'" id="relation" value="" style="50">
                        <ul class="list-dot" id="relation_text">
                        '.$str.'
                        </ul>
                        <input type="button" value="添加相关" onclick="openwin(\'/?a=public_relationlist&m=Content&g=admin&modelid='.$modelid.'&field='.$info['field'].'\',\'添加相关信息\',\'800px\',\'550px\')" class="btn">
                        <span class="edit_content">
                    </span>';

        return $parseStr;
    }

    // 推荐位
    public function posid($info,$value)
    {
        $newinfo = $info;
        $field = $info['field'];
        $value = $value ? $value : $this->data[$field];
        $posids = F('Posid');
        $options = array();

        foreach ($posids as $key=>$r) {
            $options[$key]=$r['name'];
        }
        $newinfo['options'] = $options;

        $value = explode('-',$value);

        return $this->checkbox($newinfo,$value);
    }

    // 分类
    public function typeid($info,$value)
    {
        $newinfo = $info;
        $types = F('Type');

        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $value = $value ? $value : $this->data[$field];
        $parentid = $info['setup']['default'];
        $keyid = $types[$parentid]['keyid'];

        $options=array();
        foreach((array)$types as $key => $r) {
            if($r['keyid']!=$keyid || $r['typeid'] == $keyid)
                continue;
            $r['id'] = $r['typeid'];
            $array[] = $r;
            $options[$key]=$r['name'];
        }

        import ( '@.ORG.Tree' );
        $str  = "<option value='\$typeid' \$selected>\$spacer \$name</option>";
        $tree = new Tree ($array);
        $tree->nbsp='&nbsp;&nbsp;';
        $select_type = $tree->get_tree(0, $str,$value);

        $fun=$info['setup']['inputtype'];
        if($fun=='select'){
            return '<select id="'.$id.'" class="form-control '.$info['class'].'"  name="'.$field.'">
            <option value="0">请选择</option>'. $select_type.'</select>';
        }else{
            $newinfo['options'] = $options;
            return $this->$fun($newinfo,$value);
        }
    }

    public function template($info,$value)
    {
        $templates = template_file(MODULE_NAME);
        $newinfo = $info;
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $options = array();
        $options[0] = '请选择';
        foreach ($templates as $key=>$r) {
            if(strstr($r['value'],'show')){
                $options[$r['value']]=$r['filename'];
            }
        }
        $newinfo['options']= $options;
        $fun = $info['setup']['inputtype'];
        return $this->select($newinfo,$value);
    }


    // 单张图片
    public function image($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        if(empty($info['setup']['upload_maxsize'])){

            $Config = F('Config');
            $info['setup']['upload_maxsize'] =  intval(byte_format($Config['attach_maxsize']));
        }

        $yzh_auth_key = sysmd5(C('ADMIN_ACCESS').$_SERVER['HTTP_USER_AGENT']);
        $yzh_auth = authcode($this->isadmin.'-'.$info['setup']['more'].'-0-1-'.$info['setup']['upload_allowext'].'-'.$info['setup']['upload_maxsize'].'-'.$info['moduleid'], 'ENCODE',$yzh_auth_key);

        $parseStr  = '<div id="'.$field.'_aid_box"></div>';
        $parseStr .= '<input type="text" class="form-control pull-left '.$info['class'].'" name="'.$field.'" id="'.$id.'" value="'.$value.'" size="'.$info['setup']['size'].'"  '.$validate.'/>';
        $parseStr .= '<input type="button" class="btn btn-primary btn-sm pull-left" value="图片上传" onclick="javascript:swfupload(\''.$field.'_uploadfile\',\''.$field.'\',\''.L('uploadfiles').'\','.$this->isadmin.','.$info['setup']['more'].',0,1,\''.$info['setup']['upload_allowext'].'\','.$info['setup']['upload_maxsize'].','.$info['moduleid'].',\''.$yzh_auth.'\',up_image,nodo)">
        ';

        return $parseStr;
    }

    //多图上传
    public function images($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $id = $field = $info['field'];
        $validate = getvalidate($info);
        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $data = '';
        $i = 0;
        if ($value) {
            $options = explode(":::",$value);
            if(is_array($options)){
                foreach($options as  $r) {
                    $v = explode("|",$r);
                    $k = trim($v[1]);
                    $data .= '<div id="uplistd_'.$i.'">';
                    $data .= '    <img src="'.$v[0].'"/>';
                    $data .= '    <input type="hidden" name="'.$field.'[]" value="'.$v[0].'" />';
                    $data .= '    <div class="image_title">';
                    $data .= '    <input type="text" class="form-control" placeholder="注释" name="'.$field.'_name[]" value="'.$v[1].'" /></div>';
                    $data .= '    <button type="button" onclick="remove_this(\'uplistd_'.$i.'\');" class="close"><span aria-hidden="true">&times;</span></button>';
                    $data .= '</div>';
                    $i++;
                }
            }
        }
        if(empty($info['setup']['upload_maxsize'])){
            $Config = F('Config');
            $info['setup']['upload_maxsize'] =  intval(byte_format($Config['attach_maxsize']));
        }

        $parseStr['yzh_auth'] = get_yzh_auth(10,'1MB',$info['modelid']);

        return $parseStr;
    }

    public function file($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $field = $info['field'];
        $validate = getvalidate($info);
        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
          $value = $value ? $value : $this->data[$field];
        }
        if(empty($info['setup']['upload_maxsize'])){
            $Config = F('sys.config');
            $info['setup']['upload_maxsize'] =  intval(byte_format($Config['attach_maxsize'])).'M';
        }

        $yzh_auth = get_yzh_auth(1,$info['setup']['upload_maxsize'],$info['modelid'],$info['setup']['upload_allowext']);

        $parseStr = '<div class="input-group">';
        $parseStr .= '<div id="'.$field.'_aid_box"></div>';
        $parseStr .= '<input type="text" class="form-control '.$info['class'].'" name="'.$field.'"  id="'.$field.'" value="'.$value.'" />';
        $parseStr .= '<span class="input-group-addon" onclick="javascript:swfupload(\''.$field.'\',\''.$yzh_auth.'\',yesdo)">文件上传</span>';
        $parseStr .= '</div>';

        return $parseStr;
    }

    //多图上传
    public function files($info,$value)
    {
        $info['setup'] = is_array($info['setup']) ? $info['setup'] : json_decode($info['setup'], true);

        $field = $info['field'];

        if(ACTION_NAME=='add'){
            $value = $value ? $value : $info['setup']['default'];
        }else{
            $value = $value ? $value : $this->data[$field];
        }
        $data = '';
        $i = 0;
        if ($value) {
            $options = json_decode($value,true);

            if(is_array($options)){
                foreach($options as  $r) {

                    $fileext = get_extension($r['filepath']);
                    $file_img = $r['filepath'];
                    if (in_array($fileext, array('pdf', 'zip', 'rar', 'doc', 'ppt', 'xls', 'flv', 'html', 'ini', 'js', 'css', 'txt', 'xml'))) {
                        $file_img = '/public/images/ext/'.$fileext.'.png';
                    } elseif (!in_array($fileext, array('jpg', 'jpeg', 'png', 'gif'))) {
                        $file_img = 'public/images/ext/file.png';
                    }
                    $data .= '<div id="uplistd_'.$i.'">';
                    $data .= '    <img src="'.$file_img.'"/>';
                    $data .= '    <input type="hidden" name="'.$field.'[]" value="'.$r['filepath'].'" />';
                    $data .= '    <div class="image_title">';
                    $data .= '    <input type="text" class="form-control" placeholder="注释" name="'.$field.'_name[]" value="'.$r['filename'].'" /></div>';
                    $data .= '    <button type="button" onclick="remove_this(\'uplistd_'.$i.'\');" class="close"><span aria-hidden="true">&times;</span></button>';
                    $data .= '</div>';
                    $i++;
                }
            }
        }
        if(empty($info['setup']['upload_maxsize'])){
            $Config = F('sys.config');
            $info['setup']['upload_maxsize'] =  intval(byte_format($Config['attach_maxsize']));
        }

        $yzh_auth = get_yzh_auth($info['setup']['upload_maxnum'],$info['setup']['upload_maxsize'].'MB',$info['modelid'],$info['setup']['upload_allowext']);

        $parseStr = '<div class="panel panel-default">';
        $parseStr .= '  <div class="panel-heading">最多同时可以上传<font color="red">'.$info['setup']['upload_maxnum'].'</font>个';
        $parseStr .= '  <div class="pull-right">
                            <input type="button" class="btn btn-xs btn-primary" value="文件上传" onclick="javascript:swfupload(\''.$field.'\',\''.$yzh_auth.'\',upload_files)"></div>';
        $parseStr .= '  </div>';
        $parseStr .= '  <div id="'.$field.'_images" class="imagesList panel-body">';
        $parseStr .= '      <input type="hidden" name="'.$field.'[]" value=""/>';
        $parseStr .= '      <input type="hidden" name="'.$field.'_name[]" value="" />';
        $parseStr .= $data;
        $parseStr .= '  </div>';
        $parseStr .= '</div>';
        $parseStr .= '
<script>
Sortable.create('.$field.'_images, {
  handle: "img",
  animation: 150
});
</script>
';

        return $parseStr;
    }
}