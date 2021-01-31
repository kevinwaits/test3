<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-17
 * Time: 下午 2:18
 */

namespace app\admin\controller;
use think\Controller;
use think\Loader;
use app\api\controller\Sendsingle;
class Sms extends Controller
{
        public function sendsingle() {
                return $this->fetch();
        }

        public function sendsms() {
            $data = $this->request->post("");

//        @登录_8  >>>>用validate去check$data,如果validate不通过就直接return
            $validate = Loader::validate('Sendsingle');
            if (!$validate->check($data)) {
                return validateMsg("no", $validate->getError());
            }
//        @登录_8  <<<<用validate去check$data,如果validate不通过就直接return

            // @登录_10  >>>  captcha验证,验证码
//            if (!captcha_check($data["captcha"])) {
//                return validateMsg("no","验证码错误");
//            }
            // @登录_10  >>>  captcha验证,验证码
        dump($data);
//            >>>开始处理短信业务
            $rand_code=mt_rand(1000, 9999);
//        return validateMsg("no",$rand_code);
            $sendsms= new Sendsingle();
            $sendsms->sendsingle($data["phone"],$rand_code);
//            <<<<开始处理短信业务
        }

        public function submit_resign() {
                $data = $this->request->post("");

        }
}