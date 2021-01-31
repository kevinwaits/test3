<?php
namespace app\resign\controller;

use think\Controller;
use think\Loader;
class Sms extends Controller
{

    public function sms() {
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