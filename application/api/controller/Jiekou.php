<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-02
 * Time: 下午 7:45
 */

namespace app\api\controller;
use think\Controller;

class Jiekou extends Controller
{
    public function jiekou(){
        dump($this->request->param(""));
        $arr = array('a'=>'666666','b'=>999999);
        return json_encode($arr);
    }

    public function my_test() {
            $data = [
                'username' => "18395832343",
                'pwd' => "e00e4b20cd24d1ff97ae270a077559ff",
                'content' => "的验证码是987654",
                "mobile"=>"18395832343",
            ];
//            $data  = json_encode($data);
            $headerArray =array("Content-Type：application/x-www-form-urlencoded;charset=utf-8");
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, "http://api.uoleem.com.cn/sms/httpBatchSend");
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($curl);
            curl_close($curl);
            return $output;

    }

    public function my_test2() {

            $headerArray =array("Content-type:application/json;","Accept:application/json");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://sms.yunpian.com/v2/sms/single_send.json");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($url,CURLOPT_HTTPHEADER,$headerArray);
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output,true);
            return $output;

    }

}