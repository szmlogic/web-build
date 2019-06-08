<?php


class PluginAction extends PublicAction {

    function _initialize()
    {
        parent::_initialize();
        $this->path = './Plugin/';
        $this->db = M('Plugin');
    }

    public function index()
    {
        $this->display();
    }

    public function engines()
    {
        $this->display();
    }

    //百度地图
    public function baidumap()
    {
        if (IS_POST) {
            $baidumap['bdmap_x'] = $_POST['bdmap_x'];
            $baidumap['bdmap_y'] = $_POST['bdmap_y'];
            $baidumap['bdmap_name'] = $_POST['bdmap_name'];
            $baidumap['bdmap_address'] = $_POST['bdmap_address'];
            $baidumap['bdmap_tel'] = $_POST['bdmap_tel'];
            $data['config'] = json_encode($baidumap);

            $r = M('Plugin')->where("name='Baidumap'")->save($data);

            if ($r) {
                $this->success('提交成功！');
            } else {
                $this->error('提交失败！');
            }
        } else {
            $result = M('Plugin')->where("name='Baidumap'")->find();
            $data = json_decode($result['config'], true);
            $this->assign('data', $data);
            $this->display();
        }
    }

    //主营产品
    public function mainpro()
    {
        if (IS_POST) {
            $data = array();
            foreach($_POST['product_name'] as $key=>$value){
                $data[$key]['product_name'] = $value;
                $data[$key]['product_url'] = $_POST['product_url'][$key];
            }

            $mainpro = json_encode($data);

            $r = M('Plugin')->where("name='Mainpro'")->save(array('config'=>$mainpro));

            if($r){
                $this->success('保存成功!');
            }else{
                $this->error('没有发生更改!');
            }
            exit;
        }

        $result = M('Plugin')->where("name='Mainpro'")->find();
        $mainpro = json_decode($result['config'], true);
        $this->assign('mainpro', $mainpro);
        $this->display();
    }

    //热门关键词
    public function hotwords()
    {
        if (IS_POST) {
            $data = array();
            foreach($_POST['name'] as $key=>$value){
                $data[$key]['name'] = $value;
                $data[$key]['url'] = $_POST['url'][$key];
            }

            $hotwords = json_encode($data);

            $r = M('Plugin')->where("name='Hotwords'")->save(array('config'=>$hotwords));

            if($r){
                $this->success('保存成功!');
            }else{
                $this->error('没有发生更改!');
            }
            exit;
        }

        $result = M('Plugin')->where("name='Hotwords'")->find();
        $hotwords = json_decode($result['config'], true);
        $this->assign('hotwords', $hotwords);
        $this->display();
    }
}