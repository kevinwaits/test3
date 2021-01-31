<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-15
 * Time: 上午 2:43
 */

namespace app\admin\controller;


use think\Controller;
use think\Session;

class Sessiontest extends Controller
{
    public function set() {
            Sessiontest::set("name","kevin");
            echo Sessiontest::get("name");
    }

    public function get() {
            echo Sessiontest::get("name");
    }

    public function clear() {
            Sessiontest::delete("name");
    }

    public function wen() {
            echo Session("?name");
    }
}