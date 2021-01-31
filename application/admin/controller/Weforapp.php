<?php

namespace app\admin\controller;
header("ACCESS-CONTROL-ALLOW-ORIGIN:*");
use EasyWeChat\Factory;
use think\Controller;
use think\Log;
use think\Session;
use EasyWeChat\Payment\Transfer;
use EasyWeChat\Payment;
use think\Db;
class Weforapp extends Controller
{

    public function applogin() {
        $u_nickname = $this->request->param("u_nickname");
        $u_weixinid = $this->request->param("u_weixinid");
        $u_imgurl = $this->request->param("u_imgurl");
        $find_id = Db::table('applogin')->where("u_weixinid", $u_weixinid)->find();
        if($find_id){
            Db::table('applogin')->where("u_weixinid", $u_weixinid)->update(["status"=>1]);
            Session::set("id",$u_weixinid);
            $shuzu=["msg"=>"ok"];
            $js_data=json_encode($shuzu);
            return $js_data;
        }else{
            Db::table('applogin')->insert(["u_nickname"=>$u_nickname,"u_weixinid"=>$u_weixinid,"u_imgurl"=>$u_imgurl,"status"=>1]);
            Session::set("id",$u_weixinid);
            $shuzu=["msg"=>"ok"];
            $js_data=json_encode($shuzu);
            return $js_data;
        }
    }

    //    <<<<<这就是网页授权登录了
    public function logout() {
        echo 11111;
        Session::set("uid",null);
        Session::set ("name",null);
        echo Session::get("name");
    }

//    >>>>微信支付





//    <<<<微信支付


}