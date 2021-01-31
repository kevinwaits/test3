<?php
namespace app\resign\controller;

use think\Controller;

class Home extends Controller
{
    public function home() {
            return $this->fetch();
    }
}