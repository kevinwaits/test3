<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-04
 * Time: 下午 9:18
 */

namespace app\mess\controller;


use think\Controller;

class Sms extends Controller
{
    public function sendSms()
    {
        header("Content-Type:text/html;charset=utf-8");
        $apikey = "9e94b084e8e568c77747e24ecd9c31ab"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
        $mobile = "18395832343"; //请用自己的手机号代替
        $text = "【宁波捷文】您的验证码是4040";
        $ch = curl_init();
        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// 取得用户信息
        $json_data = get_user($ch, $apikey);
        $array = json_decode($json_data, true);
        echo '<pre>';
        print_r($array);
// 发送短信
        $data = array('text' => $text, 'apikey' => $apikey, 'mobile' => $mobile);
        $json_data = send($ch, $data);
        $array = json_decode($json_data, true);
        echo '<pre>';
        print_r($array);
        curl_close($ch);
    }
}

