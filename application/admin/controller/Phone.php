<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-18
 * Time: 上午 1:25
 */

namespace app\admin\controller;
use think\Controller;
class Phone extends Controller
{
    public function phone() {
            return $this->fetch();
    }

    public function luyin() {
            return $this->fetch();
    }
}