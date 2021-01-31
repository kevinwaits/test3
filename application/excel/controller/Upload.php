<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-29
 * Time: 上午 1:50
 */

namespace app\excel\controller;

use \PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use think\Controller;

class Upload extends Controller
{

    public function upload_rec()
    {
        $file = request()->file('file');  //注意这里的 file是 form里 input的name
        if(empty($file)) {
            $this->error('请选择上传文件');
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                echo $info->getExtension();
                //<<获取后缀
                echo $info->getSaveName();
                //<<获取文件名字,和下面一个一样的,我不知道区别
                echo $info->getFilename();
                //<<获取文件名字,和下面一个一样的,我不知道区别
            }else{
                // >>上传失败获取错误信息
                echo $file->getError();
            }

        }
    }






}