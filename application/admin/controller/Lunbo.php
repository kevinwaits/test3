<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/29
 * Time: 9:28
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;

class Lunbo extends Controller
{
    public function show() {
        return $this->fetch();
    }
}