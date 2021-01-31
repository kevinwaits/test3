<?php

namespace app\mess\controller;


use think\Controller;

class Weather extends Controller
{

    public function getWeather() {
        $appkey = "bc077f7bd446afd2f8607feb02a5b285";
        $city="宁波";
        dump(weather($appkey,$city));
    }


}
 function weather($appkey,$city) {
    header('Content-type:text/html;charset=utf-8');
    $appkey = $appkey;
    $url = "http://op.juhe.cn/onebox/weather/query";
    $params = array(
        "cityname" => $city,//要查询的城市，如：温州、上海、北京
        "key" => $appkey,//应用APPKEY(应用详细页查询)
        "dtype" => "json",//返回数据的格式,xml或json，默认json
    );
    $paramstring = http_build_query($params);
    $content = juhecurl($url,$paramstring);
    $result = json_decode($content,true);
    if($result){
        if($result['error_code']=='0'){
            return ($result["result"]["data"]["realtime"]["weather"]);
        }else{
            echo $result['error_code'].":".$result['reason'];
        }
    }else{
        echo "请求失败";
    }
}