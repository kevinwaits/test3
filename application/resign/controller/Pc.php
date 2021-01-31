<?php
namespace app\resign\controller;
//注册需要注意的问题
/*
1,自己模块要有自己的validate,
2,layer是可以共用的,放在statice下面即可
3,captcha配置好即可
4,没啥了
 * */
use think\Controller;
use think\Loader;
class Pc extends Controller
{

    public function home() {
            return $this->fetch();
    }

    public function pc() {
            return $this->fetch();
    }

    public function pc_rec() {
        $data = $this->request->post("");
        $validate = Loader::validate('Resign');
        //验证vali
        if (!$validate->check($data)) {
            return ["msg"=>$validate->getError(),"code"=>"no"];
//            return validateMsg("no", $validate->getError());
        }
//        验证captcha
        if (!captcha_check($data["captcha"])) {
            return ["msg"=>"验证码错误","code"=>"no"];
        }

        unset($data["captcha"]);// 把接收到的captcha删掉

        return ["msg"=>"注册成功","code"=>"yes"];
    }
}