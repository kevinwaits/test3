<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-17
 * Time: 下午 9:57
 */

namespace app\admin\controller;
header("ACCESS-CONTROL-ALLOW-ORIGIN:*");
use EasyWeChat\Factory;
use think\Controller;
use think\Log;
use think\Session;
use EasyWeChat\Payment\Transfer;
use EasyWeChat\Payment;
class Wefinal extends Controller
{
//    >>>>__construct 和 index分别是初始化,和处理token>>>>>
    private $app;
    private $oauth;
    private $pay;
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
            'notify_url'         => 'http://houtai.kehu.fun/admin/Wefinal/no',
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/admin/Wefinal/login_on',
            ],
        ];
        $this->app = Factory::officialAccount($config);
        $this->oauth= $this->app->oauth;
        $this->pay = Factory::payment($config);
    }
    public function index()
    {
        $this->app->server->push(function ($message) {
            
        });
    }
    //    <<<<<<__construct 和 index分别是初始化,和处理token>

//    >>>>这就是网页授权登录了,login是登录点击,callback是登录成功后的运行
    public function login() {
        if(Session("?name")){
            echo "you have login";
        }else{
            return $this->oauth->redirect();
        }
    }

    public function login_on() {
        $user = $this->oauth->user();
        Session::set("uid",$user["id"]);
        Session::set("name",$user["name"]);
        echo Session::get("uid");
    }
    //    <<<<<这就是网页授权登录了

    public function logout() {
        echo 11111;
        Session::set("uid",null);
        Session::set ("name",null);
        echo Session::get("name");
    }

//    >>>>微信支付
    public function notify() {
//        $config = [
//            // 必要配置
//            'app_id'             => 'wx9d6a08c4c094a2ab',
//            'mch_id'             => '1526709271',
//            'key'                => 'Kevin9494dashabiKevin9494dashabi',   // API 密钥
//            'notify_url'         => 'http://houtai.kehu.fun/admin/Wechatjika/notify',     // 你也可以在下单时单独设置来想覆盖它
//        ];
        $response = $this->pay->handlePaidNotify(function($message, $fail){
            Log::record($message['out_trade_no'],'pay');
            return true; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
        });
        $response->send(); // return $response;
    }

    public function pay() {
//        $config = [
//            'app_id'             => 'wx9d6a08c4c094a2ab',
//            'mch_id'             => '1526709271',
//            'key'                => 'Kevin9494dashabiKevin9494dashabi',   // API 密钥
//            'notify_url'         => 'http://houtai.kehu.fun/admin/Wefinal/no',     // 你也可以在下单时单独设置来想覆盖它
////            'notify_url'         => 'http://houtai.kehu.fun/admin/Wechatjika/notify',     // 你也可以在下单时单独设置来想覆盖它
//        ];
//        $pay = Factory::payment($config);
        $result = $this->pay->order->unify([
            'body' => '测试使用',
            'out_trade_no' => '2019'.rand(10000,99999),
            'total_fee' => 1,
            'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
            'openid' => Session::get('uid'),
        ]);
        $jssdk = $this->app->jssdk->buildConfig(['chooseWXPay']);
        $this->assign("jssdk", $jssdk);
        $config = $this->pay->jssdk->sdkConfig($result['prepay_id']);
        $this->assign("config", $config);
        return $this->fetch();
    }

//    <<<<微信支付

    public function hongbao() {
        $this->app->transfer->toBalance([
            'partner_trade_no' => '1233455', // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => 'ohidY6C5PtGfH1ccIThsPup40hlk',
            'check_name' => 'NO_CHECK', // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
            're_user_name' => '王小帅', // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
            'amount' => 1, // 企业付款金额，单位为分
            'desc' => 'ceshi', // 企业付款操作说明信息。必填
        ]);
    }
}