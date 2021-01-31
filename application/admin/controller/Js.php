<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/12
 * Time: 13:37
 */

namespace app\admin\controller;

use think\Controller;

class Js extends Controller
{
    public function index() {
            return $this->fetch();
    }

    public function roll() {
            return $this->fetch();
    }

    public function pad() {
            return $this->fetch();
    }
}