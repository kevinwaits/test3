<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-04
 * Time: 下午 9:32
 */

namespace app\mess\controller;


use think\Controller;

class Call2 extends Controller
{
    public function call2() {
        header('Content-type:text/html;charset=utf-8');
//配置您申请的appkey
        $appkey = "6411ac789b68927ae5abda462f32f641";
//************1.发起回呼************
        $url = "http://op.juhe.cn/huihu/query";
        $params = array(
            "key" => $appkey,//应用APPKEY(应用详细页查询)
            "phone" => "18395832343",//主叫号码，
            "call" => "13296829603",//被叫号码
            "unid" => "kevin1234",//订单号/唯一标识，8-23位字母数字
            "sign" => "684ba2e1a7a04f80c8370135f2b9f562",//校验值，md5(key+openid+unid+phone+call)
        );
        $paramstring = http_build_query($params);
        $content = juhecurl($url,$paramstring);
        $result = json_decode($content,true);
        if($result){
            if($result['error_code']=='0'){
                print_r($result);
            }else{
                echo $result['error_code'].":".$result['reason'];
            }
        }else{
            echo "请求失败";
        }
//**************************************************
    }
}