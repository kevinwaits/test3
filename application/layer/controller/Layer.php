<?php
namespace app\layer\controller;

use think\Controller;

class Layer extends Controller
{
    public function layer() {
            return $this->fetch();
    }

    public function layer_son() {
        return $this->fetch();
    }
}