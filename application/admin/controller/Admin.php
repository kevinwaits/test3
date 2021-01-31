<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;


class Admin extends Controller
{
    public function admin() {

//        注意这里的url也是加了参数
//        $url_get="https://cdn.yg1st.com";
//        $res= file_get_contents($url_get);
//        dump($res);
        return $this->fetch();
    }

    public function add() {
        $data = Db::table('main')->where('id',1)->select();
//        dump($data);
        $this->assign("link", $data[0]);
        return $this->fetch();
    }

    public function rec() {
        $data = $this->request->post("");
//        $data  = $this->request->param();
        $data = Db::table('main')->where("id",1)->insert($data);
        dump($data);
    }

    public function list_a() {
        return $this->fetch();
    }

    public function list_b() {
            return $this->fetch();
    }

    public function list_c() {
            return $this->fetch();
    }

    public function single_a() {
            return $this->fetch();
    }

    public function cellphone_a() {
            return $this->fetch();
    }

    public function cellphone_b() {
            return $this->fetch();
    }

    public function cellphone_c() {
            return $this->fetch();
    }

    public function pcResignSimple() {
            return $this->fetch();
    }

    public function pcResignComplex() {
            return $this->fetch();
    }

    public function smsOnly() {
            return $this->fetch();
    }

    public function radio() {
            return $this->fetch();
    }

    public function xxx() {
            echo 1111;
    }

    public function video() {
            return $this->fetch();
    }

    public function video2() {
            return $this->fetch();
    }


}