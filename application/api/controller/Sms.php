<?php

namespace app\api\controller;

use think\Controller;

class Sms extends Controller
{
    public function sendsms()
    {
//        需要两个参数,一个是phone,一个是code,
//        phone由前台获取到, code由后台自己生成
//        实务中code也是由后台生成,一起param来
//        $code=mt_rand(1000, 9999);
        $phone = $this->request->param("phone");
        $code = $this->request->param("rand_code");
//        这里开始调用下面的函数,sms函数
//        sms($phone, $code);
        sms("18395832343","1111");
    }

    public function fuck( $apikey , $mobile , $tplId) {

            $param = [
                'apikey' => "9e94b084e8e568c77747e24ecd9c31ab",
                'mobile' => 18395832343,
                'tpl_id' => 2666078,
                'tpl_value' =>"【宁波捷文】您的验证码是"
            ];

            return post("https://sms.yunpian.com/v2/sms/tpl_single_send.json", params);

    }


}

//下面这个是事先定义好的,接收2个参数
function sms($phone, $code)
{
    header("Content-Type:text/html;charset=utf-8");
    $apikey = "9e94b084e8e568c77747e24ecd9c31ab"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取
    $mobile = $phone; //请用自己的手机号代替
    $text = "【宁波捷文】您的验证码是" . $code;
//    $text = "尊敬的用户,你好,你的你验证码是" . $code;
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
//    echo '<pre>';
//    print_r($array);
// 发送短信
    $data = array('text' => $text, 'apikey' => $apikey, 'mobile' => $mobile);
    $json_data = send($ch, $data);
//    $array = json_decode($json_data, true);
//    echo '<pre>';
//    print_r($array);
}