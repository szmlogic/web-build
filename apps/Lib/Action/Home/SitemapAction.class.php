<?php
/**
 *
 * SitemapAction.class.php (网站地图)
 *
 */
class SitemapAction extends PublicAction {

    public function index()
    {
        import('@.ORG.Tree' );

        $cats = M('Category')->where('parentid=0')->field('id,url,catname')->select();

        foreach ($cats as $key=>$val) {
            $data = M('Category')->where('parentid='.$val['id'])->field('id,url,catname')->select();
            if ($data) {
                $cats[$key]['subcat'] = $data;
            }
        }

        $this->assign('sitemap', $cats);
        $this->display();
    }

}