<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/9/10
 * Time: 17:00
 */

namespace app\admin\controller;


use think\Controller;
use app\api\controller\ServerAPI;
use think\Db;

class Testsms extends Controller
{

    public function real() {
        return $this->fetch();
    }

    public function get_aj() {
        $get_ajax = $this->request->post("");
        $phone=$get_ajax["phone"];
        $sys=$get_ajax["sys"];
        $preg_phone='/^1[345789]\d{9}$/ims';

//        验证拦截->错误手机
        if(!preg_match($preg_phone,$phone)){
            return ["status"=>300,"msg"=>"手机号码无效"];
        }

//        验证拦截->错误系统
        if($sys != 'ios' && $sys != 'android'){
            return ["status"=>300,"msg"=>"请选择正确的系统"];
        }

//        验证拦截->手机号已经存在
//        if(Db::table('fa_phone')->where("phone", $phone)->find()){
//            return ["stauts"=>300,"msg"=>"你已经成功预约,无需重复操作"];
//        }

//        调取发送短信函数
        $res = $this->sms($phone,$sys);

        return ["status"=>200,"msg"=>"验证码已经发送"];

    }

    public function show() {
        return $this->fetch();
    }

    public function sms($phone,$sys)
    {
        //网易云信分配的账号，请替换你在管理后台应用下申请的Appkey
        $AppKey = '887aa976ffa2806d3c5f98c699a2685d';
        //网易云信分配的账号，请替换你在管理后台应用下申请的appSecret
        $AppSecret = '770cec64a752';
        $p = new ServerAPI($AppKey, $AppSecret, 'fsockopen');     //fsockopen伪造请求
        $res = $p->sendSmsCode('14874434', $phone, '', '6');

        Db::table('fa_phone')->insert(
            [
                "sendcode"=>$res["obj"],
                "phone"=>$phone,
                "sys"=>$sys,
                "time"=>time(),
            ]
        );
    }

    public function confirm_code() {

        $phone = $_POST["phone"];
        $code = $_POST["cus_code"];

        $info = Db::table('fa_phone')->where('phone',$phone)->find();
        if($code != $info['sendcode']){
            return ["status"=>300,"msg"=>"验证码错误!"];
        }else{
            return ["status"=>200,"msg"=>"预约成功!"];
        }

    }

    public function ori_sms()
    {
        //网易云信分配的账号，请替换你在管理后台应用下申请的Appkey
        $AppKey = '88a6964526b8a5c0cc2bfc188835542b';
        //网易云信分配的账号，请替换你在管理后台应用下申请的appSecret
        $AppSecret = '9afed3f10551';
        $p = new ServerAPI($AppKey, $AppSecret, 'fsockopen');     //fsockopen伪造请求
        $res = $p->sendSmsCode('14894078', '18395832343', '', '5');
        dump($res["obj"]);
    }

}