<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-14
 * Time: 下午 5:50
 */

namespace app\admin\controller;
use EasyWeChat\Factory;
use think\Controller;
use think\Log;
use think\Session;
class Wechatjika extends Controller
{
    private $app;
    private $oauth;
    public function __construct()
    {
        parent::__construct();
//        $wechatConfig = Config::get('wechat.');
        $config = [
            "app_id" => "wx9d6a08c4c094a2ab",
            "secret" => "4c30db2bf3125ca99c9412a32db8192a",
            "token" => "kevin",
            'mch_id'=> '1526709271',
            'key'=> 'Kevin9494dashabiKevin9494dashabi',   // API 密钥
//            'response_type' => 'array',
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/admin/Wechatjika/callBack',
            ],
        ];
        $this->app = Factory::officialAccount($config);
        $this->oauth= $this->app->oauth;
    }

    public function index() {
        $this->app->server->push(function ($message){

        });
// 将响应输出
        return $this->app->server->serve()->getContent();
    }

    public function payshow() {
            return $this->fetch();
    }

    public function login() {
            if(Session("?name")){
                    echo "you have login";
            }else{
            return $this->oauth->redirect();
            }
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
    }

    public function logout() {
            echo Session::delete("name");
    }

    public function callback() {
        $user = $this->oauth->user();
        Session::set("uid",$user["id"]);
        Session::set("name",$user["name"]);
        $this->redirect("Wechat/haslogin");
//        $_SESSION['wechat_user'] = $user->toArray();
//        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
//        header('location:'. $targetUrl); // 跳转到 user/profile
    }

    public function haslogin() {
//            echo "you are in has login";
            echo Session::get("uid");
//            echo Session::get("name");
    }

    public function notify() {

        $config = [
            // 必要配置
            'app_id'             => 'wx9d6a08c4c094a2ab',
            'mch_id'             => '1526709271',
            'key'                => 'Kevin9494dashabiKevin9494dashabi',   // API 密钥
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
//            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
//            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
            'notify_url'         => 'http://houtai.kehu.fun/admin/Wechatjika/notify',     // 你也可以在下单时单独设置来想覆盖它
        ];

        $pay = Factory::payment($config);

        $response = $pay->handlePaidNotify(function($message, $fail){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            Log::record($message['out_trade_no'],'pay');

            return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了

        });

        $response->send(); // return $response;
    }

    public function pay() {

        $config = [
            // 必要配置
            'app_id'             => 'wx9d6a08c4c094a2ab',
            'mch_id'             => '1526709271',
            'key'                => 'Kevin9494dashabiKevin9494dashabi',   // API 密钥
            // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
//            'cert_path'          => 'path/to/your/cert.pem', // XXX: 绝对路径！！！！
//            'key_path'           => 'path/to/your/key',      // XXX: 绝对路径！！！！
            'notify_url'         => 'http://houtai.kehu.fun/admin/Wechatjika/notify',     // 你也可以在下单时单独设置来想覆盖它
        ];

        $pay = Factory::payment($config);

        $result = $pay->order->unify([
            'body' => '腾讯充值中心-QQ会员充值',
            'out_trade_no' => '20150806125346'.rand(1,3),
            'total_fee' => 1,
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => Session::get('uid'),
        ]);

        $jssdk = $this->app->jssdk->buildConfig(['chooseWXPay']);
        $this->assign("jssdk", $jssdk);

        $config = $pay->jssdk->sdkConfig($result['prepay_id']);

        $this->assign("config", $config);


        return $this->fetch();

    }




}