<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/8/25
 * Time: 9:55
 */

namespace app\admin\controller;


use think\Controller;

class Build extends Controller
{
    public function xxx() {
        echo 111111;
    }

    protected function buildHtml($htmlfile='',$htmlpath='',$templateFile='',$city) {
        $content = $this->fetch($templateFile);
        $htmlpath   = !empty($htmlpath)?$htmlpath:HTML_PATH;
        $htmlfile =  $htmlpath.$htmlfile."newfile/".$city.".html";
        dump($htmlfile);
        if(!is_dir(dirname($htmlfile)))
            // 如果静态目录不存在 则创建
            mkdir(dirname($htmlfile));
        if(false === file_put_contents($htmlfile,$content))
            throw_exception(L('_CACHE_WRITE_ERROR_').':'.$htmlfile);
        return $content;
    }

    public function run_build() {
        $this->buildHtml('', './', 'admin:test_build',"ningbo");
        $this->display();
    }
}