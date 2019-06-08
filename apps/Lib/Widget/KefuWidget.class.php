<?php

/**
 * Class KefuWidget
 * 客服窗口
 * @author Mr.Weng
 */
class KefuWidget extends Action
{
    public function render($data) {

        $map = array();

        $map['status'] = 1;

        $data = M("Kefu")->where($map)->order('listorder asc,id asc')->select();

        $config = F('Config');

        $html = '';
        if (!empty($data)){
            foreach($data as $key =>$r){

                if($r['type']==1){
                    //qq
                    $codes = explode("\n",$r['code']);

                    foreach((array)$codes as $code){
                        if($code){
                            $codearr = explode("|",$code);
                            $code = $codearr[0];
                            $html .= '<li class="qq"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$code.'&site=qq&menu=yes">'.$r['name'].'</a></li>';
                        }
                    }
                }elseif($r['type']==2){
                    //淘宝旺旺
                    $skin = str_replace('w','',$r['skin']);
                    $codes = explode("\n",$r['code']);

                    foreach((array)$codes as $code){
                        if($code){
                            $codearr=explode("|",$code);
                            $code= $codearr[0];
                            $html.='<li class="wang"><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid='.$code.'&siteid=cntaobao&status='.$skin.'&charset=utf-8" rel="nofollow">'.$r['name'].'</a></li>';
                        }
                    }
                }elseif($r['type']==3){
                    //skype
                    $codes=explode("\n",$r['code']);

                    foreach((array)$codes as $code){

                        if($code){
                            $codearr = explode("|",$code);
                            $code = $codearr[0];
                            $html.='<li class="spk"><a target="_blank" href="skype:'.$code.'?chat" rel="nofollow">'.$r['name'].'</a></li>';
                        }
                    }
                }elseif($r['type']==4){
                    //tel
                    $codes = explode("\n",$r['code']);

                    foreach((array)$codes as $code){
                        if($code){
                            $codearr=explode("|",$code);
                            $code= $codearr[0];
                            $html.='<li class="tel"><a target="_blank" title="'.$code.'" rel="nofollow">'.$r['name'].'</a></li>';
                        }
                    }
                }
            }
        }

        $data['html'] = $html;
        $data['site_wzqrcode'] = $config['site_wzqrcode'];

        $this->assign($data);
        $this->display('Widget:kefu');

    }

}