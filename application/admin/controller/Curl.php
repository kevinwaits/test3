<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/30
 * Time: 21:37
 */
//这个是curl的终极笔记,希望以后不会再研究一次curl
/**
 *1,curl可以有get.也可有有post,
 *2,curl 的 get 可以直接用 file_get_contents($url);来代替
 *3,curl 的 get 如果携带参数,直接附在后面,就行跳转一样
 * 4,curl 的标准写法,见下面的第一个例子 curl_standar;
 */

namespace app\admin\controller;
use think\Controller;

class Curl extends Controller
{
    public function curl_standar() {
        //设定一个url>>>
        $url='https://sms.yunpian.com/v2/sms/single_send.json';
//        设定一个url^^^^^^^^^^^
        //包装参数>>>>
        $a = "aaa";
        $b = "bbb";
        $c= "ccc";
        $data=array('a'=>$a,'b'=>$b,'c'=>$c);
        $data_str=http_build_query($data);

        //包装参数^^^^^^^^^^
//        以上都是一样的
//        下面是3中情况,1_直接file_get_contents($url),2_curl_get , 3_curl_post

//        1_直接 file_get_contents
//        注意这里的url加了参数
        $url_get="http://op.juhe.cn/onebox/weather/query?".$data_str;
        $res= file_get_contents($url_get);
        dump($res);
//        1_^^^^^^^^^^^

//        2_curl_get  >>>>>>>>
//        注意这里的url也是加了参数
        $url_get="http://op.juhe.cn/onebox/weather/query?".$data_str;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_get);
        curl_setopt($curl, CURLOPT_HEADER, 1);        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出
        $data = curl_exec($curl);                     //执行命令
        curl_close($curl);                            //关闭URL请求
        dump($data);
//        2_curl_get ^^^^^^^^^^^^


//        3_curl_post
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        dump($result);
//        3_curl_post_^^^^^^^^^^^
    }

//    下面是3种方式获取天气预报的实际演练

    public function get_content(){

        $url='http://op.juhe.cn/onebox/weather/query?';
        $cityname = "宁波";
        $key = "bc077f7bd446afd2f8607feb02a5b285";
        $data=array('cityname'=>$cityname,'key'=>$key,);
        $data_str=http_build_query($data);

        $url_get='http://op.juhe.cn/onebox/weather/query?'.$data_str;
        $res= file_get_contents($url_get);
        dump($res);
    }

    public function curl_get() {
        $url='http://op.juhe.cn/onebox/weather/query?';
        $cityname = "宁波";
        $key = "bc077f7bd446afd2f8607feb02a5b285";
        $data=array('cityname'=>$cityname,'key'=>$key,);
        $data_str=http_build_query($data);

        $url_get="http://op.juhe.cn/onebox/weather/query?".$data_str;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url_get);
        curl_setopt($curl, CURLOPT_HEADER, 1);        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//设置获取的信息以文件流的形式返回，而不是直接输出
        $data = curl_exec($curl);                     //执行命令
        curl_close($curl);                            //关闭URL请求
        dump($data);
    }

    public function curl_post() {
        $url='http://op.juhe.cn/onebox/weather/query';
        $cityname = "宁波";
        $key = "bc077f7bd446afd2f8607feb02a5b285";
        $data=array('cityname'=>$cityname,'key'=>$key,);
        $data_str=http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
        $result = curl_exec($ch);
        dump($result);

    }

//   上面是3中方式获取到了天气预报,^^^^^^^^^^^


//下面演示用curl post发送短信


    public function yunpian_duanxin() {
        $apikey = "9e94b084e8e568c77747e24ecd9c31ab";
        $mobile = "18395832343";
        $text="【宁波捷文】您的验证码是1234";
        $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        dump($result);
    }
}