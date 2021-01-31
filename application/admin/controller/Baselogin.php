<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-14
 * Time: 下午 1:14
 */

namespace app\admin\controller;

use think\Controller;
use think\Session;

class Baselogin extends Controller
{
        public function baselogin() {
                return $this->fetch();
        }

        public function session_set() {
               Session::set("name","kevin");
               return Session::get("name");
        }

        public function session_clear() {
                Session::delete("name");
            return Session::get("name");

        }
}