<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-13
 * Time: 下午 11:05
 */

namespace app\admin\controller;

use think\Controller;

class Cellphone extends Controller
{
        public function cellphone() {
                return $this->fetch();
        }
}