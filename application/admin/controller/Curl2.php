<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/29
 * Time: 9:07
 */

namespace app\admin\controller;

use think\Controller;
use think\db;

class Curl2 extends Controller
{
    public function show() {
        return $this->fetch();
    }

    public function handle() {
        $data = $this->request->param("name");
        dump($data);

        $ch = curl_init();//初始化
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt ($ch, CURLOPT_URL, $data);// 设置要抓取的页面地址
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);// 抓取结果直接返回（如果为0，则直接输出内容到页面）
        curl_setopt($ch, CURLOPT_HEADER, 0); // 不需要页面的HTTP头
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10);
        $re = curl_exec($ch);//执行
        curl_close($ch);//释放资源

        //如果出现中文乱码使用下面代码
        $wcharset = preg_match("/<meta.+?charset=[^\w]?([-\w]+)/i",$re,$temp) ? strtolower($temp[1]):"";
        if($wcharset=="gb2312"){$re = iconv("GBK", "utf-8",$re);}
        //如果出现中文乱码使用下面代码

//        正则找一下拔取的结果
        $x='/<.*?>(.*?)<\/.*?>/';
        preg_match_all($x,$re,$mymatch);
        $arr=$mymatch[0];
        dump($arr);
//        到这里,拔取结束,


//        定义一个删除空白行和空格的函数
        function myTrim($str)
        {
            $search = array(" ","　","\n","\r","\t");
            $replace = array("","","","","");
            return str_replace($search, $replace, $str);
        }
        //执行myTrim函数,和自带的strip_tags函数,去掉文字中的换行,空格等
        for($i=0;$i<count($arr);$i++)
        {
            $arr[$i] = myTrim($arr[$i]);
            $arr[$i] = strip_tags($arr[$i]);
        }
        //去掉文字中的换行,空格等

        // 建立新数组,有效的str放进去,等着分配
        $newarr = [];
        for($i=0;$i<count($arr);$i++)
        {
            if(strlen($arr[$i])>40){
//                $newarr[] = $arr[$i];
                $newarr[$i]["str"] = trim($arr[$i]);
                $newarr[$i]["myclass"] = "s".$i;
            }
        }
        // 建立新数组,有效的str放进去,等着分配

        return $this->fetch();
    }
}