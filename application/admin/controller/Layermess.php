<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-04-13
 * Time: 下午 9:09
 */

namespace app\admin\controller;

use think\Controller;

class Layermess extends Controller
{
    public function layermess() {
            return $this->fetch();
    }

    public function zichuangkou() {
            return $this->fetch();
    }

    public function layerform() {
            return $this->fetch();
    }
}