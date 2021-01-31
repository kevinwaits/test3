<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-17
 * Time: 上午 2:02
 */

namespace app\admin\controller;
use think\Controller;
use think\Loader;
use think\Db;
use think\Session;
use app\api\controller\Sendsms;
class Resign extends Controller
{
    public function resign() {
            return $this->fetch();
    }

    public function check_one()
    {
        $data = $this->request->post("");
//        @登录_7  读入validate  注意 adminvalidate是事先定义好的
        $findphone = Db::table('user')->where("phone", $data["phone"])->find();
        if($findphone){
            return validateMsg("no","该手机号已经注册");
        }
        $validate = Loader::validate('Resign');
//        @登录_8  用validate去check$data,如果validate不通过就直接return
        if (!$validate->check($data)) {
            return validateMsg("no", $validate->getError());
        }
//        @登录_9   validateMsg是事先定义好的,为的是返回的是是一个数组,
//        @登录_10   验证,验证码
        if (!captcha_check($data["captcha"])) {
            return validateMsg("no","验证码错误");
        }
        $rand_code=mt_rand(1000, 9999);
        Session::set("rand_code",$rand_code);
//        return validateMsg("no",$rand_code);
        $sendsms= new Sendsms();
        $sendsms->sendsms($data["phone"],$rand_code);
//        $this->redirect("api/Sms/sendsms",["phone"=>$data["phone"],"rand_code"=>$rand_code]);
//        @登录_11  这里特别注意,把post来的 验证码键值对删掉
        unset($data["captcha"]);
        return validateMsg("no","短信已经发送");
//        @登录_12  处理帐号密码信息
//        $loginCheck = Db::table('user')->where($data)->find();
//        if($loginCheck){
//            Session::set("name",$data["name"]);
//            return validateMsg('yes',"登录成功");
//        }else{
//            return validateMsg("no","账户名或密码错误");
//        }
    }

    public function check_two() {

        $data = $this->request->param("");
        if ($data["code"] == Session::get("rand_code")){
            return validateMsg("no","手机验证码通过");
        };

    }

}