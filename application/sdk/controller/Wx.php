<?php

namespace app\sdk\controller;

use think\Controller;
use think\Db;
use think\Session;
class Wx extends Controller
{
    protected $appid = 'wx9d6a08c4c094a2ab';
    protected $secret = '4c30db2bf3125ca99c9412a32db8192a';

    public function getserver() {
            dump($_SERVER);
    }

//    public function getAccessToken(){
//        //定义文件名称
//        $name = 'token_' . md5($this->appid . $this->secret);
//        //定义存储文件路径
//        $filename = __DIR__ . '/cache/' . $name . '.php';
//        //判断文件是否存在,如果存在,就取出文件中的数据值,如果不存在,就向微信端请求
//        if (is_file($filename) && filemtime($filename) + 7100 > time()){
//            $result = include $filename;
//            //定义需要返回的内容$data
//            $data = $result['access_token'];
//        }else{
//            //        https请求方式: GET
////        https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
//            //调用curl方法完成请求
//            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9d6a08c4c094a2ab&secret=4c30db2bf3125ca99c9412a32db8192a';
//            $result = $this->curl($url);
//            //将返回得到的json数据转成php数组
//            $result = json_decode($result,true);
//            //将内容写入文件中
/*            file_put_contents($filename,"<?php\nreturn " . var_export($result,true) . ";\n?>");*/
//            //定义需要返回的内容
//            $data = $result['access_token'];
//        }
//        //将得到的access_token的值返回
//        return $data;
//    }

