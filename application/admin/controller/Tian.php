<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-04
 * Time: 下午 7:08
 */

namespace app\admin\controller;

use think\Controller;

class Tian extends Controller
{

    public function getData()
    {
        header('Content-type:text/html;charset=utf-8');
        $appkey = "bc077f7bd446afd2f8607feb02a5b285";
        $url = "http://op.juhe.cn/onebox/weather/query";
        $params = array(
            "cityname" => "宁波",//要查询的城市，如：温州、上海、北京
            "key" => $appkey,//应用APPKEY(应用详细页查询)
            "dtype" => "json",//返回数据的格式,xml或json，默认json
        );
        $paramstring = http_build_query($params);

        //总结接口的用法,上面的部分就是为了包装一个字符串$paramtring,貌似,申请接口的时候,参数只能是字符串
        //下面开始是调用接口,注意juhecurl就是在调用函数,这个函数里调用了接口,其他注释转到该函数地方去看.
        $content = juhecurl($url, $paramstring);
        //现在这个$content已经有了curl返回的结果了,只不过,是一个json格式,需要转换
        $result = json_decode($content, true);
        if ($result) {
            if ($result['error_code'] == '0') {
                dump($result["result"]["data"]["realtime"]["weather"]);
            } else {
                echo $result['error_code'] . ":" . $result['reason'];
            }
        } else {
            echo "请求失败";
        }
    }

    // 文件下载
    public function phone()
    {
        $file_name = "20190412.xlsx";     //下载文件名
//        $file_dir = "./down/";        //下载文件存放目录
        $file_dir = ROOT_PATH . 'public' . DS . 'uploads' . '/' ;
//检查文件是否存在
        if (!file_exists($file_dir . $file_name)) {
            echo "fuckyou";
        } else {
            //以只读和二进制模式打开文件
            $file = fopen($file_dir . $file_name, "rb");
            //告诉浏览器这是一个文件流格式的文件
            Header("Content-type: application/octet-stream");
            //请求范围的度量单位
            Header("Accept-Ranges: bytes");
            //Content-Length是指定包含于请求或响应中数据的字节长度
            Header("Accept-Length: " . filesize($file_dir . $file_name));
            //用来告诉浏览器，文件是可以当做附件被下载，下载后的文件名称为$file_name该变量的值。
            Header("Content-Disposition: attachment; filename=" . $file_name);
            //读取文件内容并直接输出到浏览器
            echo fread($file, filesize($file_dir . $file_name));
            fclose($file);
            exit ();
        }
    }

}



