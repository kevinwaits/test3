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
use think\Session;
class Wechat extends Controller
{
    private $app;
    private $oauth;
    public function __construct()
    {
//        $wechatConfig = Config::get('wechat.');
        $config = [
            "app_id" => "wxc22ebc87d060f7ca",
            "secret" => "952613933c0784e8efbbb5ae03e0c069",
            "token" => "kevin",
//            'response_type' => 'array',
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/admin/Wechat/callBack',
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
//
//        $targetUrl = empty($_SESSION['target_url']) ? '/' : $_SESSION['target_url'];
//
//        header('location:'. $targetUrl); // 跳转到 user/profile
    }

    public function haslogin() {
//            echo "you are in has login";
            echo Session::get("name");
    }


}