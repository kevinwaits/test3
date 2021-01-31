<?php

namespace app\admin\controller;
use think\Controller;
use think\Loader;
use think\Db;
use think\Session;
use think\captcha\Captcha;
class Login extends Controller
{

    public function login() {
        return $this->fetch();
    }

//    @登录_6接html部分 首先是接收数据,很简单,注意这里@data接收来的数据包括了验证码
    public function login_handle()
    {
        $data = $this->request->post("");
//        @登录_7  读入validate  注意 adminvalidate是事先定义好的
        $validate = Loader::validate('AdminValidate');
//        @登录_8  用validate去check$data,如果validate不通过就直接return
        if (!$validate->check($data)) {
            return validateMsg("no", $validate->getError());
        }
//        @登录_9   validateMsg是事先定义好的,为的是返回的是是一个数组,
//        @登录_10   验证,验证码
        if (!captcha_check($data["code"])) {
            return validateMsg("no","验证码错误");
        }
//        @登录_11  这里特别注意,把post来的 验证码键值对删掉
        unset($data["code"]);
//        @登录_12  处理帐号密码信息
        $loginCheck = Db::table('user')->where($data)->find();
        if($loginCheck){
            Session::set("name",$data["name"]);
            return validateMsg('yes',"登录成功");
        }else{
            return validateMsg("no","账户名或密码错误");
        }
    }
}