    public function getJsapiTicket(){
        //存入文件中,定义文件的名称和路径
        $name = 'ticket_' . md5($this->appid . $this->secret);
        //定义存储文件路径
        $filename = __DIR__ . '/cache/' . $name . '.php';
        //判断是否存在临时票据的文件,如果存在,就直接取值,如果不存在,就发送请求获取并保存
        if (is_file($filename) && filemtime($filename) + 7100 > time()){
            $result = include $filename;
        }else{
            //定义请求地址
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this
                    ->getAccessToken().'&type=jsapi';
            //使用curl方法发送请求,获取临时票据
            $result = $this->curl($url);
            //转换成php数组
            $result = json_decode($result,true);
            //将获取到的值存入文件中
            file_put_contents($filename,"<?php\nreturn " . var_export($result,true) . ";\n?>");

        }
        //定义返回的数据
        $data = $result['ticket'];
        //将得到的临时票据结果返回
        return $data;
    }
//    签名在下面
    public function sign(){
        //需要定义4个参数,分别包括随机数,临时票据,时间戳和当前url地址
        $nonceStr = $this->makeStr();
        $ticket = $this->getJsapiTicket();
        $time = time();
        //组合url
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        //将4个参数放入一个数组中
        $arr = [
            'noncestr=' . $nonceStr,
            'jsapi_ticket=' . $ticket,
            'timestamp=' . $time,
            'url=' . $url,
        ];
        //对数组进行字段化排序
        sort($arr,SORT_STRING);
        //对数组进行组合成字符串
        $string = implode('&',$arr);
        //将字符串加密生成签名
        $sign = sha1($string);
        //由于调用签名方法的时候不只需要签名,还需要生成签名的时候的随机数,时间戳,所以我们应该返回由这些内容组成的一个数组
        $reArr = [
            'appId' => $this->appid,
            'timestamp' => $time,
            'nonceStr' => $nonceStr,
            'signature' => $sign,
            'url' => $url,
        ];
        //将数组返回
        return $reArr;
    }
//    实务中没有使用markstr
    protected function makeStr(){
        //定义字符串组成的种子
        $seed = '1qaz2wsx3edc4rfv5tgb6yhn7ujm8ik9ol0p';
        //通过循环来组成一个16位的随机字符串
        //定义一个空字符串 用来接收组合成的字符串内容
        $str = '';
        for ($i = 0;$i < 16; $i++){
            //定义一个随机数
            $num = rand(0,strlen($seed) - 1);
            //循环连接随机生成的字符串
            $str .= $seed[$num];
        }
        //将随机数返回
        return $str;
    }
//    public function curl($url,$field = []){
    public function curl($url){
//        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9d6a08c4c094a2ab&secret=4c30db2bf3125ca99c9412a32db8192a';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        //判断是否为post请求方式,如果传递了第二个参数,就代表是post请求,如果么有传递,第二个参数为空,就是get请求
        if (!empty($field)){
            curl_setopt($ch,CURLOPT_TIMEOUT,30);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$field);
        }
        $data = '';
        if (curl_exec($ch)){
            $data = curl_multi_getcontent($ch);
        }
        curl_close($ch);
        return $data;
    }

    public function curl_token() {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9d6a08c4c094a2ab&secret=4c30db2bf3125ca99c9412a32db8192a';
        $filename = __DIR__ . '/cache/'.'token.php';
        if(is_file($filename) && filemtime($filename) +7000 > time()){
            $my_token= include $filename;
        }else{
        $json_token=  $this->curl($url);
        $my_token=json_decode($json_token,true)["access_token"];
/*        file_put_contents($filename,"<?php\nreturn " . var_export($result,true) . ";\n?>");*/
        file_put_contents($filename,"<?php\n return '" . $my_token . "';\n?>");
        }
//        dump(json_decode($my_token,true));
        return $my_token;
    }

    public function curl_ticket() {
        $url='https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->curl_token().'&type=jsapi';
//        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9d6a08c4c094a2ab&secret=4c30db2bf3125ca99c9412a32db8192a';
        $filename = __DIR__ . '/cache/'.'ticket.php';
        if(is_file($filename) && filemtime($filename) +7000 > time()){
            $my_ticket= include $filename;
        }else{
            $json_ticket=  $this->curl($url);
            $my_ticket=json_decode($json_ticket,true)["ticket"];
            file_put_contents($filename,"<?php\n return '" . $my_ticket . "';\n?>");
        }
//        dump(json_decode($my_token,true));
        return $my_ticket;
    }

    public function get_sign() {
        //需要定义4个参数,分别包括随机数,临时票据,时间戳和当前url地址
        $nonceStr = rand(100000,999999);
        $ticket = $this->curl_ticket();
        $time = time();
        //组合url
        $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        //将4个参数放入一个数组中
        $arr = [
            'noncestr=' . $nonceStr,
            'jsapi_ticket=' . $ticket,
            'timestamp=' . $time,
            'url=' . $url,
        ];
        //对数组进行字段化排序
        sort($arr,SORT_STRING);
        //对数组进行组合成字符串
        $string = implode('&',$arr);
        //将字符串加密生成签名
        $sign = sha1($string);
        //由于调用签名方法的时候不只需要签名,还需要生成签名的时候的随机数,时间戳,所以我们应该返回由这些内容组成的一个数组
        $reArr = [
            'appId' => $this->appid,
            'timestamp' => $time,
            'nonceStr' => $nonceStr,
            'signature' => $sign,
            'url' => $url,
        ];
        //将数组返回
        return $reArr;
    }

    public function show() {
        $result=$this->get_sign();
        $this->assign("appId", $result["appId"]);
        $this->assign("timestamp", $result["timestamp"]);
        $this->assign("nonceStr", $result["nonceStr"]);
        $this->assign("signature", $result["signature"]);
        $this->assign("url", $result["url"]);
            return $this->fetch();
    }

    public function get_upload() {
        $url = $_POST["url"];
        $str = date('YmdHis').time().'.amr';//微信录音文件名 扩展名为 .amr
        $targetName =  './'.$str;   //保存目录
        downAndSaveFile($url,$targetName); //保存
        echo 1;
        //根据URL地址，下载文件
    }

    public function check() {
            dump( Session::get("url"));
    }

    public function upload_do()
    {
//        $file = request()->file('file');  //注意这里的 file是 form里 input的name
//        $file = request();  //注意这里的 file是 form里 input的name
        $serverId = $this->request->post("serverId");
        $data = Db::table('mess')->insert(["name"=>$serverId]);
        $my_url="http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$this->curl_token()."&media_id=".$serverId;
        Db::table('mess')->insert(["name"=>$my_url]);
//        $filename = $my_url.'.amr'; //获取文件名称
        $dir ="./public/uploads";  //相对于网站根目录的下载目录路径

        ob_start();
        readfile($my_url);
        $img  = ob_get_contents();
        ob_end_clean();
        $size = strlen($img);
        $fp = fopen($dir, 'a');
        fwrite($fp, $img);
        fclose($fp);

//        $data = Db::table('mess')->insert(["voice"=>$file]);
//        if (empty($file)) {
//            $this->error('请选择上传文件');
//        }
        // 移动到框架应用根目录/public/uploads/ 目录下
//        if ($file) {
        //注意 uniqid的用法,如果没有这个uniqid,会一个文件,生成一个文件夹
        //注意后面的路径的写法
//            $info = $file->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads/img');
//            if ($info) {
//                //下面是获取文件名字的方法,前面加了一个路径,实务中可以去掉
//                $inputFileName = './uploads/img/' . $info->getFilename();
//                echo $inputFileName;
//            } else {
//                echo $file->getError();
//            }
//        }
    }

    public function download_test() {
        $my_url="http://file.api.weixin.qq.com/cgi-bin/media/get?
        access_token=20_yJm7GPWfX5uYRTi-H8-9OqXMl7QGpXO-rOjBLjae
        F0wcqbjEP50RpCfgOzzUgSPd5yQ2sJu_SN37U23Dt_5qcHWYOy-nntN2
        GUMiKj7HwY78v8NTLaKZ12IFvdGamDgGRXx9rqd4pDkNHOjwMZMdAAAER
        E&media_id=g205w5BlAalWMshFwSbYC650VLbHR6oUvtcFbfNJ22sH8c2HMKQz6VU-0FH6i0dm";
//        Db::table('mess')->insert(["name"=>$my_url]);
//        $filename = $my_url.'.amr'; //获取文件名称
        $dir ="./public/uploads";  //相对于网站根目录的下载目录路径

        $file = fopen($my_url,"r");
        $file_name="g205w5BlAalWMshFwSbYC650VLbHR6oUvtcFbfNJ22sH8c2HMKQz6VU-0FH6i0dm.amr";
        //4. 声明下载文件，请求头的设置
        header("Content-type:application/octet-stream"); // 文件类型
        header("Accept-Ranges:bytes");//可以理解为请求范围的度量单位
        header("Accept-Length: ".filesize($my_url.$file_name));//表示接收的文件大小
        header("Content-Disposition: attachment;filename=".$file_name);//这个名称就是下载时显示的文件名称

        //5.输出文件内容
        echo fread($file,filesize($my_url.$file_name));
        exit();

    }

}

//测试获取access_token值的方法
//$obj = new Wx();
//$data = $obj->getAccessToken();
//echo $data;

//测试获取jsapiticket方法
//$obj = new Wx();
//$data = $obj->getJsapiTicket();
//echo $data;

//测试生成签名方法
//$obj = new Wx();
//$data = $obj->sign();
//echo '<pre>';
//print_r($data);

?>