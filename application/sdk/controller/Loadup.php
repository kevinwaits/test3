<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-13
 * Time: 上午 11:05
 */

namespace app\sdk\controller;
use think\Controller;
use think\Db;
class Loadup extends Controller
{
    public function loadup() {
        return $this->fetch();
    }

    public function testdb() {
            $data = Db::table('mess')->insert(["name"=>11]);
            dump($data);
    }

    public function loadup_do()
    {
//        $file = request()->file('file');  //注意这里的 file是 form里 input的name
//        $file = request();  //注意这里的 file是 form里 input的name
        $file = $this->request->post("");
        $data = Db::table('mess')->insert(["voice"=>$file]);
//        if (empty($file)) {
//            $this->error('请选择上传文件');
//        }
        // 移动到框架应用根目录/public/uploads/ 目录下
//        if ($file) {
            //注意 uniqid的用法,如果没有这个uniqid,会一个文件,生成一个文件夹
            //注意后面的路径的写法
//            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads/img');
//            if ($info) {
//                //下面是获取文件名字的方法,前面加了一个路径,实务中可以去掉
//                $inputFileName = './uploads/img/' . $info->getFilename();
//                echo $inputFileName;
//            } else {
//                echo $file->getError();
//            }
//        }
    }


    public function get_loadup() {
//        $url = $this->request->post("url");
        $my_url="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".
//        $str = date('YmdHis').time().'.amr';//微信录音文件名 扩展名为 .amr
        $data = Db::table('mess')->insert(["name"=>999]);
//        $targetName =  './'.'amr';   //保存目录
//        downAndSaveFile($url,$targetName); //保存
//        echo 1;
        //根据URL地址，下载文件
    }
}