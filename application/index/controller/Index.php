<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{

    public function testdate() {
        return $this->fetch();
    }

    public function test() {
            echo 1111;
    }
}
