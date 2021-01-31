<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-01
 * Time: 下午 10:31
 */

namespace app\admin\controller;

use think\Controller;

class Jiekou extends Controller
{
        public function index(){
                $arr = array('a'=>555,'b'=>666);
                $url="http://www.houtai.com/api/jiekou/jiekou";
                $ch = curl_init();
                $data_string=json_encode($arr);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json; charset=utf-8',
                        'Content-Length: ' . strlen($data_string))
                );
                $rec=curl_exec($ch);
                curl_close($ch);
                dump($rec);
        }
}