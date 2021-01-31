<?php
namespace app\phone\controller;

use think\Controller;

class Phone extends Controller
{
    public function phone() {
            return $this->fetch();
    }

    public function phone_a() {
            return $this->fetch();
    }

    public function phone_b() {
            return $this->fetch();
    }

    public function phone_c() {
            return $this->fetch();
    }

}